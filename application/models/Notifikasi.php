<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_Model
{
	public $tableName = 'tbl_notifikasi';
	public $soft_delete = false;
	public $timestamps = true;
	public $blameable = true;
	const UPDATED_AT = null;

	const STATUS_UNREAD = 0;
	const STATUS_READ = 1;

	public function blameableBehavior()
    {
        return [
            'createdByAttribute' => 'triggered_by',
            'updatedByAttribute' => null,
            'value' => $this->session->userdata('identity')->id
        ];
    }

	public function getNotifications($to, $unread_only = false, $display = 'all')
	{
		$model = $this->find()
                    ->where(['to' => $to])
                    ->order_by('created_at', 'desc');


        if ($unread_only) {
            $model->where(['is_read' => 0]);
        }

        if (is_numeric($display)) {
        	$model->limit($display);
        }

        return [
        	'data' => $this->queryAll($model),
        	'count' => $this->countNotifications($to)
        ];
	}

	public function countNotifications($to)
	{
		$models = $this->findAll(['to' => $to]);

		$read = 0;
		$unread = 0;

		foreach ($models as $key => $model) {
			if ($model->is_read == 0) {
				$unread++;
			} else {
				$read++;
			}
		}

		return [
			'read' => $read,
			'unread' => $unread,
			'all' => count($models),
		];
	}

	public function getFetchedNotification($to, $is_read = '', $page = null)
	{
		$statuses = $this->getStatus();
		$where = ['to' => $to];

        if ($is_read != '' && !empty($statuses[$is_read])) {
        	$where['is_read'] = $is_read;
        }

        $this->load->library('pagination');

        $config['base_url'] = base_url('notifikasi/fetch-data');
		$config['total_rows'] = $this->count_all($where);
		$config['per_page'] = 5;
		$config['page_query_string'] = TRUE; // Aktifkan query string
		$config['query_string_segment'] = 'page'; // Nama parameter query string
		$config['use_page_numbers'] = TRUE; // Aktifkan query string

		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $offset = ($page - 1) * $config['per_page'];

        $notifikasis = $this->find()
        			->where($where)
					->limit($config['per_page'], $offset)
					->get()->result_array();

        $pagination = $this->pagination->create_links();

        return [
        	'notifikasis' => $notifikasis,
			'pagination' => $pagination,
        ];
	}

	public function getStatus()
	{
		return [
			self::STATUS_UNREAD => 'unread',
			self::STATUS_READ => 'read',
		];
	}
}

/* End of file Notifikasi.php */
/* Location: ./application/models/Notifikasi.php */