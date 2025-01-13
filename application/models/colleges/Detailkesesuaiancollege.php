<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detailkesesuaiancollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'kpi_detail_kesesuaian';
	public $primaryKey = 'idh';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function getRecapJurusan($tahun_angkatan, $cabang)
	{
		$model = $this->setAlias('dk')->find()
					->select([
						"dk.idh",
						"cabang.namacabang",
						"jurusan.namajurusan",
						"dk.target",
						"dk.penempatan",
						"dk.sesuai",
						"dk.sesuai_rasio",
						"dk.tidak_sesuai",
						"dk.tidak_rasio",
						"dk.tglupdate",
					])
					->join('cabang', 'cabang.kodecabang = dk.kodecabang')
					->join('jurusan', 'jurusan.kodejurusan = dk.kodejurusan')
					->join('(SELECT kodecabang, MAX(tglupdate) AS Last_Update
						     FROM kpi_detail_kesesuaian
						     WHERE tahun = '. $this->db->escape($tahun_angkatan) .'
						     	AND kodecabang = '. $this->db->escape($cabang) .'
						     GROUP BY kodejurusan) AS subq', 'dk.kodecabang = subq.kodecabang AND dk.tglupdate = subq.Last_Update')
					->where(['dk.tahun' => $tahun_angkatan])
					->group_by('dk.kodejurusan');

		return $model->get()->result_array();
	}

	public function getListCabang($tahun_angkatan = null)
	{
		$model = $this->find()
					->select(['kpi_detail_kesesuaian.kodecabang', 'cabang.namacabang'])
					->join('cabang', 'cabang.kodecabang = kpi_detail_kesesuaian.kodecabang')
					->group_by('kpi_detail_kesesuaian.kodecabang')
					->order_by('kpi_detail_kesesuaian.kodecabang', 'desc');

		if ($tahun_angkatan) {
			$model->where(['tahun' => $tahun_angkatan]);
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