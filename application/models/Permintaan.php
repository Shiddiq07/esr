<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Permintaan extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/permintaancollege',
			'polteks/permintaanplj'
		]);
	}

	public function getListTahun()
	{
		return $this->{'permintaan' . $this->src}->getListTahun();
	}

	public function getRecapByTahun($tahun_angkatan, $group_cabang = true)
	{
		return $this->{'permintaan' . $this->src}->getRecapByTahun($tahun_angkatan, $group_cabang);
	}

	public function getGraphNasional($tahun_permintaan, $kode_cabang = null)
	{
		return $this->{'permintaan' . $this->src}->getGraphNasional($tahun_permintaan, $kode_cabang);
	}
}
