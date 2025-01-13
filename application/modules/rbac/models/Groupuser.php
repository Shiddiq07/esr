<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groupuser extends MY_Model
{
	public $tableName = 'sys_group_user';
	public $soft_delete = false;

	public function getGroupUser($id)
	{
		$user_group = $this->getAll(['user_id' => $id]);

		$groups = [];
		if ($user_group) {
			foreach ($user_group as $key => $value) {
				$groups[] = $value->group_id;
			}
		}

		return $groups;
	}

}
