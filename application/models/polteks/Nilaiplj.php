<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Nilaicollege.php';

class Nilaiplj extends Nilaicollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'nilai';
	public $primaryKey = 'id';
	public $soft_delete = false;
}

/* End of file Nilaiplj.php */
/* Location: ./application/models/colleges/Nilaiplj.php */