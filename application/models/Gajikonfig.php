<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Gajikonfig extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/gajikonfigcollege',
			'polteks/gajikonfigplj'
		]);
	}

	public function getListSkala()
	{
		return $this->{'gajikonfig' . $this->src}->getListSkala();
	}
}
