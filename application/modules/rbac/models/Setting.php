<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Model
{
	public $tableName = "sys_setting";
	public $soft_delete = false;

	public static function getSetting($name)
	{
		$model = new self;

		return $model->findOne(['name' => $name]);
	}

	public static function getSettingValue($name)
	{
		$model = self::getSetting($name);

		return def($model, 'value');
	}

	public function addSetting($name, $value, $desc = null)
	{
		$model = new Setting;
		$model->name = $name;
		$model->value = $value;
		$model->desc = $desc;

		return $model->save();
	}

}

/* End of file Setting.php */
/* Location: ./application/models/Setting.php */
