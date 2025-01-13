<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Realisasipenempatancollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'realisasi_penempatan';
	public $soft_delete = false;

	protected $cabang;
	protected $jurusan_cabang;

	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/cabangcollege',
			'colleges/jurusancabangcollege',
		]);

		$this->cabang = $this->cabangcollege;
		$this->jurusan_cabang = $this->jurusancabangcollege;
	}

	public function getListTahunAngkatan($kode_cabang = null)
	{
		$model =  $this->find()
				->select(['ta'])
				->group_by('ta')
				->order_by('ta', 'desc');

		if ($kode_cabang) {
			$model->where(['kodecabang' => $kode_cabang]);
		}

		$datas = $model->get()->result_array();

		$tahun_angkatans = [];

		if ($datas) {
			foreach ($datas as $key => $value) {
				$tahun_angkatans[$value['ta']] = $value['ta'];
			}
		}

		return $tahun_angkatans;
	}

	public function getRecap($tahun_angkatan, $tanggal_awal = '', $tanggal_akhir = '', $all = false)
	{
		$model = $this->setAlias('rp')->find()
					->select([
						"cabang.kodecabang",
						"cabang.namacabang",
						"SUM(rp.jml_alumni) AS jumlah_mahasiswa",
						"SUM(rp.target_pnt) AS total_target",
						"SUM(rp.target1) AS target_wajib",
						"SUM(rp.k_cnp1) AS real_wajib_cnp",
						"SUM(rp.k_sendiri1) AS real_wajib_sendiri",
						"SUM(rp.wirausaha1) AS real_wajib_wirausaha",
						"SUM(rp.terget2) AS target_dibantu",
						"SUM(rp.k_cnp2) AS real_dibantu_cnp",
						"SUM(rp.k_sendiri2) AS real_dibantu_sendiri",
						"SUM(rp.wirausaha2) AS real_dibantu_wirausaha",
						"rp.tgl_input",
					])
					->join('cabang', 'cabang.kodecabang = rp.kodecabang')
					->join('(SELECT kodecabang, MAX(tgl_input) AS Last_Update
						     FROM realisasi_penempatan
						     WHERE ta = '. $this->db->escape($tahun_angkatan) .'
						     GROUP BY kodecabang) AS subq', 'rp.kodecabang = subq.kodecabang AND rp.tgl_input = subq.Last_Update')
					->where(['ta' => $tahun_angkatan]);

		if ($tanggal_awal) {
			$model->where(['tgl_input >=' => $tanggal_awal]);
		}

		if ($tanggal_akhir) {
			$model->where(['tgl_input <=' => $tanggal_akhir]);
		}

		if ($all === false) {
			return $model->group_by('cabang.kodecabang')
					->get()->result_array();
		} else {
			return $model->get()->row_array();
		}
	}

	public function getSummary($tahun_angkatan, $kode_cabang = null)
	{
		$recap = $this->getRecap($tahun_angkatan, '', '', $kode_cabang === null);

		$summary = [
			'total_alumni' => 0,
			'non_target' => 0,
			'total_target' => 0,
			'by_cnp' => 0,
			'sendiri' => 0,
			'wirausaha' => 0,
			'on_progres' => 0,
		];

		// Ambil recap semua cabang, terus get cabang user
		if ($recap && $kode_cabang) {
			$index = array_search($kode_cabang, array_column($recap, 'kodecabang'));
			$recap = !empty($recap[$index]) ? $recap[$index] : null;
		}

		if ($recap) {
			$non_target = $recap['jumlah_mahasiswa'] - $recap['total_target'];
			$by_cnp = $recap['real_wajib_cnp'] + $recap['real_dibantu_cnp'];
			$sendiri = $recap['real_wajib_sendiri'] + $recap['real_dibantu_sendiri'];
			$wirausaha = $recap['real_wajib_wirausaha'] + $recap['real_dibantu_wirausaha'];
			$proses = $recap['total_target'] ? $recap['total_target'] - array_sum([$by_cnp, $sendiri, $wirausaha]) : 0;

			$summary = [
				'total_alumni' => number_format($recap['jumlah_mahasiswa']),
				'non_target' => number_format($non_target),
				'total_target' => number_format($recap['total_target']),
				'by_cnp' => number_format($by_cnp),
				'sendiri' => number_format($sendiri),
				'wirausaha' => number_format($wirausaha),
				'on_progres' => number_format($proses),

				'non_target_perc' => $non_target ? formatNumber(($non_target / $recap['total_target']) * 100, 1) : 0,
				'by_cnp_perc' => $by_cnp ? formatNumber(($by_cnp / $recap['total_target']) * 100, 1) : 0,
				'sendiri_perc' => $sendiri ? formatNumber(($sendiri / $recap['total_target']) * 100, 1) : 0,
				'wirausaha_perc' => $wirausaha ? formatNumber(($wirausaha / $recap['total_target']) * 100, 1) : 0,
				'proses_perc' => $proses ? formatNumber(($proses / $recap['total_target']) * 100, 1) : 0,
			];
		}

		return $summary;
	}

	public function getRecapJurusan($tahun_angkatan, $cabang, $tanggal_awal = '', $tanggal_akhir = '', $all = false)
	{
		$model = $this->setAlias('rp')->find()
					->select([
						"cabang.namacabang",
						"rp.kodejurusan",
						"jurusan.namajurusan",
						"rp.jml_alumni AS jumlah_mahasiswa",
						"rp.target_pnt AS total_target",
						"rp.target1 AS target_wajib",
						"rp.k_cnp1 AS real_wajib_cnp",
						"rp.k_sendiri1 AS real_wajib_sendiri",
						"rp.wirausaha1 AS real_wajib_wirausaha",
						"rp.terget2 AS target_dibantu",
						"rp.k_cnp2 AS real_dibantu_cnp",
						"rp.k_sendiri2 AS real_dibantu_sendiri",
						"rp.wirausaha2 AS real_dibantu_wirausaha",
						"rp.tgl_input",
					])
					->join('jurusan', 'jurusan.kodejurusan = rp.kodejurusan')
					->join('cabang', 'cabang.kodecabang = rp.kodecabang')
					->join('(SELECT kodejurusan, MAX( tgl_input ) AS Last_Update
						     FROM realisasi_penempatan
						     WHERE ta = '. $this->db->escape($tahun_angkatan) .'
						     	AND kodecabang = '. $this->db->escape($cabang) .'
						     GROUP BY kodejurusan) AS subq', 'rp.kodejurusan = subq.kodejurusan AND rp.tgl_input = subq.Last_Update')
					->where(['ta' => $tahun_angkatan, 'rp.kodecabang' => $cabang]);

		if ($tanggal_awal) {
			$model->where(['tgl_input >=' => $tanggal_awal]);
		}

		if ($tanggal_akhir) {
			$model->where(['tgl_input <=' => $tanggal_akhir]);
		}

		if ($all === false) {
			return $model->get()->result_array();
		} else {
			return $model->get()->row_array();
		}
	}

	public function getRecapByCabang($tahun_angkatan, $cabang = '')
	{
		$recaps = null;

		if ($cabang) {
			$recaps = $this->getRecapJurusan($tahun_angkatan, $cabang);
			$jurusans = $this->jurusan_cabang->getJurusans($tahun_angkatan);

			// set default
			$temp_graph = [];
			foreach ($jurusans as $key => $value) {
				$temp_graph[] = [
					'name' => $value['jurusan'],
					'code' => $value['kode'],
					'total_target' => 0,
					'by_cnp' => 0,
					'sendiri' => 0,
					'wirausaha' => 0,
					'proses' => 0,
				];
			}
		} else {
			$recaps = $this->getRecap($tahun_angkatan);
			$cabangs = $this->cabang->getCabangs();

			// set default
			$temp_graph = [];
			foreach ($cabangs as $key => $value) {
				$temp_graph[] = [
					'name' => $value['namacabang'],
					'code' => $value['kodecabang'],
					'total_target' => 0,
					'by_cnp' => 0,
					'sendiri' => 0,
					'wirausaha' => 0,
					'proses' => 0,
				];
			}
		}

		if ($recaps) {
			foreach ($recaps as $key => $recap) {
				$by_cnp = intval($recap['real_wajib_cnp']) + intval($recap['real_dibantu_cnp']);
				$sendiri = intval($recap['real_wajib_sendiri']) + intval($recap['real_dibantu_sendiri']);
				$wirausaha = intval($recap['real_wajib_wirausaha']) + intval($recap['real_dibantu_wirausaha']);
				$proses = $recap['total_target'] ? intval($recap['total_target']) - array_sum([$by_cnp, $sendiri, $wirausaha]) : 0;

				foreach ($temp_graph as $key1 => $graph) {
					if (
						(!empty($recap['kodecabang']) && $recap['kodecabang'] == $graph['code']) 
						|| (!empty($recap['kodejurusan']) && $recap['kodejurusan'] == $graph['code'])
					) {
						$temp_graph[$key1]['total_target'] = intval($recap['total_target']);
						$temp_graph[$key1]['by_cnp'] = $by_cnp;
						$temp_graph[$key1]['sendiri'] = $sendiri;
						$temp_graph[$key1]['wirausaha'] = $wirausaha;
						$temp_graph[$key1]['proses'] = $proses;
					}
			    }
			}

			if ($cabang) {
				$temp_graph = array_values(array_filter($temp_graph, function ($data) {
					return !empty($data['total_target']);
				}));
			}
		}

		$graphs = [
			// ['name' => 'Total Target', 'data' => array_column($temp_graph, 'total_target')],
			['name' => 'Kerja By C&P', 'data' => array_column($temp_graph, 'by_cnp')],
			['name' => 'Sendiri', 'data' => array_column($temp_graph, 'sendiri')],
			['name' => 'Wirausaha', 'data' => array_column($temp_graph, 'wirausaha')],
			['name' => 'On Proses', 'data' => array_column($temp_graph, 'proses')],
		];

		return [
			'graphs' => $graphs,
			'summary' => $temp_graph,
			'columns' => array_column($temp_graph, 'name')
		];

		return $recap;
	}
}
