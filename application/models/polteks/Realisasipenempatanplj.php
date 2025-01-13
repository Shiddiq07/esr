<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Realisasipenempatancollege.php';

class Realisasipenempatanplj extends Realisasipenempatancollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'realisasi_penempatan';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'polteks/cabangplj',
			'polteks/jurusancabangplj',
		]);

		$this->cabang = $this->cabangplj;
		$this->jurusan_cabang = $this->jurusancabangplj;
	}
}
