<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ListDropdownController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('Response');

		$this->load->model([
			'biodata',
			'jurusancabang',
		]);
	}

	public function actionTahunBiodata($src = 'college')
	{
		$cabang = $this->input->get('cabang');

		$this->biodata->setSource($src);
		$list_tahun_angkatan = $this->biodata->getListTahunAngkatan($cabang);

		return $this->response->api([], $list_tahun_angkatan);
	}

	public function actionJurusanCabang($src = 'college')
	{
		$tahun = $this->input->get('tahun');
		$cabang = $this->input->get('cabang');

		$this->jurusancabang->setSource($src);
		$list_jurusan = $this->jurusancabang->getListJurusans(null, $cabang);

		return $this->response->api([], $list_jurusan);
	}

}

/* End of file ListDropdownController.php */
/* Location: ./application/modules/api/controllers/ListDropdownController.php */