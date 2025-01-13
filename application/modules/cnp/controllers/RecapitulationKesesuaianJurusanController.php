<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationKesesuaianJurusanController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'realisasipenempatan',
			'detailkesesuaian',
			'cabang',
		]);
	}

	public function actionIndex($src = 'college')
	{
		$this->realisasipenempatan->setSource($src);
		$list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();

		$this->layout->title = 'Rekapitulasi Kesesuaian Jurusan';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_tahun_angkatan' => $list_tahun_angkatan,
		]);
	}

	public function actionGetCabang($src = 'college')
	{
		$tahun_angkatan = $this->input->get('tahun_angkatan');

		if (!$tahun_angkatan) {
			return $this->output
		        ->set_content_type('application/json')
		        ->set_status_header(404);
		}

		$this->detailkesesuaian->setSource($src);
		$list_cabang = $this->detailkesesuaian->getListCabang($tahun_angkatan);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($list_cabang));
	}

	public function actionGetTable($src = 'college')
	{
		if ($filter = $this->input->get()) {
			$this->detailkesesuaian->setSource($src);
			$recaps = $this->detailkesesuaian->getRecapJurusan($filter['tahun_angkatan'], $filter['cabang']);

			echo $this->layout->renderPartial('_table_recap_kesesuaian-jurusan', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps
			], true);exit();
		}

		show_error('Halaman tidak valid', 404);exit();
	}

	public function actionExportPdf($src = 'college')
	{
		if ($filter = $this->input->get()) {
			$this->detailkesesuaian->setSource($src);
			$recaps = $this->detailkesesuaian->getRecapJurusan($filter['tahun_angkatan'], $filter['cabang']);
			$kampus = ($src == 'college') ? str_replace('kampus', '', strtolower($recaps[0]['namacabang'])) : strtolower($recaps[0]['namacabang']);

			$html = $this->layout->renderPartial('_table_recap_kesesuaian-jurusan', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps,
				'kampus' => $kampus,
				'is_pdf' => true
			], true);

			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
			]);

			$title = 'Rekapitulasi Kesesuaian Jurusan Tahun Angkatan'. $filter['tahun_angkatan'];

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