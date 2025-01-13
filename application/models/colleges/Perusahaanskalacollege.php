<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaanskalacollege extends MY_Model
{
	protected $database = 'college';
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
	
	public function getListSkalas()
	{
		$model = $this->findAll();

		return array_column($model, 'skala', 'id');
	}
}

/* End of file Inisialtacollege.php */
/* Location: ./application/models/colleges/Inisialtacollege.php */