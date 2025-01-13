<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jurusancabangcollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'jurusancabang';
	public $primaryKey = 'kode';
	public $soft_delete = false;

	public function __construct()
	{
		parent::__construct();
		$this->load->library(['array/arrayhelper']);
	}

	public function getJurusans($tahun = null, $cabang = null)
	{
		$model = $this->find()
				->where(['jurusan != ' => ''])
				->group_by('TRIM(TRAILING \'\r\n\' FROM jurusan)');

		if ($tahun) {
			$model->where(['tahunakademik' => $tahun .'/'. ($tahun + 1)]);
		}

		if ($cabang) {
			$model->where(['kodecabang' => $cabang]);
		}

		return $model->get()->result_array();
	}

	public function getListJurusans($tahun = null, $cabang = null)
	{
		$jurusans = $this->getJurusans($tahun, $cabang);

		return $this->arrayhelper::map($jurusans, 'kode', 'jurusan');
	}

	public function getNamaJurusan($kodejurusan)
	{
		$model = $this->findOne(['kode' => $kodejurusan]);

		return $model->jurusan;
	}
}

/* End of file Jurusancabangcollege.php */
/* Location: ./application/models/Jurusancabangcollege.php */