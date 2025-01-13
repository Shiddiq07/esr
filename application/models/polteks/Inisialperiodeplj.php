<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Inisialperiodecollege.php';

class Inisialperiodeplj extends Inisialperiodecollege
{
	protected $database = 'plj';
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
}

/* End of file Inisialtacollege.php */
/* Location: ./application/models/colleges/Inisialtacollege.php */