<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationRerataGajiController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'jurusancabang',
			'reportgaji',
			'gajikonfig',
			'cabang',
		]);
	}

	public function actionIndex($src = 'college')
	{
		$this->reportgaji->setSource($src);
		$list_tahun_angkatan = $this->reportgaji->getListTahunAngkatan();

		// $this->cabang->setSource($src);
		// $list_cabang = $this->cabang->getListCabang();

		$this->layout->title = 'Rekapitulasi Rata-rata Gaji';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_tahun_angkatan' => $list_tahun_angkatan,
			// 'list_cabang' => $list_cabang,
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

		$this->reportgaji->setSource($src);
		$list_cabang = $this->reportgaji->getListCabang($tahun_angkatan);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($list_cabang));
	}

	public function actionGetTable($src = 'college')
	{
		if ($filter = $this->input->get()) {
			$this->gajikonfig->setSource($src);
			$skalas = $this->gajikonfig->getListSkala();

			if ($filter['jenis'] == 1) {
				$this->reportgaji->setSource($src);
				$recaps = $this->reportgaji->getRekapNasional($filter['tahun_angkatan']);

				echo $this->layout->renderPartial('_table_recap_rerata-nasional', [
					'src' => $src,
					'filter' => $filter,
					'skalas' => $skalas,
					'recaps' => $recaps
				], true);exit();

			} elseif ($filter['jenis'] == 2) {
				$this->reportgaji->setSource($src);
				$recaps = $this->reportgaji->getRekapByCabang($filter['tahun_angkatan'], $filter['cabang']);
				$kampus = '';

				if ($recaps) {
					$kampus = ($src == 'college') ? str_replace('kampus', '', strtolower($recaps[0]['namacabang'])) : strtolower($recaps[0]['namacabang']);
				}

				$this->jurusancabang->setSource($src);
				$model_jurusan = $this->jurusancabang;

				echo $this->layout->renderPartial('_table_recap_rerata-cabang', [
					'src' => $src,
					'filter' => $filter,
					'kampus' => $kampus,
					'skalas' => $skalas,
					'recaps' => $recaps,
					'model_jurusan' => $model_jurusan,
				], true);exit();
			}
		}

		show_error('Halaman tidak valid', 404);exit();
	}

	public function actionExportPdf($src = 'college')
	{
		if ($filter = $this->input->get()) {
			$this->reportgaji->setSource($src);

			$this->gajikonfig->setSource($src);
			$skalas = $this->gajikonfig->getListSkala();

			if ($filter['jenis'] == 1) {
				$recaps = $this->reportgaji->getRekapNasional($filter['tahun_angkatan']);

				$html = $this->layout->renderPartial('_table_recap_rerata-nasional', [
					'src' => $src,
					'filter' => $filter,
					'skalas' => $skalas,
					'recaps' => $recaps,
					'is_pdf' => true
				], true);

			} elseif ($filter['jenis'] == 2) {
				$recaps = $this->reportgaji->getRekapByCabang($filter['tahun_angkatan'], $filter['cabang']);
				$kampus = ($src == 'college') ? str_replace('kampus', '', strtolower($recaps[0]['namacabang'])) : strtolower($recaps[0]['namacabang']);

				$html = $this->layout->renderPartial('_table_recap_rerata-cabang', [
					'src' => $src,
					'filter' => $filter,
					'kampus' => $kampus,
					'skalas' => $skalas,
					'recaps' => $recaps,
					'is_pdf' => true
				], true);
			}

			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
			]);

			$title = 'Rekapitulasi Rata-rata Gaji Tahun Angkatan'. $filter['tahun_angkatan'];

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