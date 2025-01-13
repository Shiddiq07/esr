<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Realisasipenempatan extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/realisasipenempatancollege',
			'polteks/realisasipenempatanplj'
		]);
	}

	public function getListTahunAngkatan($kode_cabang = null)
	{
		return $this->{'realisasipenempatan' . $this->src}->getListTahunAngkatan($kode_cabang);
	}

	public function getRecap($tahun_angkatan, $tanggal_awal = '', $tanggal_akhir = '')
	{
		return $this->{'realisasipenempatan' . $this->src}->getRecap($tahun_angkatan, $tanggal_awal, $tanggal_akhir);
	}

	public function getSummary($tahun_angkatan, $kode_cabang = null)
	{
		return $this->{'realisasipenempatan' . $this->src}->getSummary($tahun_angkatan, $kode_cabang);
	}

	public function getRecapJurusan($tahun_angkatan, $cabang)
	{
		return $this->{'realisasipenempatan' . $this->src}->getRecapJurusan($tahun_angkatan, $cabang);
	}

	public function getRecapByCabang($tahun_angkatan, $cabang = '')
	{
		return $this->{'realisasipenempatan' . $this->src}->getRecapByCabang($tahun_angkatan, $cabang);
	}
}
