<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Biodatastatuscollege.php';

class Biodatastatusplj extends Biodatastatuscollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'biodata_status_mhs';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

/* End of file BiodataStatusCollege.php */
/* Location: ./application/models/BiodataStatusCollege.php */