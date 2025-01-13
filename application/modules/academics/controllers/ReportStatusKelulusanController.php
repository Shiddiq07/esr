<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportStatusKelulusanController extends CI_Controller
{
	protected $def_source = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'jurusancabang',
			'biodata',
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

		$this->cabang->setSource($src);
		$list_cabang = $this->cabang->getListCabang();

		$list_tahun_angkatan = [];

		if ($this->helpers->isLokal()) {
			$this->biodata->setSource($src);
			$list_tahun_angkatan = $this->biodata->getListTahunAngkatan($this->session->userdata('kodecabang'));
		}

		$list_jurusan = [];

		if ($this->helpers->isLokal()) {
			$this->jurusancabang->setSource($src);
			$list_jurusan = $this->jurusancabang->getListJurusans(null, $this->session->userdata('kodecabang'));
		}

		$this->layout->title = 'Laporan Status Kelulusan';
		$this->layout->view_js = 'index_js';
		$this->layout->render('index', [
			'src' => $src,
			'list_cabang' => $list_cabang,
			'list_tahun_angkatan' => $list_tahun_angkatan,
			'list_jurusan' => $list_jurusan,
		]);
	}

	public function actionGetData($src = 'college')
	{
		$src = $this->def_source ? $this->def_source : $src;

		if (!$this->input->is_ajax_request()) {
			show_error('Halaman tidak valid', 404);exit();
		}

		$semester = 6;
		if ($src == 'college') {
			$semester = 4;
		}

		$cabang = $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : $this->input->get('cabang');
		$tahun_angkatan = $this->input->get('tahun_angkatan');
		$jurusan = $this->input->get('jurusan');

		$model_name = 'biodata' . $src;
		$model = new $model_name;
		$model->cabang = $cabang;
		$model->tahun_angkatan = $tahun_angkatan;
		$model->jurusan = $jurusan;

		$list = $model->get_datatables();
        $data = [];
        $no = $_POST['start'];

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nim;
            $row[] = $field->Nama_Mahasiswa;
            $row[] = $field->getGender();
            $row[] = $field->namajurusan;
            $row[] = $field->status;

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

/* End of file ReportStatusKelulusanController.php */
/* Location: ./application/modules/academics/controllers/ReportStatusKelulusanController.php */