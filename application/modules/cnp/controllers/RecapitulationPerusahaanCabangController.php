<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationPerusahaanCabangController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('curly');

		$this->load->model([
			'colleges/perusahaancollege',
			'colleges/alumniaktifitascollege',
			'polteks/perusahaanplj',
			'cabang',
			'perusahaan',
			'alumniaktifitas',
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

		$this->cabang->setSource($src);
		$list_cabang = $this->helpers->isLokal() ? [] : $this->cabang->getListCabang();

		$this->layout->title = 'Data Perusahaan';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_cabang' => $list_cabang
		]);
	}

	public function actionGetData($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if (!$this->input->is_ajax_request()) {
			show_error('Halaman tidak valid', 404);exit();
		}

		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang');
		$tanggal_dari = def($this->input->get(), 'tanggal_dari');
		$tanggal_sampai = def($this->input->get(), 'tanggal_sampai');

		$this->alumniaktifitas->setSource($src);

		$model_name = 'Perusahaan' . $src;
		$model = new $model_name;
		$model->cabang = $cabang;
		$model->tanggal_dari = $tanggal_dari;
		$model->tanggal_sampai = $tanggal_sampai;

		$list = $model->get_datatables();
        $data = [];
        $no = $_POST['start'];

        $manajemen_host = $src == 'college' ? 'https://manajemen.lp3i.ac.id/' : 'https://sim.lp3ijkt.ac.id/';

        foreach ($list as $field) {
        	$tgl_entry = $this->helpers->isValidDate($field->tgl_entry) ? date('d-m-Y', strtotime($field->tgl_entry)) : '-';
			$mou_tgl = $this->helpers->isValidDate($field->mou_tgl) ? date('d-m-Y', strtotime($field->mou_tgl)) : '-';
			$file_mou = $field->file_mou ? $this->html->a('<i class="bi bi-download"><i></div>', $manajemen_host . $field->file_mou, ['target' => '_blank']) : '-';

			$jumlahs = $this->alumniaktifitas->getJumlahs($field->id_perusahaan);

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->namacabang;
            $row[] = $field->nama;
            $row[] = $field->skala;
            $row[] = $mou_tgl;
            $row[] = $field->alamat;
            $row[] = $field->pic;
            $row[] = $field->telepon;
            $row[] = '<div class="text-center">'. def($jumlahs, Alumniaktifitascollege::STATUS_KERJA, '-') .'</div>';
            $row[] = '<div class="text-center">'. $file_mou .'</div>';

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

	public function actionSummary($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang');
		$tanggal_dari = def($this->input->get(), 'tanggal_dari');
		$tanggal_sampai = def($this->input->get(), 'tanggal_sampai');

		$this->perusahaan->setSource($src);
		$summaries = $this->perusahaan->getSummarySkala($cabang, [
        	'tanggal_dari' => $tanggal_dari,
			'tanggal_sampai' => $tanggal_sampai,
        ]);

        return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode($summaries));
	}
}

/* End of file RecapitulationPerusahaanCabangController.php */
/* Location: ./application/modules/cnp/controllers/RecapitulationPerusahaanCabangController.php */