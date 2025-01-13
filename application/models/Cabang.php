<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Cabang extends Multimodel
{
	const KELOMPOK_AKTIF = 'aktif';
	const KELOMPOK_NON_AKTIF = 'non aktif';
	const KELOMPOK_PERALIHAN = 'peralihan';
	const KELOMPOK_AKTIF_INT = 1;
	const KELOMPOK_NON_AKTIF_INT = 0;
	const KELOMPOK_PERALIHAN_INT = 2;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/cabangcollege',
			'polteks/cabangplj'
		]);
	}

	public function getListCabang()
	{
		return $this->{'cabang' . $this->src}->getListCabang();
	}

	public function getNamaByKode($kode)
	{
		return $this->{'cabang' . $this->src}->getNamaByKode($kode);
	}
}
