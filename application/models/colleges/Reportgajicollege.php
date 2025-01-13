<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportgajicollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'report_gaji_rekap';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function getListTahunAngkatan()
	{
		$model = $this->find()
					->select(['th_angkatan'])
					->group_by('th_angkatan')
					->order_by('th_angkatan', 'desc')
					->get()->result_array();

		$tahuns = [];

		if ($model) {
			$tahuns = array_column($model, 'th_angkatan', 'th_angkatan');
		}

		return $tahuns;
	}

	public function getListTahunValidasi()
	{
		$model = $this->find()
					->select(['th_validasi'])
					->group_by('th_validasi')
					->get()->result_array();

		$tahuns = [];

		if ($model) {
			$tahuns = array_column($model, 'th_validasi', 'th_validasi');
		}

		return $tahuns;
	}

	public function getRekapNasional($tahun_angkatan)
	{
		$model = $this->find()
					->select([
						"report_gaji_rekap.id",
						"cabang.namacabang",
						"SUM(report_gaji_rekap.total_tertempatkan) total_tertempatkan",
						"SUM(report_gaji_rekap.skala1) skala1",
						"SUM(report_gaji_rekap.skala2) skala2",
						"SUM(report_gaji_rekap.skala3) skala3",
						"SUM(report_gaji_rekap.skala4) skala4",
						"report_gaji_rekap.tgl_validasi",
					])
					->join('cabang', 'cabang.kodecabang = report_gaji_rekap.kodecabang')
					->join('(
							SELECT kodecabang, MAX(tgl_validasi) AS Last_Update
							FROM report_gaji_rekap
							WHERE th_angkatan = '. $this->db->escape($tahun_angkatan) .'
							GROUP BY kodecabang
						) AS subq', 'report_gaji_rekap.kodecabang = subq.kodecabang AND report_gaji_rekap.tgl_validasi = subq.Last_Update')
					->where(['th_angkatan' => $tahun_angkatan])
					->group_by('report_gaji_rekap.kodecabang');

		return $model->get()->result_array();
	}

	public function getRekapByCabang($tahun_angkatan, $cabang)
	{
		$sql = "
			SELECT
				report_gaji_rekap.id,
				report_gaji_rekap.kodejurusan,
				cabang.namacabang,
				SUM(report_gaji_rekap.total_tertempatkan) AS total_tertempatkan,
				SUM(report_gaji_rekap.skala1) AS skala1,
				SUM(report_gaji_rekap.skala2) AS skala2,
				SUM(report_gaji_rekap.skala3) AS skala3,
				SUM(report_gaji_rekap.skala4) AS skala4,
				report_gaji_rekap.tgl_validasi
			FROM report_gaji_rekap
			JOIN cabang ON cabang.kodecabang = report_gaji_rekap.kodecabang
			JOIN (
				SELECT kodejurusan, MAX(tgl_validasi) AS Last_Update
				FROM report_gaji_rekap
				WHERE th_angkatan = ? AND kodecabang = ?
				GROUP BY kodejurusan
			) AS subq ON report_gaji_rekap.kodejurusan = subq.kodejurusan 
				AND report_gaji_rekap.tgl_validasi = subq.Last_Update
			WHERE report_gaji_rekap.th_angkatan = ? 
				AND report_gaji_rekap.kodecabang = ?
			GROUP BY report_gaji_rekap.kodejurusan";

		$query = $this->_dbr->query($sql, [$tahun_angkatan, $cabang, $tahun_angkatan, $cabang]);
		return $query->result_array();
	}

	public function getListCabang($tahun_angkatan = null)
	{
		$model = $this->find()
					->select(['report_gaji_rekap.kodecabang', 'cabang.namacabang'])
					->join('cabang', 'cabang.kodecabang = report_gaji_rekap.kodecabang')
					->group_by('report_gaji_rekap.kodecabang')
					->order_by('report_gaji_rekap.kodecabang', 'desc');

		if ($tahun_angkatan) {
			$model->where(['th_angkatan' => $tahun_angkatan]);
		}

		$data = $model->get()->result_array();

		$cabangs = [];

		if ($data) {
			foreach ($data as $key => $value) {
				$cabangs[$value['kodecabang']] = $this->database == 'college' ? str_replace('Kampus ', '', ucwords($value['namacabang'])) : ucwords($value['namacabang']);
			}
		}

		return $cabangs;
	}

}