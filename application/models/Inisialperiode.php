<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Inisialperiode extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/inisialperiodecollege',
			'polteks/inisialperiodeplj'
		]);
	}

	public function getCurrentPeriode()
	{
		return $this->{'inisialperiode' . $this->src}->getCurrentPeriode();
	}

	public function getAllPeriode()
	{
		return $this->{'inisialperiode' . $this->src}->getAllPeriode();
	}
}
