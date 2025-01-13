<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inisialperiodecollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'inisialperiode';
	public $primaryKey = 'periode';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
		]);
	}
	
	public function getCurrentPeriode()
	{
		return $this->find()
				->order_by('periode', 'desc')
				->get()->row_array();
	}

	public function getAllPeriode()
	{
		return $this->findAll();
	}
}

/* End of file Inisialtacollege.php */
/* Location: ./application/models/colleges/Inisialtacollege.php */