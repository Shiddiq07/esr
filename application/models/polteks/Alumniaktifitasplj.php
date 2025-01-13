<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Alumniaktifitascollege.php';

class Alumniaktifitasplj extends Alumniaktifitascollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'alumni_aktifitas';
	public $primaryKey = 'id';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}

}

/* End of file Alumniaktifitasplj.php */
/* Location: ./application/models/colleges/Alumniaktifitasplj.php */ ?>