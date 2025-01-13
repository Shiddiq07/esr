<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaancollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'perusahaan';
	public $primaryKey = 'id_perusahaan';
	public $soft_delete = false;

	public $datatable_columns = ['perusahaan.id_perusahaan', 'cabang.namacabang', 'perusahaan.nama', 'perusahaan.mou_tgl', 'perusahaan_skala.skala', 'perusahaan.alamat', 'perusahaan.pic', 'perusahaan.telepon', 'perusahaan.file_mou'];
	public $datatable_search = ['cabang.namacabang', 'perusahaan.nama', 'perusahaan.alamat', 'perusahaan.pic', 'perusahaan_skala.skala'];
	public $datatable_order = ['cabang.namacabang', 'asc'];

	const MOU_SUDAH = 1;
	const MOU_BELUM = 2;

	// Custom filter
	public $cabang;
	public $tanggal_dari;
	public $tanggal_sampai;

	protected $perusahaan_skala;

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'colleges/perusahaanskalacollege',
			'cabang'
		]);

		$this->perusahaan_skala = $this->perusahaanskalacollege;
	}

	protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName)
        	->distinct()
        	->select($this->datatable_columns)
        	->join('cabang', 'cabang.kodecabang = perusahaan.kodecabang')
        	->join('perusahaan_skala', 'perusahaan_skala.id = perusahaan.skala');
 
        if ($this->cabang) {
        	$this->_dbr->where('perusahaan.kodecabang', $this->cabang);
        }
 
        if ($this->tanggal_dari) {
			$this->_dbr->where(['perusahaan.tgl_entry >=' => $this->tanggal_dari]);
		}

		if ($this->tanggal_sampai) {
			$this->_dbr->where(['perusahaan.tgl_entry <=' => $this->tanggal_sampai]);
		}

        $i = 0;

        foreach ($this->datatable_search as $item) {
			# jika datatable mengirimkan pencarian dengan metode POST
            if($_POST['search']['value']) {
                 
                if ($i === 0) {
                    $this->_dbr->group_start(); 
                    $this->_dbr->like($item, $_POST['search']['value']);

                } else {
                    $this->_dbr->or_like($item, $_POST['search']['value']);
                }
 
                if (count($this->datatable_search) - 1 == $i) {
                    $this->_dbr->group_end(); 
                }
            }

            $i++;
        }

        if(isset($_POST['order'])) {
            $this->_dbr->order_by($this->datatable_columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } elseif(isset($this->datatable_order)) {
            $order = $this->datatable_order;
            $this->_dbr->order_by($order[0], $order[1]);

        }
    }

    public function getListStatusMOU()
    {
    	return [
    		self::MOU_SUDAH => 'Sudah',
			self::MOU_BELUM => 'Belum',
    	];
    }

    public function getRecapBySkala($mou = null, $is_contributed = null, $kode_cabang = null)
    {
    	$model = $this->find()
				->select([
					'COUNT(DISTINCT (IF(perusahaan.skala = 1, perusahaan.id_perusahaan, NULL))) lokal',
					'COUNT(DISTINCT (IF(perusahaan.skala = 2, perusahaan.id_perusahaan, NULL))) nasional',
					'COUNT(DISTINCT (IF(perusahaan.skala = 4, perusahaan.id_perusahaan, NULL))) internasional',
				])
				->join('cabang', 'cabang.kodecabang = perusahaan.kodecabang')
				->where([
					'LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF,
				])
				->or_where([
					'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT,
				]);

		if ($mou) {
			$model->where(['mou' => $mou]);
		}

		if ($kode_cabang) {
			$model->where(['perusahaan.kodecabang' => $kode_cabang]);
		}

		if ($is_contributed == 1) {
			$model->join('alumni_aktifitas', 'alumni_aktifitas.id_perusahaan = perusahaan.id_perusahaan');
		}

		$data = $model->get()->row_array();

		if (!$data) {
			return $data;
		}

		$graphs = [];
		$skalas = $this->perusahaan_skala->getListSkalas();

		foreach ($skalas as $key => $skala) {
			switch ($key) {
				case 1:
					$value = $data['lokal'];
					break;
				case 2:
					$value = $data['nasional'];
					break;
				case 4:
					$value = $data['internasional'];
					break;
			}

			$graphs[] = [
				'skala' => $skala,
				'value' => intval($value)
			];
		}

		return [
			'data' => $graphs,
			'series' => array_column($graphs, 'skala'),
			'values' => array_column($graphs, 'value'),
		];
    }

    public function getSummarySkala($kode_cabang, $date_range = [])
    {
    	$model = $this->find()
				->select([
					"COUNT(DISTINCT (IF(perusahaan.skala = 1, perusahaan.id_perusahaan, NULL))) skala_lokal",
					"COUNT(DISTINCT (IF(perusahaan.skala = 2, perusahaan.id_perusahaan, NULL))) skala_nasional",
					"COUNT(DISTINCT (IF(perusahaan.skala = 4, perusahaan.id_perusahaan, NULL))) skala_internasional",
					"COUNT(DISTINCT (IF(perusahaan.mou = 1, perusahaan.id_perusahaan, NULL))) sudah_mou",
					"COUNT(DISTINCT (IF(perusahaan.mou = 2, perusahaan.id_perusahaan, NULL))) belum_mou",
					"COUNT(DISTINCT (IF(perusahaan.status_relasi = 0, perusahaan.id_perusahaan, NULL))) baru",
					"COUNT(DISTINCT (IF(perusahaan.status_relasi = 1, perusahaan.id_perusahaan, NULL))) berelasi",
					"COUNT(DISTINCT (IF(perusahaan.status_relasi = 2, perusahaan.id_perusahaan, NULL))) belum_berelasi",
				])
				->where(['perusahaan.kodecabang' => $kode_cabang]);

		if ($date_range) {
			if ($date_range['tanggal_dari']) {
				$model->where(['DATE(perusahaan.tgl_entry) >=' => $date_range['tanggal_dari']]);
			}

			if ($date_range['tanggal_sampai']) {
				$model->where(['DATE(perusahaan.tgl_entry) <=' => $date_range['tanggal_sampai']]);
			}
		}

		$data = $model->get()->row_array();

		if (!$data) {
			return $data;
		}

		$graphs = [
			'skala' => [],
			'mou' => [],
			'relasi' => [],
		];

		// Graph Skala
		$skalas = $this->perusahaan_skala->getListSkalas();

		foreach ($skalas as $key => $skala) {
			switch ($key) {
				case 1:
					$value = $data['skala_lokal'];
					break;
				case 2:
					$value = $data['skala_nasional'];
					break;
				case 4:
					$value = $data['skala_internasional'];
					break;
			}

			$graphs['skala'][] = [
				'skala' => $skala,
				'value' => intval($value)
			];
		}

		// Graph MOU
		$graphs['mou'][] = [
			'tipe' => 'Sudah MOU',
			'value' => intval($data['sudah_mou']),
		];
		$graphs['mou'][] = [
			'tipe' => 'Belum MOU',
			'value' => intval($data['belum_mou']),
		];

		// Graph Relasi
		$graphs['relasi'][] = [
			'jenis' => 'Baru',
			'value' => intval($data['baru']),
		];
		$graphs['relasi'][] = [
			'jenis' => 'Sudah Berelasi',
			'value' => intval($data['berelasi']),
		];
		$graphs['relasi'][] = [
			'jenis' => 'Belum Berelasi',
			'value' => intval($data['belum_berelasi']),
		];

		return [
			'skala' => [
				'data' => $graphs['skala'],
				'series' => array_column($graphs['skala'], 'skala'),
				'values' => array_column($graphs['skala'], 'value'),
			],
			'mou' => [
				'data' => $graphs['mou'],
				'series' => array_column($graphs['mou'], 'tipe'),
				'values' => array_column($graphs['mou'], 'value'),
			],
			'relasi' => [
				'data' => $graphs['relasi'],
				'series' => array_column($graphs['relasi'], 'jenis'),
				'values' => array_column($graphs['relasi'], 'value'),
			],
		];
    }

    public function getSummaryMOU($kode_cabang, $date_range = [])
    {
    	$model = $this->find()
				->select([
					'COUNT(DISTINCT (IF(perusahaan.mou = 1, perusahaan.id_perusahaan, NULL))) sudah_mou',
					'COUNT(DISTINCT (IF(perusahaan.mou = 2, perusahaan.id_perusahaan, NULL))) belum_mou',
				])
				->where(['perusahaan.kodecabang' => $kode_cabang]);

		if ($date_range) {
			if ($date_range['tanggal_dari']) {
				$model->where(['DATE(perusahaan.tgl_entry) >=' => $date_range['tanggal_dari']]);
			}

			if ($date_range['tanggal_sampai']) {
				$model->where(['DATE(perusahaan.tgl_entry) <=' => $date_range['tanggal_sampai']]);
			}
		}

		$data = $model->get()->row_array();

		if (!$data) {
			return $data;
		}

		$graphs = [];
		$skalas = $this->perusahaan_skala->getListSkalas();

		foreach ($skalas as $key => $skala) {
			switch ($key) {
				case 1:
					$value = $data['lokal'];
					break;
				case 2:
					$value = $data['nasional'];
					break;
				case 4:
					$value = $data['internasional'];
					break;
			}

			$graphs[] = [
				'skala' => $skala,
				'value' => intval($value)
			];
		}

		return [
			'data' => $graphs,
			'series' => array_column($graphs, 'skala'),
			'values' => array_column($graphs, 'value'),
		];
    }
}

/* End of file Perusahaancollege.php */
/* Location: ./application/models/Perusahaancollege.php */