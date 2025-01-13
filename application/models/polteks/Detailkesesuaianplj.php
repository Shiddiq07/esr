<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Detailkesesuaiancollege.php';

class Detailkesesuaianplj extends Detailkesesuaiancollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'kpi_detail_kesesuaian';
	public $primaryKey = 'idh';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}
}