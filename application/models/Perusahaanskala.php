<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Perusahaanskala extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/perusahaanskalacollege',
			'polteks/perusahaanskalaplj'
		]);
	}

	public function getListSkalas()
	{
		return $this->{'perusahaanskala' . $this->src}->getListSkalas();
	}
}
