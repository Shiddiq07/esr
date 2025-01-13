<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Perusahaancollege.php';

class Perusahaanplj extends Perusahaancollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'perusahaan';
	public $primaryKey = 'id_perusahaan';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'polteks/perusahaanskalaplj',
		]);

		$this->perusahaan_skala = $this->perusahaanskalaplj;
	}
}

/* End of file Perusahaanplj.php */
/* Location: ./application/models/Perusahaanplj.php */