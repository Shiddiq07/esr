<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Biodata extends Multimodel
{
	const STATUS_AKTIF = 'Aktif';
	const STATUS_CUTI = 'Cuti';
	const STATUS_NON_AKTIF = 'Non Aktif';
	const STATUS_NON_AKTIF_ALT = 'Tidak Aktif';
	const STATUS_DO = 'Drop Out';
	const STATUS_DO_ALT = 'DO';
	const STATUS_KELUAR = 'Keluar';
	const STATUS_KELUAR_ALT = 'Keluar by Pustekom';

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/biodatacollege',
			'polteks/biodataplj'
		]);
	}

	public static function getStatuses()
	{
		return [
			self::STATUS_AKTIF,
			self::STATUS_CUTI,
			self::STATUS_NON_AKTIF,
			self::STATUS_NON_AKTIF_ALT,
			self::STATUS_DO,
			self::STATUS_DO_ALT,
			self::STATUS_KELUAR,
			self::STATUS_KELUAR_ALT,
		];
	}

	public function getAllReports($tahun_angkatan = null)
	{
		return $this->{'biodata' . $this->src}->getAllReports($tahun_angkatan = null);
	}

	public function getAllSummary($tahun_angkatan = null, $kode_cabang = null)
	{
		return $this->{'biodata' . $this->src}->getAllSummary($tahun_angkatan, $kode_cabang);
	}

	public function getWeeklyReport($tahun_periode = null, $kode_cabang = null)
	{
		return $this->{'biodata' . $this->src}->getWeeklyReport($tahun_periode, $kode_cabang);
	}

	public function getSumProdiReport($tahun_periode = null, $kode_cabang = null)
	{
		return $this->{'biodata' . $this->src}->getSumProdiReport($tahun_periode, $kode_cabang);
	}

	public function getSumCabangReport($tahun_periode = null)
	{
		return $this->{'biodata' . $this->src}->getSumCabangReport($tahun_periode);
	}

	public function getSummaryCabang($tahun_periode)
	{
		return $this->{'biodata' . $this->src}->getSummaryCabang($tahun_periode);
	}

	public function getListTahunAngkatan($cabang = null)
	{
		return $this->{'biodata' . $this->src}->getListTahunAngkatan($cabang);
	}

	public function getListCabang($tahun_angkatan)
	{
		return $this->{'biodata' . $this->src}->getListCabang($tahun_angkatan);
	}

	public function getListMahasiswa($tahun_angkatan, $cabang, $id = 0, $limit = 0, $is_next = true)
	{
		return $this->{'biodata' . $this->src}->getListMahasiswa($tahun_angkatan, $cabang, $id, $limit, $is_next);
	}

}

/* End of file Biodata.php */
/* Location: ./application/models/Biodata.php */