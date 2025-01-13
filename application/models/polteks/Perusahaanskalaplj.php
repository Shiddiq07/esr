<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Perusahaanskalacollege.php';

class Perusahaanskalaplj extends Perusahaanskalacollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'perusahaan_skala';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
		]);
	}
}

/* End of file Perusahaanskalaplj.php */
/* Location: ./application/models/colleges/Perusahaanskalaplj.php */