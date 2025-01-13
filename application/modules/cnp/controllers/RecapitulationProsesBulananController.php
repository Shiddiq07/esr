<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationProsesBulananController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('curly');

		$this->load->model([
			'colleges/perusahaancollege',
			'polteks/perusahaanplj',
			'realisasipenempatan',
			'cabang',
		]);
	}

	public function actionIndex($src = 'college')
	{
		$this->realisasipenempatan->setSource($src);
		$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

		$this->layout->title = 'Rekapitulasi Penempatan Proses Bulanan';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_tahun_angkatan' => $list_tahun_angkatan,
		]);
	}

	public function actionGetTable($src = 'college')
	{
		if ($filter = $this->input->get_post('Filter', true)) {
			$this->realisasipenempatan->setSource($src);
			$recaps = $this->realisasipenempatan->getRecap($filter['tahun_angkatan'], $filter['tanggal_awal'], $filter['tanggal_akhir']);

			echo $this->layout->renderPartial('_table_recap_proses-bulanan', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps
			], true);exit();
		}

		show_error('Halaman tidak valid', 404);exit();
	}

	public function actionExportPdf($src = 'college')
	{
		if ($filter = $this->input->get_post('Filter', true)) {
			$this->realisasipenempatan->setSource($src);
			$recaps = $this->realisasipenempatan->getRecap($filter['tahun_angkatan'], $filter['tanggal_awal'], $filter['tanggal_akhir']);

			$html = $this->layout->renderPartial('_table_recap_proses-bulanan', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps,
				'is_pdf' => true
			], true);

			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
			]);

			$title = 'Tabulasi Penempatan Magang & Kerja Tahun Angkatan'. $filter['tahun_angkatan'];

			$mpdf->SetTitle($title);
			$mpdf->SetSubject($title);
			$mpdf->SetAuthor(APP_NAME);
			$mpdf->SetCreator(APP_NAME);
			$mpdf->setFooter('{PAGENO}');
			$mpdf->writeHTML($html);
			$mpdf->output($title .'.pdf', 'D');
		}

		show_error('Halaman tidak valid', 404);exit();
	}
}

/* End of file RecapitulationProsesBulananController.php */
/* Location: ./application/modules/cnp/controllers/RecapitulationProsesBulananController.php */