<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'form/formlogin'
		]);
	}

	public function actionIndex()
	{
		$this->layout->title = 'Home';

		$this->layout->view_js = '_index_js';

		$this->layout->render('index', []);
	}

	public function actionLogin()
	{
		$model = new Formlogin;

		if ($post = $this->input->post('Formlogin')) {
			$this->formlogin->setAttributes($post);
			
			if ($this->formlogin->login()) {
				if ($this->session->has_userdata('redirect')) {
		            return redirect($this->session->redirect);
		        } else {
					return redirect('/site','refresh');
		        }
			}
		}

		$this->layout->layout = 'login';
		$this->layout->title = 'Login';
		$this->layout->render('login', [
			'model' => $model,
			'error' => $this->formlogin->getErrors()
		]);
	}

	public function actionLogout()
	{
		$user_data = $this->session->all_userdata();

		// Logout SSO
		if (!empty($user_data['token'])) {
			$token = $user_data['token'];
			$token_refresh = $user_data['token_refresh'];

			$this->load->library('sso', $token);

			$this->sso->logout();
		}

		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}

		if ($this->input->get('hris') == 'true') {
			return redirect(HRIS_URL . '/site/logout?token='. SSO_CLIENT_ID);
		}

		$this->session->sess_destroy();
		return redirect('/site/login');
	}

	public function actionRefreshCsrf()
	{
		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode([
	        	'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
	        ]));
	}

	public function actionNotFound()
	{
		// code...
	}

	public function actionSsoCallback()
	{
		$token = $this->input->get('token');
		$token_refresh = $this->input->get('token_refresh');

		if (!$token) {
			show_error('Halaman tidak valid', 403);exit();
		}

		$this->session->set_userdata([
			'token' => $token,
			'token_refresh' => $token_refresh,
			'token_expiry' => $this->input->get('expiry'),
			'sso' => true,
		]);

		$this->load->library('sso', $token);

		if (!$this->sso->validate()) {
			return redirect('/site/logout', 'refresh');
		}

		return redirect('/site', 'refresh');
	}

}

/* End of file SiteController.php */
/* Location: ./application/controllers/SiteController.php */
