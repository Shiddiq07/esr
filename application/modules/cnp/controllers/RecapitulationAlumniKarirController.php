<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RecapitulationAlumniKarirController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'realisasipenempatan',
			'colleges/alumniaktifitascollege',
			'polteks/alumniaktifitasplj',
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

		// $this->realisasipenempatan->setSource($src);
		// $list_tahun_angkatan = $this->realisasipenempatan->getListTahunAngkatan();
		$this->cabang->setSource($src);
		$list_cabang = $this->cabang->getListCabang();

		$this->layout->title = 'Rekapitulasi Alumni Magang/Kerja';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'src' => $src,
			// 'list_tahun_angkatan' => $list_tahun_angkatan,
			'list_cabang' => $list_cabang,
		]);
	}

	public function actionGetTahunAngkatan($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang');

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

	public function actionGetData($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if (!$this->input->is_ajax_request()) {
			show_error('Halaman tidak valid', 404);exit();
		}

		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang');
		$tahun_angkatan = $this->input->get('tahun_angkatan');
		$status = $this->input->get('status');
		$tanggal_dari = def($this->input->get(), 'tanggal_dari');
		$tanggal_sampai = def($this->input->get(), 'tanggal_sampai');

		$model_name = 'alumniaktifitas' . $src;
		$model = new $model_name;
		$model->cabang = $cabang;
		$model->tahun_angkatan = $tahun_angkatan;
		$model->status_aktifitas = $status;
		$model->tanggal_dari = $tanggal_dari;
		$model->tanggal_sampai = $tanggal_sampai;

		$list = $model->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $field) {
        	$aktifitas_tgl = $this->helpers->isValidDate($field->aktifitas_tgl) ? date('d-m-Y', strtotime($field->aktifitas_tgl)) : '-';
        	$status = '-';

        	if ($field->status == $model_name::STATUS_KERJA) {
        		$status = 'Kerja';
        	} elseif ($field->status == $model_name::STATUS_MAGANG) {
        		$status = 'Magang';
        	}

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nim;
            $row[] = $field->Nama_Mahasiswa;
            $row[] = number_format($field->ips3, 2);
            $row[] = $field->namajurusan;
            $row[] = $field->nama;
            $row[] = $field->posisi;
            $row[] = is_numeric($field->gaji) ? number_format($field->gaji) : 0;
            $row[] = $aktifitas_tgl;
            $row[] = $status;

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

}

/* End of file RecapitulationAlumniKarirController.php */
/* Location: ./application/modules/cnp/controllers/RecapitulationAlumniKarirController.php */ ?>