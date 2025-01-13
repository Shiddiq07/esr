<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Alumniaktifitascollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'alumni_aktifitas';
	public $primaryKey = 'id';
	public $soft_delete = false;

	public $datatable_columns = ['alumni_aktifitas.id', 'alumni_aktifitas.nim', 'biodata.Nama_Mahasiswa', 'alumni_aktifitas.ips3', 'jurusan.namajurusan', 'perusahaan.nama', 'alumni_aktifitas.posisi', 'alumni_aktifitas.gaji', 'alumni_aktifitas.aktifitas_tgl', 'alumni_aktifitas.status'];
	public $datatable_search = ['alumni_aktifitas.nim', 'biodata.Nama_Mahasiswa', 'jurusan.namajurusan', 'perusahaan.nama', 'alumni_aktifitas.posisi'];
	public $datatable_order = ['biodata.Nama_Mahasiswa', 'asc'];

	const STATUS_KERJA = 1;
	const STATUS_MAGANG = 2;

	const STATUS_DIPROSES = 0;
	const STATUS_DITERIMA = 1;
	const STATUS_DITOLAK = 2;

	// Custom filter
	public $cabang;
	public $tahun_angkatan;
	public $tanggal_dari;
	public $tanggal_sampai;
	public $status_aktifitas;

	public function __construct()
	{
		parent::__construct();
	}

	protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName)
        	->distinct()
        	->select($this->datatable_columns)
        	->where(['diterima' => self::STATUS_DITERIMA])
        	->join('biodata', 'biodata.nim = alumni_aktifitas.nim', 'left')
        	->join('jurusan', 'jurusan.kodejurusan = biodata.kode', 'left')
        	->join('perusahaan', 'perusahaan.id_perusahaan = alumni_aktifitas.id_perusahaan', 'left');
 
        if ($this->cabang) {
        	$this->_dbr->where('alumni_aktifitas.kodecabang', $this->cabang);
        }
 
        if ($this->tahun_angkatan) {
        	$this->_dbr->where('alumni_aktifitas.ta', $this->tahun_angkatan);
        }
 
        if ($this->status_aktifitas) {
        	$this->_dbr->where('alumni_aktifitas.status', $this->status_aktifitas);
        }
 
        if ($this->tanggal_dari) {
			$this->_dbr->where(['alumni_aktifitas.aktifitas_tgl >=' => $this->tanggal_dari]);
		}

		if ($this->tanggal_sampai) {
			$this->_dbr->where(['alumni_aktifitas.aktifitas_tgl <=' => $this->tanggal_sampai]);
		}

        $i = 0;

        foreach ($this->datatable_search as $item) {
			# jika datatable mengirimkan pencarian dengan metode POST
            if($_POST['search']['value']) {
                 
                if ($i === 0) {
                    $this->_dbr->group_start(); 
                    $this->_dbr->like($item, $_POST['search']['value']);

                } else {
                    $this->_dbr->or_like($item, $_POST['search']['value']);
                }
 
                if (count($this->datatable_search) - 1 == $i) {
                    $this->_dbr->group_end(); 
                }
            }

            $i++;
        }

        if(isset($_POST['order'])) {
            $this->_dbr->order_by($this->datatable_columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } elseif(isset($this->datatable_order)) {
            $order = $this->datatable_order;
            $this->_dbr->order_by($order[0], $order[1]);

        }
    }

	public function getJumlahs($id_perusahaan, $tanggal_awal = null, $tanggal_akhir = null)
	{
		$model = $this->find()
				->select([
					'status',
					'COUNT(*) jumlah'
				])
				->where(['id_perusahaan' => $id_perusahaan, 'diterima' => self::STATUS_DITERIMA])
				->group_by(['status']);

		if ($tanggal_awal) {
			$model->where(['DATE(aktifitas_tgl) >=' => $tanggal_awal]);
		}

		if ($tanggal_akhir) {
			$model->where(['DATE(aktifitas_tgl) <=' => $tanggal_akhir]);
		}

		$data = $model->get()->result_array();

		return array_column($data, 'jumlah', 'status');
	}

	public function getGraphKeterangan($tahun_angkatan, $excepts = [], $kode_cabang = null)
	{
		$model = $this->find()
				->select([
					'keterangan_gagal.keterangan',
					'COUNT(*) jumlah'
				])
				->join('keterangan_gagal', 'keterangan_gagal.id = CONCAT(\'\', alumni_aktifitas.keterangan * 1)')
				->where(['DATE(aktifitas_tgl) >=' => '2018-01-01'])
				->where([
					'DATE(aktifitas_tgl) >=' => $tahun_angkatan .'-01-01',
					'DATE(aktifitas_tgl) >=' => $tahun_angkatan .'-12-31',
				])
				->group_by(['CONCAT(\'\', alumni_aktifitas.keterangan * 1)']);

		if ($excepts) {
			$model->where_not_in('keterangan_gagal.id', $excepts);
		}

		if ($kode_cabang) {
			$model->where(['kodecabang' => $kode_cabang]);
		}

		$data = $model->get()->result_array();

		return [
			'columns' => array_column($data, 'keterangan'),
			'series' => array_map('intval', array_column($data, 'jumlah')),
			'data' => $data,
		];
	}

	public function getListTahunAngkatan($kode_cabang)
	{
		$datas =  $this->find()
				->select(['ta'])
				->group_by('ta')
				->where(['kodecabang' => $kode_cabang])
				->order_by('ta', 'desc')
				->get()->result_array();

		$tahun_angkatans = [];

		if ($datas) {
			foreach ($datas as $key => $value) {
				$tahun_angkatans[$value['ta']] = $value['ta'];
			}
		}

		return $tahun_angkatans;
	}

}

/* End of file Alumniaktifitascollege.php */
/* Location: ./application/models/colleges/Alumniaktifitascollege.php */ ?>