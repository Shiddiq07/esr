<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcademicController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('Response');

		$this->load->model([
			'biodata',
		]);
	}

	public function actionSummary($src = 'college')
	{
		$tahun_periode = $this->input->get('year');
		$cabang = $this->input->get('cabang');

		$this->biodata->setSource($src);
		$summary = $this->biodata->getAllSummary($tahun_periode, $cabang);

		return $this->response->api([], $summary);
	}

	public function actionGraphStatus($src = 'college')
	{
		$tahun_periode = $this->input->get('periode');
		$kode_cabang = $this->input->get('kode_cabang');

		$this->biodata->setSource($src);

		$monthly_sum = $this->biodata->getWeeklyReport($tahun_periode, $kode_cabang);

		return $this->response->api([], $monthly_sum);
	}

	public function actionGraphProdi($src = 'college')
	{
		$tahun_periode = $this->input->get('periode');
		$kode_cabang = $this->input->get('cabang');

		$this->biodata->setSource($src);
		$monthly_prodi_sum = $this->biodata->getSumProdiReport($tahun_periode, $kode_cabang);

		return $this->response->api([], $monthly_prodi_sum);
	}

	public function actionGraphCabang($src = 'college')
	{
		$tahun_periode = $this->input->get('periode');

		$this->biodata->setSource($src);

		$monthly_cabang_sum = $this->biodata->getSumCabangReport($tahun_periode);

		return $this->response->api([], $monthly_cabang_sum);
	}

	public function actionGraphAllCabang($src = 'college')
	{
		$tahun_periode = $this->input->get('periode');

		$this->biodata->setSource($src);

		$monthly_cabang_sum = $this->biodata->getSummaryCabang($tahun_periode);

		return $this->response->api([], $monthly_cabang_sum);
	}
}

/* End of file AcademicController.php */
/* Location: ./application/modules/api/controllers/AcademicController.php */