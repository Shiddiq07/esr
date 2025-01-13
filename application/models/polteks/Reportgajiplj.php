<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Reportgajicollege.php';

class Reportgajiplj extends Reportgajicollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'report_gaji_rekap';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}

}

/* End of file Reportgajiplj.php */
/* Location: ./application/models/colleges/Reportgajiplj.php */ ?>