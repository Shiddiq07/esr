<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/colleges/Permintaancollege.php';

class Permintaanplj extends Permintaancollege
{
	protected $database = 'plj';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'permintaan';
	public $primaryKey = 'id_permintaan';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}
}