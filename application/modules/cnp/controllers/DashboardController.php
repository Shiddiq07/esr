<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('curly');

		$this->load->model([
			'realisasipenempatan',
			'perusahaanskala',
			'alumniaktifitas',
			'perusahaan',
			'permintaan',
			'cabang',
		]);

		if ($this->helpers->isCollege()) {
			$this->def_source = 'college';
		} elseif ($this->helpers->isPoltek()) {
			$this->def_source = 'plj';
		}
	}

	public function actionIndex($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$this->realisasipenempatan->setSource($src);
		$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

		$this->cabang->setSource($src);
		$cabangs = $this->cabang->getListCabang();

		$this->perusahaan->setSource($src);
		$list_status_mou = $this->perusahaan->getListStatusMOU();

		$this->permintaan->setSource($src);
		$list_tahun_permintaan = $this->permintaan->getListTahun();

		$this->layout->title = 'C&P - Dashboard Tahun Angkatan <span id="span-ta">'. date('Y') .'</span>';
		$this->layout->view_js = 'index_js';
		$this->layout->render('index', [
			'type' => $src,
			'list_tahun_angkatan' => $list_tahun_angkatan,
			'cabangs' => $cabangs,
			'list_status_mou' => $list_status_mou,
			'list_tahun_permintaan' => $list_tahun_permintaan,
		]);
	}

	public function actionGetSummary($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun_angkatan = $this->input->get('tahun_angkatan', true);

		if (!$tahun_angkatan) {
			$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

			$tahun_angkatan = end($list_tahun_angkatan);
		}

		$kode_cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : null;

		$this->realisasipenempatan->setSource($src);
		$summary = $this->realisasipenempatan->getSummary($tahun_angkatan, $kode_cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode([
	        	'summary' => $summary,
	        	'tahun_angkatan' => $tahun_angkatan
	        ]));
	}

	public function actionGetPlacement($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun_angkatan = $this->input->get('tahun_angkatan', true);
		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang', true);

		if (!$tahun_angkatan) {
			$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

			$tahun_angkatan = end($list_tahun_angkatan);
		}

		$this->realisasipenempatan->setSource($src);
		$recap = $this->realisasipenempatan->getRecapByCabang($tahun_angkatan, $cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($recap));
	}

	public function actionGetGraphScale($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$status_mou = $this->input->get('status_mou', true);
		$is_contributed = $this->input->get('is_contributed', true);

		$kode_cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : null;

		$this->perusahaan->setSource($src);
		$recap_skala = $this->perusahaan->getRecapBySkala($status_mou, $is_contributed, $kode_cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($recap_skala));
	}

	public function actionGetGraphFailure($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun_angkatan = $this->input->get('tahun_angkatan', true);

		if (!$tahun_angkatan) {
			$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

			$tahun_angkatan = end($list_tahun_angkatan);
		}

		$kode_cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : null;

		$this->alumniaktifitas->setSource($src);
		$recap = $this->alumniaktifitas->getGraphKeterangan($tahun_angkatan, [1], $kode_cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($recap));
	}

	public function actionGetGraphRequest($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun_permintaan = $this->input->get('tahun_permintaan', true);

		if (!$tahun_permintaan) {
			$list_tahun_permintaan = $this->permintaan->getListTahun();

			$tahun_permintaan = end($list_tahun_permintaan);
		}

		$kode_cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : null;

		$this->permintaan->setSource($src);
		$graph = $this->permintaan->getGraphNasional($tahun_permintaan, $kode_cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($graph));
	}
}