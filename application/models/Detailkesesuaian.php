<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Detailkesesuaian extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/detailkesesuaiancollege',
			'polteks/detailkesesuaianplj'
		]);
	}

	public function getRecapJurusan($tahun_angkatan, $cabang)
	{
		return $this->{'detailkesesuaian' . $this->src}->getRecapJurusan($tahun_angkatan, $cabang);
	}

	public function getListCabang($tahun_angkatan = null)
	{
		return $this->{'detailkesesuaian' . $this->src}->getListCabang($tahun_angkatan);
	}
}
