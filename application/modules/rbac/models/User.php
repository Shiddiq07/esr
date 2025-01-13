<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Model {

	public $tableName = 'sys_user';
	// public $datatable_columns = [
    //     'tbl_user.id', 'username', 'email', 'status', 'tbl_user.created_at', 
    //     'tbl_user_detail.nama_depan', 'tbl_user_detail.nama_tengah', 'tbl_user_detail.nama_belakang'
    // ];
	// public $datatable_search = ['username', 'email', 'status', 'tbl_user_detail.nama_depan', 'tbl_user_detail.nama_tengah', 'tbl_user_detail.nama_belakang'];
    public $blameable = true;
    public $timestamps = true;

    const AKUN_AKTIF = 1; // status user/akun
    const AKUN_TIDAK_AKTIF = 0; // status user/akun

    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'rbac/groupuser',
            'rbac/group',
            // 'master/unit',
            // 'userdetail',
            // 'transaksi/plafon',
            // 'transaksi/userkeluarga',
        ]);
    }

    public function findByUsername($username)
    {
        return $this->get(['username' => $username]);
    }

    public function getUserGroups($user_id)
    {
        return $this->groupuser->getAll(['user_id' => $user_id]);
    }

    public function getUserGroup()
    {
        return $this->hasMany('groupuser', 'user_id', 'id');
    }

    public function userDetail()
    {
        return $this->hasOne('userdetail', 'user_id', 'id');
    }

    public function isHasGroup($group)
    {
        return !empty($this->getUserGroup()
            ->join('tbl_group g', 'g.id = tbl_group_user.group_id')
            ->where(['g.group_code' => $group])
            ->get()->row());
    }

    public function blameableBehavior()
    {
        return [
            'createdByAttribute' => 'created_by',
            'updatedByAttribute' => 'updated_by',
            'value' => $this->session->userdata('identity')['id']
        ];
    }
}
