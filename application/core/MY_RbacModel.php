<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 * 
 * @category	Libraries
 * @author		Ilham D. Sofyan
 */
class MY_RbacModel extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->initializeModels();
	}

	public function initializeModels() {
        $this->load->model([ // Load all models here
            // 'rbac/allowed',
        //     'rbac/authassignment',
        //     'rbac/authitem',
        //     'rbac/authitemchild',
        //     'rbac/group',
        //     'rbac/groupuser',
        //     'rbac/menu',
        //     'rbac/menugroup',
        //     'rbac/menutype',
        //     'rbac/permission',
        //     'rbac/routes',
        //     'rbac/user',
        ]);
    }
}
