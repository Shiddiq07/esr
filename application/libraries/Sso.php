<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sso
{
	protected $ci;
	protected $token;
	protected $token_refresh;

	public function __construct($token)
	{
        $this->ci =& get_instance();

        if (empty($this->ci->curly)) {
        	$this->ci->load->library('curly');
        }

        $this->ci->load->model([
        	'rbac/menu',
        ]);

        $this->token = $token;
	}

	public function validate($relog = true)
	{
		$url = SSO_URL .'/auth/validate';

		$validate = $this->ci->curly->post($url, [
			'client_id' => SSO_CLIENT_ID,
			'client_secret' => SSO_CLIENT_SECRET,
			'token_refresh' => $this->token_refresh,
		], [
			'Authorization: Bearer ' . $this->token,
            // 'Accept: application/json',
		]);

		if (empty($validate) || !$validate['status']) {
			return false;
		}

		$data = $validate['data'];

		if (empty($data['identity']['username'])) {
			return false;
		}

		if ($relog === true) {
			$this->ci->session->set_userdata($data);
			$this->ci->session->set_userdata([
				'status_login' => 'loggedIn',
				'menus' => $this->ci->menu->getMenu()
			]);

		} else {
			return $validate;
		}

		return true;
	}

	public function refresh()
	{
		$url = SSO_URL .'/auth/refresh';

		$refresh = $this->ci->curly->post($url, [
			'client_id' => SSO_CLIENT_ID,
			'client_secret' => SSO_CLIENT_SECRET,
			'token' => $this->token,
		], [
			'Authorization: Bearer ' . $this->token_refresh
		]);

		if (empty($refresh) || !$refresh['status']) {
			return false;
		}

		$data = $refresh['meta'];

		if (empty($data)) {
			return false;
		}

		$this->ci->session->set_userdata([
			'token' => $data['token'],
			'token_refresh' => $data['token_refresh'],
			'token_expiry' => $data['expiry']
		]);

		return true;
	}

	public function logout()
	{
		$url = SSO_URL .'/auth/logout';

		$logout = $this->ci->curly->post($url, [
			'client_id' => SSO_CLIENT_ID,
			'client_secret' => SSO_CLIENT_SECRET
		], [
			'Authorization: Bearer ' . $this->token,
		]);

		if (empty($logout) || !$logout['status']) {
			return false;
		}

		return true;
	}

	public function setTokenRefresh($token)
	{
		$this->token_refresh = $token;
	}
}

/* End of file Sso.php */
/* Location: ./application/libraries/Sso.php */

