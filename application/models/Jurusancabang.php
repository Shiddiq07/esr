<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'models/Multimodel.php';

class Jurusancabang extends Multimodel
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'colleges/jurusancabangcollege',
			'polteks/jurusancabangplj'
		]);
	}

	public function getJurusans($tahun = null, $cabang = null)
	{
		return $this->{'jurusancabang' . $this->src}->getJurusans($tahun, $cabang);
	}

	public function getListJurusans($tahun = null, $cabang = null)
	{
		return $this->{'jurusancabang' . $this->src}->getListJurusans($tahun, $cabang);
	}

	public function getListInitial($tahun = null)
	{
		$jurusans = $this->getJurusans($tahun);
		$list_jurusans = array_column($jurusans, 'jurusan');

		$initials = [];

		foreach ($list_jurusans as $key => $value) {
			$initials[] = getInitials($value);
		}

		return $initials;
	}

	public function getNamaJurusan($kodejurusan)
	{
		return $this->{'jurusancabang' . $this->src}->getNamaJurusan($kodejurusan);
	}
}

/* End of file Jurusancabang.php */
/* Location: ./application/models/Jurusancabang.php */