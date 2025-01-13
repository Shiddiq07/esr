<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaancollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'permintaan';
	public $primaryKey = 'id_permintaan';
	public $soft_delete = false;

	public $datatable_columns = ['permintaan.id_permintaan', 'cabang.namacabang', 'permintaan.tgl_permintaan', 'perusahaan.nama', 'perusahaan.bidang_usaha', 'perusahaan.mou', 'perusahaan.telepon', 'permintaan.posisi_permintaan', 'permintaan.status_posisi', 'cabang.kelompok'];
	public $datatable_search = ['perusahaan.nama', 'perusahaan.bidang_usaha', 'permintaan.posisi_permintaan'];
	public $datatable_order = ['permintaan.tgl_permintaan', 'desc'];

	// Custom filter
	public $cabang;
	public $tanggal_dari;
	public $tanggal_sampai;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'cabang'
		]);
	}

	public function getListTahun()
	{
		$model = $this->find()
					->select([
						'DISTINCT YEAR(tgl_permintaan) AS tahun'
					])
					->where(['LENGTH(YEAR(tgl_permintaan))' => 4])
					->order_by('YEAR(tgl_permintaan) ASC')
					->get()->result_array();

		$lists = [];

		foreach ($model as $key => $value) {
			$lists[$value['tahun']] = $value['tahun'];
		}

		return $lists;
	}

	public function getRecapByTahun($tahun_angkatan, $group_cabang = true)
	{
		$model = $this->setAlias('p')->find()
					->select([
						"p.id_permintaan",
						"cabang.kodecabang",
						"cabang.namacabang",
						"cabang.kelompok",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 1 THEN 1 ELSE 0 END) AS jan",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 2 THEN 1 ELSE 0 END) AS feb",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 3 THEN 1 ELSE 0 END) AS mar",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 4 THEN 1 ELSE 0 END) AS apr",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 5 THEN 1 ELSE 0 END) AS mei",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 6 THEN 1 ELSE 0 END) AS jun",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 7 THEN 1 ELSE 0 END) AS jul",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 8 THEN 1 ELSE 0 END) AS agu",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 9 THEN 1 ELSE 0 END) AS sep",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 10 THEN 1 ELSE 0 END) AS okt",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 11 THEN 1 ELSE 0 END) AS nov",
						"SUM(CASE WHEN MONTH(p.tgl_permintaan) = 12 THEN 1 ELSE 0 END) AS des",
					])
					->join('cabang', 'cabang.kodecabang = p.kodecabang')
					->where([
						'p.tgl_permintaan >=' => date('Y-m-d', strtotime($tahun_angkatan .'-01-01')),
						'p.tgl_permintaan <=' => date('Y-m-d', strtotime($tahun_angkatan .'-12-31')),
					]);
					// ->group_start()
					// 	->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					// ->group_end()

		if ($group_cabang === true) {
			$model->group_by('p.kodecabang');
		}

		return $model->get()->result_array();
	}

	public function getGraphNasional($tahun_permintaan, $kode_cabang = null)
	{
		$recaps = $this->getRecapByTahun($tahun_permintaan, $kode_cabang !== null);
		$graph = [];

		if ($recaps && $kode_cabang) {
			$index = array_search($kode_cabang, array_column($recaps, 'kodecabang'));
			$recaps = !empty($recaps[$index]) ? [$recaps[$index]] : null;
		}

		if ($recaps) {
			$graph = $recaps[0];
			unset($graph['id_permintaan']);
			unset($graph['namacabang']);
			unset($graph['kodecabang']);
			unset($graph['kelompok']);
		}

		return [
			'graph' => $graph,
			'values' => array_values($graph),
			'columns' => array_keys($graph),
		];
	}

	protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName)
        	->distinct()
        	->select($this->datatable_columns)
        	->join('cabang', 'cabang.kodecabang = permintaan.kodecabang')
        	->join('perusahaan', 'perusahaan.id_perusahaan = permintaan.id_perusahaan');
 
        if ($this->cabang) {
        	$this->_dbr->where('permintaan.kodecabang', $this->cabang);
        }
 
        if ($this->tanggal_dari) {
			$this->_dbr->where(['permintaan.tgl_permintaan >=' => $this->tanggal_dari]);
		}

		if ($this->tanggal_sampai) {
			$this->_dbr->where(['permintaan.tgl_permintaan <=' => $this->tanggal_sampai]);
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
}