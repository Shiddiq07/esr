<?php
use Algolia\AlgoliaSearch\SearchClient;

/**
 * Library untuk search menu
 *
 * @author Ilham D. Sofyan
 */
class Algolia
{
	public $url;
	public $data = [];
	public $index;

	private $_client;
	private $CI;

	public function __construct($options = [])
	{
		$this->CI = get_instance();

		$this->CI->load->model([
			'rbac/menu'
		]);

		$this->index = def($options, 'index', 'default');
		$this->data = def($options, 'data');
		$this->url = def($options, 'url');

		$this->_client = SearchClient::create(ALGOLIA_CLIENT, ALGOLIA_WRITE_SECRET);
	}

	public function registerRecords()
	{
		$index = $this->_client->initIndex($this->index);

		if ($index->exists()) {
			$index->delete();
		}

		return $index->saveObjects($this->data, [ 'autoGenerateObjectIDIfNotExist' => true ])->wait();
	}

	public function search($term)
	{
		$index = $this->_client->initIndex($this->index);

		return $index->search($term);
	}

}
