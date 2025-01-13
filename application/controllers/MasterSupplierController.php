<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterSupplierController extends CI_Controller
{
    public function actionIndex()
    {
        $this->layout->render('index');
    }
}