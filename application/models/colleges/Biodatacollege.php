<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biodatacollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'biodata';
	public $primaryKey = 'nim';
	public $soft_delete = false;

	public $datatable_columns = ['biodata.nim', 'biodata.Nama_Mahasiswa', 'biodata.Sex', 'biodata.status', 'jurusan.namajurusan'];
	public $datatable_search = ['biodata.nim', 'biodata.Nama_Mahasiswa', 'biodata.status', 'jurusan.namajurusan'];
	public $datatable_order = ['biodata.tingkat, biodata.kodecabang, jurusan.namajurusan, biodata.Nama_Mahasiswa', 'asc'];

	protected $jurusan_cabang;
	protected $model_cabang;
	protected $student_website = 'college';

	// custom filter
	public $cabang;
	public $tahun_angkatan;
	public $jurusan;
	public $is_pekerjaan = false;

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'colleges/jurusancabangcollege',
			'colleges/cabangcollege',
			'biodata',
			'biodatastatus',
			'rbac/setting',
		]);

		$this->jurusan_cabang = $this->jurusancabangcollege;
		$this->model_cabang = $this->cabangcollege;
	}

	protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName)
        	->distinct()
        	->select($this->datatable_columns)
        	->where_in('LOWER(biodata.status)', ['aktif', 'lulus'])
        	->join('jurusan', 'jurusan.kodejurusan = biodata.kode', 'left');
 
        if ($this->is_pekerjaan === true) {
        	$this->_dbr->select('COALESCE(MAX(CASE 
				WHEN alumni_aktifitas.status = 1 AND alumni_aktifitas.diterima = 1 THEN \'Bekerja\'
				WHEN alumni_aktifitas.status = 2 AND alumni_aktifitas.diterima = 1 THEN \'Magang\'
				WHEN alumni_aktifitas.diterima = 2 THEN \'Ditolak\'
				WHEN alumni_aktifitas.diterima = 0 THEN \'Proses\'
				ELSE NULL
			END), \'Belum Bekerja\') status_pekerjaan')
				->join('alumni_aktifitas', 'alumni_aktifitas.nim = biodata.nim', 'left')
				->group_by('biodata.nim');
        }

        if ($this->cabang) {
        	$this->_dbr->where('biodata.kodecabang', $this->cabang);
        }
 
        if ($this->tahun_angkatan) {
        	$this->_dbr->where('biodata.TahunAngkatan', $this->tahun_angkatan);
        }
 
        if ($this->jurusan) {
        	$this->_dbr->where('biodata.kode', $this->jurusan);
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

	public function getInitialDataByYear($all = false, $tahun_angkatan = null)
	{
		if (!$tahun_angkatan) {
			$tahun_angkatan = date('Y');
		}

		$model = $this->find()
					->select([
						"COUNT(*) data_awal"
					])
					->where_in('status', Biodata::getStatuses());

		if ($all === false) {
			$model->where(['TahunAngkatan' => $tahun_angkatan]);
		}

		return $model->get()->row_array();
	}

	public function getAllReports($tahun_angkatan = null)
	{
		return [
			'summary' => $this->getSummaryByYear(false, $tahun_angkatan)
		];
	}

	public function getAllSummary($tahun_periode = null, $kode_cabang = null)
	{
		$this->biodatastatus->setSource($this->database);
		$summaries = $this->biodatastatus->getSummaryByYearV2($tahun_periode, $kode_cabang);

		$all_summary = [
			'tahun_periode' => date('Y'),
			'data_awal' => 0,
			'aktif' => 0,
			'cuti' => 0,
			'non_aktif' => 0,
			'keluar' => 0,
		];

		if ($summaries) {
			$all_summary = [
				'tahun_periode' => $tahun_periode,
				'data_awal' => array_sum(array_column($summaries, 'data_awal')),
				'aktif' => array_sum(array_column($summaries, 'aktif')),
				'cuti' => array_sum(array_column($summaries, 'cuti')),
				'non_aktif' => array_sum(array_column($summaries, 'non_aktif')),
				'keluar' => array_sum(array_column($summaries, 'keluar')),
			];
		}

		return $all_summary;
	}

	public function getWeeklyReport($tahun_periode, $kode_cabang = null)
	{
		$this->biodatastatus->setSource($this->database);
		$monthly = $this->biodatastatus->getSummaryByMonth($tahun_periode, $kode_cabang);

		$graphs = [
			['name' => 'Aktif','data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
			['name' => 'Cuti', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
			['name' => 'Non-Aktif', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
			// ['name' => 'Drop-Out (DO)', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
			['name' => 'Keluar', 'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]],
		];

		$sums = [
		    "Aktif" => 0,
		    "Cuti" => 0,
		    "Non Aktif" => 0,
		    // "Drop Out" => 0,
		    "Keluar" => 0
		];

		if ($monthly) {
			foreach ($monthly as $key => $value) {
				// to graph
			    foreach ($graphs as &$graph) {
			    	$month_to_key = ($value['month'] - 1);

			        switch ($graph['name']) {
			            case 'Aktif':
			                $graph['data'][$month_to_key] += $value['aktif'];
			                break;
			            case 'Cuti':
			                $graph['data'][$month_to_key] += $value['cuti'];
			                break;
			            case 'Non-Aktif':
			                $graph['data'][$month_to_key] += $value['non_aktif'];
			                break;
			            // case 'Drop-Out (DO)':
			            //     $graph['data'][$month_to_key] += $value['drop_out'];
			            //     break;
			            case 'Keluar':
			                $graph['data'][$month_to_key] += $value['keluar'];
			                break;
			        }
			    }

			    // to sum
			    $sums['Aktif'] += $value['aktif'];
			    $sums['Cuti'] += $value['cuti'];
			    $sums['Non Aktif'] += $value['non_aktif'];
			    // $sums['Drop Out'] += $value['drop_out'];
			    $sums['Keluar'] += $value['keluar'];
			}
		}

		return [
			'graphs' => $graphs,
			'summary' => $sums,
			'nama_cabang' => $this->model_cabang->getNamaByKode($kode_cabang),
		];
	}

	public function getSumProdiReport($tahun_periode, $kode_cabang = null)
	{
		$this->biodatastatus->setSource($this->database);
		$sum_prodi = $this->biodatastatus->getSummaryProdiByMonth($tahun_periode, $kode_cabang);

		$graphs = [
			['name' => 'Aktif','data' => array_column($sum_prodi, 'aktif')],
			['name' => 'Cuti', 'data' => array_column($sum_prodi, 'cuti')],
			['name' => 'Non-Aktif', 'data' => array_column($sum_prodi, 'non_aktif')],
			// ['name' => 'Drop-Out (DO)', 'data' => array_column($sum_prodi, 'drop_out')],
			// ['name' => 'Pindah', 'data' => array_column($sum_prodi, 'pindah')],
			['name' => 'Keluar', 'data' => array_column($sum_prodi, 'keluar')],
		];

		return [
			'graphs' => $graphs,
			'summary' => $sum_prodi,
			'jurusans' => array_column($sum_prodi, 'namajurusan')
		];
	}

	public function getSumCabangReport($tahun_periode)
	{
		$cabangs = $this->model_cabang->getCabangs();

		$this->biodatastatus->setSource($this->database);
		$sum_cabang = $this->biodatastatus->getSummaryCabangByMonth($tahun_periode);

		// Set default
		$temp_cabang_graph = [];
		foreach ($cabangs as $key => $value) {
			$temp_cabang_graph[] = [
				'name' => $this->database == 'college' ? str_replace('Kampus ', '', $value['namacabang']) : $value['namacabang'],
				'code' => $value['kodecabang'],
				'aktif' => 0,
				'cuti' => 0,
				'non_aktif' => 0,
				// 'drop_out' => 0,
				// 'pindah' => 0,
				'keluar' => 0,
			];
		}

		if ($sum_cabang) {
			foreach ($sum_cabang as $key => $value) {
				// to graph
			    foreach ($temp_cabang_graph as &$graph) {
					if ($value['kode_cabang'] == $graph['code']) {
				        $graph['aktif'] = $value['aktif'];
						$graph['cuti'] = $value['cuti'];
						$graph['non_aktif'] = $value['non_aktif'];
						// $graph['drop_out'] = $value['drop_out'];
						// $graph['pindah'] = $value['pindah'];
						$graph['keluar'] = $value['keluar'];
					}
			    }
			}
		}

		$graphs = [
			['name' => 'Aktif','data' => array_column($temp_cabang_graph, 'aktif')],
			['name' => 'Cuti', 'data' => array_column($temp_cabang_graph, 'cuti')],
			['name' => 'Non-Aktif', 'data' => array_column($temp_cabang_graph, 'non_aktif')],
			// ['name' => 'Drop-Out (DO)', 'data' => array_column($temp_cabang_graph, 'drop_out')],
			// ['name' => 'Pindah', 'data' => array_column($temp_cabang_graph, 'pindah')],
			['name' => 'Keluar', 'data' => array_column($temp_cabang_graph, 'keluar')],
		];

		return [
			'graphs' => $graphs,
			'summary' => $temp_cabang_graph,
			'cabangs' => array_column($temp_cabang_graph, 'name')
		];
	}

	public function getSummaryCabang($tahun_periode)
	{
		$cabangs = $this->model_cabang->getCabangs();

		$this->biodatastatus->setSource($this->database);
		$sum_all_cabang = $this->biodatastatus->getSummaryAllCabang($tahun_periode);

		// Set default
		$temp_cabang_graph['name'] = 'Jumlah Mahasiswa / PD';
		foreach ($cabangs as $key => $value) {
			if (empty($value['namacabang']) || empty($value['kodecabang'])) {
				continue;
			}

			$temp_cabang_graph['data'][] = [
				'x' => def($value, 'namacabang'),
				'y' => 0,
				'code' => def($value, 'kodecabang'),
			];
		}

		if ($sum_all_cabang) {
			foreach ($sum_all_cabang as $key => $value) {
				// to graph
			    foreach ($temp_cabang_graph['data'] as &$graph) {
					if ($value['kodecabang'] == $graph['code']) {
				        $graph['y'] = $value['total'];
					}
			    }
			}
		}

		// $graphs = [
		// 	['name' => 'Total', 'data' => array_column($temp_cabang_graph, 'total')],
		// ];

		return [
			'graphs' => $temp_cabang_graph,
			'summary' => $temp_cabang_graph['data'],
			'cabangs' => array_column($temp_cabang_graph['data'], 'x')
		];
	}

	public function getImage($data = null)
	{
		$websites = json_decode($this->setting->getSettingValue('student_web'), true);
		$website = def($websites, $this->student_website);

		$profile_pic = '';

		if ($website) {
			$profile_pic = $data ? def($data, 'foto') : def($this, 'foto');
			$profile_pic = strpos($profile_pic, 'default-profile-photo') !== false ? $profile_pic : $website .'/'. $profile_pic;
		}

		return $this->helpers->getImage($profile_pic);
	}

	public function getListTahunAngkatan($cabang = null)
	{
		$model =  $this->find()
				->select(['TahunAngkatan'])
				->where(['TahunAngkatan >' => 0])
				->group_by('TahunAngkatan')
				->order_by('TahunAngkatan', 'desc');

		if ($cabang) {
			$model->where(['kodecabang' => $cabang]);
		}

		$datas = $model->get()->result_array();

		$tahun_angkatans = [];

		if ($datas) {
			foreach ($datas as $key => $value) {
				$tahun_angkatans[$value['TahunAngkatan']] = $value['TahunAngkatan'];
			}
		}

		return $tahun_angkatans;
	}

	public function getListCabang($tahun_angkatan = null)
	{
		$model = $this->find()
					->select(['biodata.kodecabang', 'cabang.namacabang'])
					->join('cabang', 'cabang.kodecabang = biodata.kodecabang')
					->group_by('biodata.kodecabang')
					->order_by('biodata.kodecabang', 'desc');

		if ($tahun_angkatan) {
			$model->where(['TahunAngkatan' => $tahun_angkatan]);
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

	public function getGender($sex = null)
	{
		$genders = [1 => 'Laki-laki', 2 => 'Perempuan'];

		if (!$sex) {
			$sex = $this->Sex;
		}

		return !empty($genders[$sex]) ? $genders[$sex] : '-';
	}
}

/* End of file Biodatacollege.php */
/* Location: ./application/models/Biodatacollege.php */