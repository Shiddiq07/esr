<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_CronController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			show_error('Akses secara langsung tidak diizinkan');
		}
	}

}

/* End of file MY_Cron.php */
/* Location: ./application/core/MY_Cron.php */
