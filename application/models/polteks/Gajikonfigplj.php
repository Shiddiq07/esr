<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Gajikonfigcollege.php';

class Gajikonfigplj extends Gajikonfigcollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'report_gaji_konfig';
	public $primaryKey = 'id_konfig';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}

}