<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Perusahaan extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/perusahaancollege',
			'polteks/perusahaanplj'
		]);
	}

	public function getListStatusMOU()
	{
		return $this->{'perusahaan' . $this->src}->getListStatusMOU();
	}

	public function getRecapBySkala($mou = null, $is_contributed = null, $kode_cabang = null)
	{
		return $this->{'perusahaan' . $this->src}->getRecapBySkala($mou, $is_contributed, $kode_cabang);
	}

	public function getSummarySkala($kode_cabang, $date_range = [])
	{
		return $this->{'perusahaan' . $this->src}->getSummarySkala($kode_cabang, $date_range);
	}
}

/* End of file Perusahaan.php */
/* Location: ./application/models/Perusahaan.php */