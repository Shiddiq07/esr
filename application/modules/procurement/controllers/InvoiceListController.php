<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InvoiceListController extends CI_Controller
{
    public function actionIndex()
    {
        $this->layout->render('index');
    }
    // public function actionAddData()
    // {
    //     $this->layout->render('tambahData');
    //     // $data=[
    //     //     'nama'=>'Supplier Baru'
    //     // ];
    //     // $this->layout->render('form-test',$data);
    // }
    public function actionDetail()
    {
        $this->layout->render('detail');
    }
}