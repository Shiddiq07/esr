<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Reportgaji extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/reportgajicollege',
			'polteks/reportgajiplj'
		]);
	}

	public function getListTahunAngkatan()
	{
		return $this->{'reportgaji' . $this->src}->getListTahunAngkatan();
	}

	public function getListTahunValidasi()
	{
		return $this->{'reportgaji' . $this->src}->getListTahunValidasi();
	}

	public function getRekapNasional($tahun_angkatan)
	{
		return $this->{'reportgaji' . $this->src}->getRekapNasional($tahun_angkatan);
	}

	public function getRekapByCabang($tahun_angkatan, $cabang)
	{
		return $this->{'reportgaji' . $this->src}->getRekapByCabang($tahun_angkatan, $cabang);
	}

	public function getListCabang($tahun_angkatan = null)
	{
		return $this->{'reportgaji' . $this->src}->getListCabang($tahun_angkatan);
	}
}
