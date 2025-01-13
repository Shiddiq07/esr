<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Jurusancabangcollege.php';

class Jurusancabangplj extends Jurusancabangcollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'jurusancabang';
	public $primaryKey = null;
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
}

/* End of file Jurusancabangplj.php */
/* Location: ./application/models/Jurusancabangplj.php */