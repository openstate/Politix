<?php

require_once('SuspiciousWord.class.php');

abstract class indexPageBase {
	protected $data;

	protected $dataLoaded = false;

	protected $sortDefault = 'id';
	protected $sortDirDefault = 'asc';
	protected $sorting = array('col' => '', 'dir' => 'asc');
	protected $sortKeys;
	
	public function __construct() {
		$this->sortKeys = array(
			'id' => null,
			'word' => null
		);	
	}

	public function loadFromObject($where = '', $order = '', $limit = '') {
		$loader = new SuspiciousWord();

		$objs = $loader->getList('', $where, $this->getOrder($order), $limit);
		$this->loadData($objs);
	}

	protected function getOrder($order = '') {
		return "ORDER BY word ASC";
	}

	public function loadData($objs) {
		foreach ($objs as $obj) {
			$id = $obj->id;
			$this->data[$id]['id'] = $obj->id;
			$this->data[$id]['word'] = $obj->word;
		}
	}

	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('indexPage.html');
	}
}

?>