<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationProsesPenempatanController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'realisasipenempatan',
			'cabang',
		]);
	}

	public function actionIndex($src = 'college')
	{
		// $this->realisasipenempatan->setSource($src);
		// $list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

		$this->cabang->setSource($src);
		$list_cabang = $this->cabang->getListCabang();

		$this->layout->title = 'Rekapitulasi Proses Penempatan';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			// 'list_tahun_angkatan' => $list_tahun_angkatan,
			'list_cabang' => $list_cabang,
		]);
	}

	public function actionGetTahunAngkatan($src = 'college')
	{
		$cabang = $this->input->get('cabang');

		if (!$cabang) {
			return $this->output
		        ->set_content_type('application/json')
		        ->set_status_header(404);
		}

		$this->realisasipenempatan->setSource($src);
		$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan($cabang);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($list_tahun_angkatan));
	}

	public function actionGetTable($src = 'college')
	{
		if ($filter = $this->input->get_post('Filter', true)) {
			$this->realisasipenempatan->setSource($src);
			$recaps = $this->realisasipenempatan->getRecapJurusan($filter['tahun_angkatan'], $filter['cabang'], $filter['tanggal_awal'], $filter['tanggal_akhir']);

			echo $this->layout->renderPartial('table-recap', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps
			], true);
		}
	}

	public function actionExportPdf($src = 'college')
	{
		if ($filter = $this->input->get_post('Filter', true)) {
			$this->realisasipenempatan->setSource($src);
			$recaps = $this->realisasipenempatan->getRecapJurusan($filter['tahun_angkatan'], $filter['cabang'], $filter['tanggal_awal'], $filter['tanggal_akhir']);
			$kampus = ($src == 'college') ? str_replace('kampus', '', strtolower($recaps[0]['namacabang'])) : strtolower($recaps[0]['namacabang']);

			$html = $this->layout->renderPartial('table-recap', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps,
				'kampus' => $kampus,
				'is_pdf' => true
			], true);

			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
			]);

			$title = 'Tabulasi Penempatan Magang & Kerja '. ucwords($kampus) .' Tahun Angkatan'. $filter['tahun_angkatan'];

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

/* End of file RecapitulationProsesPenempatanController.php */
/* Location: ./application/modules/cnp/controllers/RecapitulationProsesPenempatanController.php */ ?>