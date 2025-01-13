<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Alumniaktifitas extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/alumniaktifitascollege',
			'polteks/alumniaktifitasplj'
		]);
	}

	public function getJumlahs($id_perusahaan, $tanggal_awal = null, $tanggal_akhir = null)
	{
		return $this->{'alumniaktifitas' . $this->src}->getJumlahs($id_perusahaan, $tanggal_awal, $tanggal_akhir);
	}

	public function getGraphKeterangan($tahun_angkatan, $excepts = [], $kode_cabang = null)
	{
		return $this->{'alumniaktifitas' . $this->src}->getGraphKeterangan($tahun_angkatan, $excepts, $kode_cabang);
	}

	public function getListTahunAngkatan($kode_cabang)
	{
		return $this->{'alumniaktifitas' . $this->src}->getListTahunAngkatan($kode_cabang);
	}
}
