<?php

abstract class indexPageBase {
	protected $data;
	
	protected $dataLoaded = false;
	
	protected $sortDefault = 'id';
	protected $sortDirDefault = 'asc';
	protected $sorting = array('col' => '', 'dir' => 'asc');
	protected $sortKeys;
	

	public function __construct() {
		
		
		$this->sortKeys = array(
			'id' => false,
			'id' => null,
			'description' => null,
			'category_name' => null,

		);
		
		
	}

	

	




	public function loadFromObject($where = '', $order = '', $limit = '') {
		require_once('Category.class.php');
		$loader = new Category();


		$objs = $loader->getList('', $where, $this->getOrder($order), $limit);
		$this->loadData($objs);
	}

	protected function getOrder($order = '') {
		if ($order == '') { // Use ordering based on sort columns
			if (isset($_GET['sort']) && in_array($_GET['sort'], array('asc','desc')))
				$dir = $_GET['sort'];
			else
				$dir = $this->sortDirDefault;
			if (isset($_GET['sortcol']) && array_key_exists($_GET['sortcol'], $this->sortKeys))
				$sortCol = $_GET['sortcol'];
			else
				$sortCol = $this->sortDefault;

			$order = 'ORDER BY "'.$sortCol.'" '.$dir;
			$this->sorting['col'] = $sortCol;
			$this->sorting['dir'] = $dir;
		}
		return $order;
	}

	public function loadData($objs) {
		foreach ($objs as $obj) {
			$id = $obj->id;
			$this->data[$id]['id'] = $obj->id;
			$this->data[$id]['description'] = $obj->description;
			$this->data[$id]['category_name'] = $obj->name;

		}
	}




	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('indexPage.html');
	}
}

?>