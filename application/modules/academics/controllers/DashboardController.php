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
			'inisialperiode',
			'colleges/biodatastatuscollege',
			'polteks/biodatastatusplj',
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

		$this->inisialperiode->setSource($src);
		$inisial_periodes = $this->inisialperiode->getAllPeriode();
		$inisial_periode = end($inisial_periodes);

		$tahun_angkatan = substr($inisial_periode->ta, 0, 4);
		$periode = $inisial_periode->periode;

		$this->layout->title = 'Academic\'s Dashboard T.A '.'<span id="span-ta">'. $inisial_periode->ta .'</span>';
		$this->layout->view_js = '_partial/dash_js';
		$this->layout->render('index', [
			'type' => $src,
			'tahun_angkatan' => $tahun_angkatan,
			'periode' => $periode,
			'inisial_periodes' => $inisial_periodes,
		]);
	}

	public function actionDetail($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('periode');
		$status = def($this->input->get(), 'status', 'data_awal');
		$kode_jurusan = def($this->input->get(), 'kode_jurusan');
		$kode_cabang = def($this->input->get(), 'kode_cabang');

		if ($this->helpers->isLokal()) {
			$kode_cabang = $this->session->userdata('kodecabang');
		}

		$this->cabang->setSource($src);
		$nama_cabang = $this->cabang->getNamaByKode($kode_cabang);

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$this->layout->title = 'Detail Mahasiswa/PD '. slugToName($status) .' Periode '. $periode;
		$this->layout->view_js = '_partial/detail_js';
		$this->layout->render('detail', [
			'src' => $src,
			'periode' => $periode,
			'status' => $status,
			'kode_jurusan' => $kode_jurusan,
			'kode_cabang' => $kode_cabang,
			'nama_cabang' => $nama_cabang,
		]);
	}

	public function actionGetDataDetail($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if (!$this->input->is_ajax_request()) {
			show_error('Halaman tidak valid', 404);exit();
		}

		$periode = $this->input->get('periode');
		$status = def($this->input->get(), 'status', 'data_awal');
		$kode_jurusan = def($this->input->get(), 'kode_jurusan');
		$kode_cabang = def($this->input->get(), 'kode_cabang');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$model_name = 'Biodatastatus' . $src;
		$model = new $model_name;
		$model->periode = $periode;
		$model->status = $status;
		$model->kode_jurusan = $kode_jurusan;
		$model->kode_cabang = $kode_cabang;

		$list = $model->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nim;
            $row[] = $field->nama_mahasiswa;
            $row[] = $field->namacabang;
            $row[] = $field->namajurusan;
            $row[] = $field->tahun_periode;
            $row[] = $field->tingkat;

            $data[] = $row;
        }
 

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $model->count_all(),
            "recordsFiltered" => $model->count_filtered(),
            "data" => $data,
        );

        //output dalam format JSON
        echo json_encode($output);
	}

	public function actionGetSummary($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('period');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$url = '/api/academic/summary/'. $src .'?year='. $periode;

		if ($this->helpers->isLokal()) {
			$url .= '&cabang='. $this->session->userdata('kodecabang');
		}

		$tahun = substr($periode, 0, 4);
		$summary = $this->curly->get(site_url($url), [
			'Authorization: Bearer '. $this->session->userdata('token')
		]);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode([
	        	'summary' => $summary,
	        	'ta' => $tahun .'/'. ($tahun + 1)
	        ]));
	}

	public function actionGetStatusMhs($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('period');
		$kode_cabang = $this->input->get('kodeCabang');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$monthly_summary = $this->curly->get(site_url('/api/academic/graph-status/'. $src .'?periode='. $periode .'&kode_cabang='. $kode_cabang), [
			'Authorization: Bearer '. $this->session->userdata('token')
		]);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($monthly_summary));
	}

	public function actionGetStatusProdi($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('period');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$url = '/api/academic/graph-prodi/'. $src .'?periode='. $periode;
		if ($this->helpers->isLokal()) {
			$url .= '&cabang='. $this->session->userdata('kodecabang');
		}

		$monthly_summary_prodi = $this->curly->get(site_url($url), [
			'Authorization: Bearer '. $this->session->userdata('token')
		]);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($monthly_summary_prodi));
	}

	public function actionGetStatusCabang($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('period');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$monthly_summary_cabang = $this->curly->get(site_url('/api/academic/graph-cabang/'. $src .'?periode='. $periode), [
			'Authorization: Bearer '. $this->session->userdata('token')
		]);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($monthly_summary_cabang));
	}

	public function actionGetSumCabang($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$periode = $this->input->get('period');

		if (!$periode) {
			$this->inisialperiode->setSource($src);
			$inisial_periode = $this->inisialperiode->getCurrentPeriode();

			$periode = $inisial_periode['periode'];
		}

		$monthly_summary_cabang = $this->curly->get(site_url('/api/academic/graph-all-cabang/'. $src .'?periode='. $periode), [
			'Authorization: Bearer '. $this->session->userdata('token')
		]);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($monthly_summary_cabang));
	}

}

/* End of file DashboardController.php */
/* Location: ./application/modules/academics/controllers/DashboardController.php */