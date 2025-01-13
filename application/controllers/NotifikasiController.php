<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotifikasiController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model([
			'notifikasi'
		]);
	}

	public function actionIndex()
	{
		$statuses = $this->notifikasi->getStatus();
		$status = array_search($this->input->get('referrer'), $statuses);

		$this->layout->title = 'Notifikasi';
		$this->layout->view_js = '_index_js';
		$this->layout->render('index', [
			'statuses' => $statuses,
			'status' => $status,
		]);
	}

	public function actionFetchData()
	{
		$page = $this->input->get('page');
		$status = $this->input->get('status');

		$model = $this->notifikasi->getFetchedNotification(
			def($this->session->userdata('identity'), 'id'), 
			$status, 
			$page
		);

        $view = $this->layout->renderPartial('_list_notifikasi', [
        	'notifikasis' => $model['notifikasis'],
			'pagination' => $model['pagination'],
        ], true);

		return $this->output
	        ->set_content_type('application/json')
	        ->set_status_header(200) // Return status
	        ->set_output(json_encode([
	        	'pagination' => $view,
	        ]));
	}
}