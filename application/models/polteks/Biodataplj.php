<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Biodatacollege.php';

class Biodataplj extends Biodatacollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'biodata';
	public $primaryKey = 'nim';
	public $soft_delete = false;

	protected $jurusan_cabang;
	protected $model_cabang;
	protected $student_website = 'plj';

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'polteks/jurusancabangplj',
			'polteks/cabangplj'
		]);

		$this->jurusan_cabang = $this->jurusancabangplj;
		$this->model_cabang = $this->cabangplj;
	}
}

/* End of file Biodataplj.php */
/* Location: ./application/models/Biodataplj.php */