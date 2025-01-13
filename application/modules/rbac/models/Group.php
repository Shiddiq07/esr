<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_BaseModel {

	public $tableName = 'sys_group';
	public $datatable_columns = ['label', 'desc', 'id'];
	public $datatable_search = ['label', 'desc'];
	public $soft_delete = false;

	const ADMIN = 'administrator';
	const USER = 'user';
	const ADMIN_DIR = 'admin-direktorat';
	const ADMIN_CABANG = 'admin-cabang';
	const MANAJEMEN_HO = 'manajemen-ho';
	const MANAJEMEN_DIR = 'manajemen-direktorat';
	const MANAJEMEN_CABANG = 'manajemen-cabang';
	const KEUANGAN = 'keuangan';
	const COLLEGE = 'college';
	const POLTEK = 'poltek';
	const LOKAL = 'lokal';

	public function __construct()
	{
		parent::__construct();
		// $this->load->model([
		// 	'rbac/authassignment'
		// ]);

		$this->load->library('curly');
	}

	public function rules()
	{
		return [
			[
				'field' => 'label',
				'rules' => 'required',
				'errors' => [
	                'required' => 'Nama Group wajib diisi',
	            ],
			],
		];
	}

	public function getListGroup($parent = [], $excepts = [])
	{
		$groups = $this->curly->get(API_URL .'/group/get-all?parent='. json_encode($parent) .'&except='. json_encode($excepts), [
			'Authorization: Bearer ' . $this->session->userdata('token'),
		]);

		$data_groups = [];

		if ($groups) {
			$data_groups = $groups['data'];
		}

		$groups = [];
		foreach ($data_groups as $key => $value) {
			$child_of = json_decode($value['parent_id'], true);

			if (empty($child_of)) {
				$child_of = [];
			}

			if (!empty($parent) && !empty(array_intersect($parent, $child_of))) {
				$groups[] = $value;
			} elseif(empty($parent)) {
				$groups[] = $value;
			}
		}

		return $groups;
	}

	public function getGroups($parent = '')
	{
		$list_group = $this->getListGroup($parent);

		$groups = [];
		foreach ($list_group as $key => $value) {
			$groups[] = $value->id;
		}

		return array_unique($groups);
	}

	public function assignedPermissions($id = null)
	{
		// return $this->hasMany('authassignment', 'group_id', 'id');
		return $this->authassignment->findAll(['group_id' => $id]);
	}

	public function addAssignment($group, $permissions)
    {
        if (!empty($permissions) && is_array($permissions)) {
            try {
                $this->db->trans_begin();

                foreach ($permissions as $permission) {
                    $this->_add($group, $permission);
                }

                $this->db->trans_commit();

            } catch (Exception $exc) {
                $this->db->trans_rollback();
                return false;
            }

            return true;
        }
    }

    public function removeAssignment($group, $permissions)
    {
    	if (!empty($permissions) && is_array($permissions)) {
            try {
            	$this->db->trans_begin();

	            foreach ($permissions as $permission) {
                	$this->_remove($group, $permission);
	            }

	            $this->db->trans_commit();

            } catch (Exception $exc) {
                $this->db->trans_rollback();
            	return false;
            }
        }
    }

    private function _add($group, $permission)
    {
    	$model_permission = $this->permission->findOne(['name' => $permission]);

        if (!empty($permission) && !empty($model_permission)) {
            $model = new Authassignment;
            $model->auth_item_id = $model_permission->id;
            $model->group_id = $group['id'];
            return $model->save();
        }

        return false;
    }

    private function _remove($group, $permission)
    {
        $model_permission = $this->permission->findOne(['name' => $permission]);

        if (!empty($permission) && !empty($model_permission)) {
            return $this->authassignment->delete([
            	'auth_item_id' => $model_permission->id, 
            	'group_id' => $group['id']
            ]);
        }
        return false;
    }

    public function getDropdownParent($excepts = null, $labeled = false)
    {
    	$groups = $this->getListGroup('', $excepts);

    	if ($labeled === true) {
            $dropdown_parent = ['' => '- Pilih Parent -'];
        } else {
            $dropdown_parent = [];
        }

    	foreach ($groups as $key => $group) {
    		$dropdown_parent[$group['id']] = $group['group_code'];
    	}

    	return $dropdown_parent;
    }

    public function getDatatables($filter)
    {
    	return $this->curly->post(API_URL .'/group/get-datatable', $filter, [
			'Authorization: Bearer ' . $this->session->userdata('token'),
		]);
    }

    public function getById($id)
    {
    	$group = $this->curly->get(API_URL .'/group/get/'. $id, [
			'Authorization: Bearer ' . $this->session->userdata('token'),
		]);

		return empty($group['data']) ? [] : $group['data'];
    }

    public function isHasGroup($ids, $code)
    {
    	if (is_array($ids)) {
    		foreach ($ids as $key => $id) {
    			$group = $this->getById($id);

    			if ($group && $group['group_code'] === $code) {
    				return true;
    			}
    		}

    	} elseif (is_numeric($ids)) {
    		$group = $this->getById($ids);

			if ($group && $group['group_code'] === $code) {
				return true;
			}
    	}

    	return false;
    }

}
