<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodatastatuscollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'biodata_status_mhs';
	public $soft_delete = false;
	public $datatable_columns = ['biodata_status_mhs.id', 'biodata_status_mhs.nim', 'biodata_status_mhs.nama_mahasiswa', 'biodata_status_mhs.tingkat',
		'biodata_status_mhs.tahun_periode', 'cabang.namacabang', 'jurusan.namajurusan'];
	public $datatable_search = ['biodata_status_mhs.nim', 'biodata_status_mhs.nama_mahasiswa', 'cabang.namacabang', 'jurusan.namajurusan'];
	public $datatable_order = ['biodata_status_mhs.tingkat, cabang.namacabang, jurusan.namajurusan, biodata_status_mhs.nama_mahasiswa', 'asc'];

	public $periode;
	public $status;
	public $kode_jurusan;
	public $kode_cabang;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'cabang'
		]);
	}

	public function currentPeriod()
	{
		$year = date('Y');
		$month = date('m');

		return $year . ($month > 6) ? 2 : 1;
	}

    protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName)
        	->distinct()
        	->select($this->datatable_columns)
        	->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'left')
        	->join('jurusan', 'jurusan.kodejurusan = biodata_status_mhs.kode_jurusan', 'left');
 
        if ($this->periode) {
        	$this->_dbr->where('biodata_status_mhs.tahun_periode', $this->periode);
        }
 
        if ($this->status != 'data_awal') {
        	$this->_dbr->where('biodata_status_mhs.status', slugToName($this->status));
        }
 
        if ($this->kode_jurusan) {
        	$this->_dbr->where('biodata_status_mhs.kode_jurusan', $this->kode_jurusan);
        }
 
        if ($this->kode_cabang) {
        	$this->_dbr->where('cabang.kodecabang', $this->kode_cabang);
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

	public function getSummaryByYear($all = false, $tahun_angkatan = null)
	{
		if (!$tahun_angkatan) {
			$tahun_angkatan = date('Y');
		}

		$model = $this->find()
					->select([
						"tahun_angkatan",
						"SUM(CASE WHEN `status` = 'Aktif' THEN 1 ELSE 0 END) aktif",
						"SUM(CASE WHEN `status` = 'Cuti' THEN 1 ELSE 0 END) cuti",
						"SUM(CASE WHEN `status` = 'Non Aktif' THEN 1 ELSE 0 END) non_aktif",
						"SUM(CASE WHEN `status` = 'Drop Out' THEN 1 ELSE 0 END) drop_out",
						"SUM(CASE WHEN `status` = 'Keluar' THEN 1 ELSE 0 END) keluar",
					])
					->group_by('tahun_angkatan');

		if ($all === false) {
			$model->where(['tahun_angkatan' => $tahun_angkatan]);
		}

		return $all === false ? $model->get()->row_array() : $model->get()->result_array();
	}

	public function getSummaryByYearV2($tahun_periode = null, $kode_cabang = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		$model = $this->find()
					->select([
						"cabang.namacabang",
						"COUNT(*) data_awal",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'INNER')
					->group_by('biodata_status_mhs.kode_cabang')
					->where(['biodata_status_mhs.tahun_periode' => $tahun_periode])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end();

		if ($kode_cabang) {
			$model->where(['biodata_status_mhs.kode_cabang' => $kode_cabang]);
		}

		return $model->get()->result_array();
	}

	public function getSummaryByMonth($tahun_periode = null, $kode_cabang = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		// $tahun = substr($tahun_periode, 0, 4);

		$model = $this->find()
					->select([
						"MONTHNAME(date_generate) `month_name`",
						"MONTH(date_generate) `month`",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'INNER')
					->where([
						'tahun_periode' => $tahun_periode,
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->group_by('`month_name`')
					->order_by('month', 'asc');

		if ($kode_cabang) {
			$model->where(['kode_cabang' => $kode_cabang]);
		}

		return $model->get()->result_array();
	}

	public function getSummaryProdiByMonth($tahun_periode = null, $kode_cabang = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		// $tahun = substr($tahun_periode, 0, 4);

		$model = $this->find()
					->select([
						"jurusan.namajurusan",
						"jurusan.kodejurusan",
						"biodata_status_mhs.kode_cabang",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'INNER')
					->join('jurusan', 'jurusan.kodejurusan = biodata_status_mhs.kode_jurusan', 'left')
					->where([
						'tahun_periode' => $tahun_periode,
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->group_by('jurusan.kodejurusan')
					->order_by('jurusan.namajurusan', 'asc');

		if ($kode_cabang) {
			$model->where(['biodata_status_mhs.kode_cabang' => $kode_cabang]);
		}

		return $model->get()->result_array();
	}

	public function getSummaryCabangByMonth($tahun_periode = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		$model = $this->find()
					->select([
						"cabang.namacabang",
						"biodata_status_mhs.kode_cabang",
						"biodata_status_mhs.kode_cabang",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'left')
					->where([
						'tahun_periode' => $tahun_periode,
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->group_by('cabang.kodecabang')
					->order_by('cabang.namacabang', 'asc');

		return $model->get()->result_array();
	}

	public function getSummaryAllCabang($tahun_periode = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		$model = $this->find()
					->select([
						"cabang.kodecabang",
						"cabang.namacabang",
						"COUNT(*) total",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'left')
					->where([
						'tahun_periode' => $tahun_periode,
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->group_by('cabang.kodecabang')
					->order_by('cabang.namacabang', 'asc');

		return $model->get()->result_array();
	}

	public function getSummaryByCabangPeriod($kode_cabang, $tahun_periode = null)
	{
		if (!$tahun_periode) {
			$tahun_periode = $this->currentPeriod();
		}

		$model = $this->find()
					->select([
						"MONTHNAME(date_generate) `month_name`",
						"MONTH(date_generate) `month`",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'left')
					->where([
						'tahun_periode' => $tahun_periode,
						'biodata_status_mhs.kode_cabang' => $kode_cabang
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->group_by('`month_name`')
					->order_by('month', 'asc');

		return $model->get()->result_array();
	}

	public function getRecapProdi($tahun)
	{
		$tahuns = explode('-', $tahun);
		$tahun_mulai = $tahuns[0];
		$tahun_selesai = $tahuns[1];

		$tahun_akademiks = [];

		for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) { 
			$tahun_akademiks[] = $i .'/'. ($i + 1);
		}

		$model = $this->find()
					->select([
						"CONCAT(biodata_status_mhs.tahun_angkatan, biodata_status_mhs.tingkat) tahun_tingkat",
						"jurusan.kodejurusan",
						"jurusan.namajurusan",
						"jurusan.alias",
						"biodata_status_mhs.kode_cabang",
						"cabang.namacabang",
						"COUNT(*) data_awal",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Aktif', biodata_status_mhs.nim, NULL))) aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Cuti', biodata_status_mhs.nim, NULL))) cuti",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Non Aktif', biodata_status_mhs.nim, NULL))) non_aktif",
						"COUNT(DISTINCT (IF(biodata_status_mhs.`status` = 'Keluar', biodata_status_mhs.nim, NULL))) keluar",
					])
					->join('jurusan', 'jurusan.kodejurusan = biodata_status_mhs.kode_jurusan', 'left')
					->join('cabang', 'cabang.kodecabang = biodata_status_mhs.kode_cabang', 'left')
					->group_by('tahun_tingkat, biodata_status_mhs.kode_cabang, jurusan.namajurusan')
					->where([
						'jurusan.namajurusan != ' => '',
						'biodata_status_mhs.tahun_angkatan >= ' => $tahun_mulai,
						'biodata_status_mhs.tahun_angkatan <= ' => $tahun_selesai,
						// 'jurusan.tahunakademik' => $tahun .'/'. ($tahun + 1),
					])
					->group_start()
						->or_where(['LOWER(cabang.kelompok)' => Cabang::KELOMPOK_AKTIF, 'cabang.kelompok' => Cabang::KELOMPOK_AKTIF_INT])
					->group_end()
					->order_by('biodata_status_mhs.tahun_angkatan', 'asc');

		return $model->get()->result_array();
	}

	public function getGroupedRecap($tahun)
	{
		$recaps = [
			'periode' => [],
			'jurusan' => [],
			'cabang' => [],
			'values' => [],
			'subtotal' => [],
		];

		$datas = $this->getRecapProdi($tahun);

		foreach ($datas as $key => $data) {
			$kode_jurusan = $data['kodejurusan'];
			$kode_cabang = $data['kode_cabang'];
			$periode = $data['tahun_tingkat'];

			$recaps['periode'][] = $periode;
			$recaps['jurusan'][$periode][$kode_jurusan] = $data['alias'] .'-'. $data['namajurusan'];
			$recaps['cabang'][$kode_cabang] = $data['namacabang'];

			// START FILL VALUES
			$recaps['values']['jumlah_awal'][$kode_cabang][$periode][$kode_jurusan] = $data['data_awal'];
			$recaps['values']['aktif'][$kode_cabang][$periode][$kode_jurusan] = $data['aktif'];
			$recaps['values']['cuti'][$kode_cabang][$periode][$kode_jurusan] = $data['cuti'];
			$recaps['values']['non_aktif'][$kode_cabang][$periode][$kode_jurusan] = $data['non_aktif'];
			// $recaps['values']['drop_out'][$kode_cabang][$periode][$kode_jurusan] = $data['drop_out'];
			$recaps['values']['keluar'][$kode_cabang][$periode][$kode_jurusan] = $data['keluar'];
			// END FILL VALUES

			// START SUM SUB TOTAL
			if (!empty($recaps['subtotal']['jumlah_awal'][$periode][$kode_jurusan])) {
				$recaps['subtotal']['jumlah_awal'][$periode][$kode_jurusan] += $data['data_awal'];
			} else {
				$recaps['subtotal']['jumlah_awal'][$periode][$kode_jurusan] = $data['data_awal'];
			}
			if (!empty($recaps['subtotal']['aktif'][$periode][$kode_jurusan])) {
				$recaps['subtotal']['aktif'][$periode][$kode_jurusan] += $data['aktif'];
			} else {
				$recaps['subtotal']['aktif'][$periode][$kode_jurusan] = $data['aktif'];
			}
			if (!empty($recaps['subtotal']['cuti'][$periode][$kode_jurusan])) {
				$recaps['subtotal']['cuti'][$periode][$kode_jurusan] += $data['cuti'];
			} else {
				$recaps['subtotal']['cuti'][$periode][$kode_jurusan] = $data['cuti'];
			}
			if (!empty($recaps['subtotal']['non_aktif'][$periode][$kode_jurusan])) {
				$recaps['subtotal']['non_aktif'][$periode][$kode_jurusan] += $data['non_aktif'];
			} else {
				$recaps['subtotal']['non_aktif'][$periode][$kode_jurusan] = $data['non_aktif'];
			}
			// if (!empty($recaps['subtotal']['drop_out'][$periode][$kode_jurusan])) {
			// 	$recaps['subtotal']['drop_out'][$periode][$kode_jurusan] += $data['drop_out'];
			// } else {
			// 	$recaps['subtotal']['drop_out'][$periode][$kode_jurusan] = $data['drop_out'];
			// }
			if (!empty($recaps['subtotal']['keluar'][$periode][$kode_jurusan])) {
				$recaps['subtotal']['keluar'][$periode][$kode_jurusan] += $data['keluar'];
			} else {
				$recaps['subtotal']['keluar'][$periode][$kode_jurusan] = $data['keluar'];
			}
			// END SUM SUB TOTAL
		}

		$recaps['periode'] = array_values(array_unique($recaps['periode']));

		return $recaps;
	}
}

/* End of file BiodataStatusCollege.php */
/* Location: ./application/models/BiodataStatusCollege.php */