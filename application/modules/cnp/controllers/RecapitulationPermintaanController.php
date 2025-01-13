<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationPermintaanController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'colleges/permintaancollege',
			'polteks/permintaanplj',
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

		$this->permintaan->setSource($src);
		$list_tahun_angkatan = $this->permintaan->getListTahun();

		$this->cabang->setSource($src);
		$list_cabang = $this->cabang->getListCabang();

		$this->layout->title = 'Rekapitulasi Permintaan';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_tahun_angkatan' => $list_tahun_angkatan,
			'list_cabang' => $list_cabang,
		]);
	}

	public function actionGetTable($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if ($filter = $this->input->get()) {
			$recaps = null;

			$this->permintaan->setSource($src);

			if ($filter['jenis'] == 1) {
				$recaps = $this->permintaan->getRecapByTahun($filter['tahun_angkatan']);

				echo $this->layout->renderPartial('_table_recap_permintaan-nasional', [
					'src' => $src,
					'filter' => $filter,
					'recaps' => $recaps
				], true);exit();
			} elseif ($filter['jenis'] == 2) {
				echo $this->layout->renderPartial('_table_recap_permintaan-cabang', [], true);exit();
			}
		}

		show_error('Halaman tidak valid', 404);exit();
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

		$model_name = 'Permintaan' . $src;
		$model = new $model_name;
		$model->cabang = $cabang;
		$model->tanggal_dari = $tanggal_dari;
		$model->tanggal_sampai = $tanggal_sampai;

		$list = $model->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $field) {
        	$tgl_permintaan = $this->helpers->isValidDate($field->tgl_permintaan) ? date('d-m-Y', strtotime($field->tgl_permintaan)) : '-';

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $tgl_permintaan;
            $row[] = $field->nama;
            $row[] = $field->bidang_usaha;
            $row[] = $field->mou == 1 ? 'MOU' : 'Baru';
            $row[] = $field->telepon;
            $row[] = $field->posisi_permintaan;
            $row[] = $field->status_posisi == 1 ? 'Kerja' : 'Magang';

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

	public function actionExportPdf($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if ($filter = $this->input->get()) {
			$this->permintaan->setSource($src);
			$recaps = $this->permintaan->getRecapByTahun($filter['tahun_angkatan']);

			$html = $this->layout->renderPartial('_table_recap_permintaan-nasional', [
				'src' => $src,
				'filter' => $filter,
				'recaps' => $recaps,
				'is_pdf' => true
			], true);

			$mpdf = new \Mpdf\Mpdf([
				'orientation' => 'L',
			]);

			$title = 'Rekapitulasi Permintaan Tahun Angkatan'. $filter['tahun_angkatan'];

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