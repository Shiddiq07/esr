<?php

class AuthHelper
{
	const STATUS_LOGIN = 'loggedIn';
	const STATUS_LOCKED = 'locked';

	protected $CI;
	private $allowed;

	public function __construct() {
		$this->CI =& get_instance();
		$this->setAllowedRoutes();

		$this->CI->load->model([
			'rbac/allowed',
			'rbac/permission',
			'rbac/authassignment',
			'rbac/authitem',
		]);
	}

	/**
	 * [isGuest description]
	 * @return boolean [description]
	 */
	public function isGuest()
	{
		return empty($this->CI->session->userdata('status_login'));
	}

	/**
	 * [checkLogin description]
	 * @param  string $value [description]
	 * @return void
	 */
	public function checkLogin()
	{
		$status = $this->CI->session->userdata('status_login');

     	if (
			strpos(uri_string(), 'api/') === false
			&& strpos(uri_string(), 'commands/') === false
			&& !$this->CI->input->is_cli_request()
		) {
			# IDS, Bolehkan akses tanpa login jika route url masuk kategori allowed
		  	if ($this->isGuest() && !in_array(uri_string(), $this->allowed)) {
		        if (uri_string() != 'login' && uri_string() != 'site/login'){

		        	if (!empty($_SERVER['QUERY_STRING'])) {
			            $uri = uri_string() . '?' . $_SERVER['QUERY_STRING'];
			        } else {
			            $uri = uri_string();
			        }
			        $this->CI->session->set_userdata('redirect', $uri);

		            $this->CI->session->set_flashdata('info', 'Silahkan login kedalam aplikasi');
		            return redirect('site/login');
		        }
		    } elseif ($status === self::STATUS_LOCKED) {
		    	if (
		    		uri_string() != 'site/lock' 
		    		&& uri_string() != 'lock' 
		    		&& uri_string() != 'site/logout'
		    	) {

		            $this->CI->session->set_flashdata('info', 'Halaman terkunci, silahkan login');
		            return redirect('site/lock');
		        }
		    }
		}

		// Auto refresh token sso using token refresh if expired
		if (
			$this->CI->session->userdata('sso') === true
			&& uri_string() != 'site/logout'
		) {
			$token_expiry = $this->CI->session->userdata('token_expiry');

			if (time() > $token_expiry) {
				$this->CI->load->library('sso', $this->CI->session->userdata('token'));

				$this->CI->sso->setTokenRefresh($this->CI->session->userdata('token_refresh'));

				// Refresh Token
				if (!$this->CI->sso->refresh()) {
					$this->CI->session->set_flashdata('info', 'SSO Token expired, please try to login again.');
					redirect('/site/logout', 'refresh');
				}
			}
		}
	}

	public function checkPermission()
	{
		$session = $this->CI->session->userdata();
		$current_route = $this->CI->helpers->getCurrentSite();
		$current_route_2 = uri_string();

		if (substr($current_route, 0, 1) == '/') {
            $current_route = substr($current_route, 1);
        }

		if (
			in_array($current_route, $this->allowed)
			|| in_array($current_route_2, $this->allowed)
			|| strpos(uri_string(), 'api/') !== false
		) {
			return true;
		}

		if (!empty($session['status_login']) && $session['status_login'] === self::STATUS_LOGIN) {
			$groups = $session['group_id'];
			$routes = $this->CI->helpers->getRoutesByGroup($groups);

			if (in_array($current_route, $routes) || in_array($current_route_2, $routes)) {
				return true;
			} else {
				return $this->redirectUnPermissioned($current_route);
			}
		}
	}

	private function setAllowedRoutes()
	{
		$allowed = $this->CI->allowed->getAll();
		$allowed_routes = [];

		if ($allowed) {
			$allowed_routes = array_column($allowed, 'allowed');
		}

		$this->allowed = $allowed_routes;
	}

	/**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param  User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess()
    {
        if ($this->isGuest()) {
			return redirect('site/login');
        } else {
            return show_error('Anda tidak memiliki hak akses ke halaman ini', 401);
        }
    }

    protected function redirectUnPermissioned($route)
    {
    	$model = $this->CI->authitem->findOne(['name' => $route]);
    	if ($model) {
    		return $this->denyAccess();
    	}


        return show_error('Halaman tidak ditemukan.', 404);
    }
}
