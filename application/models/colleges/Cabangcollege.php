<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabangcollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'cabang';
	public $primaryKey = 'kodecabang';
	public $soft_delete = false;

	protected $kelompok_aktif = 1;

	public function __construct()
	{
		parent::__construct();
	}

	public function getCabangs()
	{
		$datas = $this->find()
			->select([
				'kodecabang',
				'namacabang'
			])
			->where(['kelompok' => $this->kelompok_aktif])
			->get()->result_array();

		$cabangs = [];
		foreach ($datas as $key => $value) {
			$cabangs[$key]['kodecabang'] = $value['kodecabang'];
			$cabangs[$key]['namacabang'] = $this->database == 'college' ? str_replace('Kampus ', '', ucwords($value['namacabang'])) : ucwords($value['namacabang']);
		}

		return $cabangs;
	}

	public function getListCabang()
	{
		$cabangs = $this->getCabangs();

		return array_combine(array_column($cabangs, 'kodecabang'), array_column($cabangs, 'namacabang'));
	}

	public function getNamaByKode($kode)
	{
		$nama = '';
		$model = $this->findOne(['kodecabang' => $kode]);

		if ($model) {
			$nama = $this->database == 'college' ? str_replace('Kampus ', '', ucwords($model->namacabang)) : ucwords($model->namacabang);
		}

		return $nama;
	}

}