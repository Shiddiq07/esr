<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gajikonfigcollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'report_gaji_konfig';
	public $primaryKey = 'id_konfig';
	public $soft_delete = false;

	const FLAG_AKTIF = 1;
	const FLAG_NON_AKTIF = 0;

	public function __construct()
	{
		parent::__construct();
	}

	public function getListSkala()
	{
		return $this->findAll(['flag' => self::FLAG_AKTIF]);
	}

}