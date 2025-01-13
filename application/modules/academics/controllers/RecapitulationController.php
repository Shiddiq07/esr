<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('curly');

		$this->load->model([
			'jurusancabang',
			'biodatastatus'
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

		$this->layout->title = 'Rekapitulasi';
		$this->layout->view_js = '_partial/recap_js';
		$this->layout->render('index', [
			'src' => $src,
		]);
	}

	public function actionGetTableRecap($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun = def($this->input->get(), 'year', date('Y') .'-'. date('Y'));

		$this->biodatastatus->setSource($src);
		$recaps = $this->biodatastatus->getGroupedRecap($tahun);

		echo $this->layout->renderPartial('_table_recapitulation', [
			'tahun' => $tahun,
			'recaps' => $recaps
		], true);
	}

	public function actionExportPdf($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$tahun = def($this->input->get(), 'year', date('Y') .'-'. date('Y'));

		$this->biodatastatus->setSource($src);
		$recaps = $this->biodatastatus->getGroupedRecap($tahun);

		$table = $this->layout->renderPartial('_table_recapitulation', [
			'tahun' => $tahun,
			'recaps' => $recaps,
			'vanilla_css' => true,
		], true);

		$mpdf = new \Mpdf\Mpdf([
			'orientation' => 'L',
		]);

		$title = 'Rekapitulasi Status Mahasiswa '. $tahun;

		$mpdf->SetTitle($title);
		$mpdf->SetSubject($title);
		$mpdf->SetAuthor(APP_NAME);
		$mpdf->SetCreator(APP_NAME);
		$mpdf->setFooter('{PAGENO}');
		$mpdf->writeHTML($table);
		$mpdf->output($title .'.pdf', 'D');
	}
}

/* End of file RecapitulationController.php */
/* Location: ./application/modules/academics/controllers/RecapitulationController.php */