<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nilaicollege extends MY_Model
{
	protected $database = 'college';
	protected $timestamps = false;
	protected $blameable = false;
	public $tableName = 'nilai';
	public $primaryKey = 'id';
	public $soft_delete = false;

	public $datatable_columns = [
		"ROW_NUMBER() OVER (ORDER BY nim) AS id",
		"nm.nim",
    	"mhs.Nama_Mahasiswa",
    	"SUM(nm.sks) AS total_sks",
    	"ROUND(AVG(CASE WHEN nm.semester = 1 THEN nm.ip END), 2) AS semester_1",
    	"ROUND(AVG(CASE WHEN nm.semester = 2 THEN nm.ip END), 2) AS semester_2",
    	"ROUND(AVG(CASE WHEN nm.semester = 3 THEN nm.ip END), 2) AS semester_3",
    	"ROUND(AVG(CASE WHEN nm.semester = 4 THEN nm.ip END), 2) AS semester_4",
    	"ROUND(AVG(CASE WHEN nm.semester = 5 THEN nm.ip END), 2) AS semester_5",
    	"ROUND(AVG(CASE WHEN nm.semester = 6 THEN nm.ip END), 2) AS semester_6",
    	"ROUND(AVG(nm.ip), 2) AS rerata",
    ];
	public $datatable_search = ['nm.nim', 'mhs.Nama_Mahasiswa'];
	public $datatable_order = ['mhs.Nama_Mahasiswa', 'asc'];

	public $tahun_angkatan;
	public $jurusan;

	public function __construct()
	{
		parent::__construct();
	}

	protected function _get_datatables_query()
    {
        $this->_dbr->from($this->tableName .' nm')
        	->distinct()
        	->select($this->datatable_columns)
            ->where_in('LOWER(mhs.status)', ['aktif', 'lulus'])
        	->join('biodata mhs', 'mhs.nim = nm.nim')
        	->group_by('nm.nim');

        if ($this->tahun_angkatan) {
        	$this->_dbr->where('nm.TahunAngkatan', $this->tahun_angkatan);
        }

        if ($this->jurusan) {
        	$this->_dbr->where('nm.kodejurusan', $this->jurusan);
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
}

/* End of file Nilaicollege.php */
/* Location: ./application/models/colleges/Nilaicollege.php */