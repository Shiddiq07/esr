<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PurchaseReceiptController extends CI_Controller
{
    public function actionIndex()
    {
        $this->layout->render('index');
    }
    public function actionDetail()
    {
        $this->layout->render('detail');
    }
}