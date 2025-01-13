<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Biodatastatus extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/biodatastatuscollege',
			'polteks/biodatastatusplj'
		]);
	}

	public function getRecapProdi($tahun)
	{
		return $this->{'biodatastatus' . $this->src}->getRecapProdi($tahun);
	}

	public function getSummaryByYear($all = false, $tahun_angkatan = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryByYear($all, $tahun_angkatan);
	}

	public function getSummaryByYearV2($tahun_periode = null, $kode_cabang = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryByYearV2($tahun_periode, $kode_cabang);
	}

	public function getSummaryByMonth($tahun_periode = null, $kode_cabang = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryByMonth($tahun_periode, $kode_cabang);
	}

	public function getSummaryProdiByMonth($tahun_periode = null, $kode_cabang = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryProdiByMonth($tahun_periode, $kode_cabang);
	}

	public function getSummaryCabangByMonth($tahun_periode = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryCabangByMonth($tahun_periode);
	}

	public function getGroupedRecap($tahun)
	{
		return $this->{'biodatastatus' . $this->src}->getGroupedRecap($tahun);
	}

	public function getSummaryAllCabang($tahun_periode = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryAllCabang($tahun_periode);
	}

	public function getSummaryByCabangPeriod($kode_cabang, $tahun_periode = null)
	{
		return $this->{'biodatastatus' . $this->src}->getSummaryByCabangPeriod($kode_cabang, $tahun_periode);
	}

}
