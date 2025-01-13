<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Multimodel extends CI_Model
{
	protected $src = 'college';
	protected $dir_src = 'colleges';

	private $allowed = [
		'college',
		'plj'
	];

	private $dirs = [
		'college' => 'colleges',
		'plj' => 'polteks'
	];

	public function setSource($src)
	{
		$this->src = $src;

		if (!in_array($this->src, $this->allowed)) {
			$this->src = $this->allowed[0];
		}

		$this->dir_src = $this->dirs[$this->src];
	}
}

/* End of file Multimodel.php */
/* Location: ./application/models/Multimodel.php */