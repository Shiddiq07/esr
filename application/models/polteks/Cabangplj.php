<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Cabangcollege.php';

class Cabangplj extends Cabangcollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'cabang';
	public $primaryKey = 'kodecabang';
	public $soft_delete = false;

	protected $kelompok_aktif = 'aktif';

	public function __construct()
	{
		parent::__construct();
	}

}