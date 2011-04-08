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
			'level_name' => null,
			'parent_name' => null,
			'region_name' => null,
			'level' => null,
			'parent' => null,

		);
		
		
	}

	

	




	public function loadFromObject($where = '', $order = '', $limit = '') {
		require_once('Region.class.php');
		$loader = new Region();


		$objs = $loader->getList('', $this->getWhere($where), $this->getOrder($order), $limit);
		$this->loadData($objs);
	}

	protected function getWhere($where = '') {
		if (!isset($_GET['region']) || $_GET['region'] == -1) return $where;
		if ($where == '') $where = 'WHERE '; else $where .= ' AND ';
		$region = $_GET['region'];
		if ($region == 'false')
			$where .= 't.level < 3';
		else
			$where .= 't.parent = '.(integer)$region;
		return $where;
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
			$this->data[$id]['level_name'] = $obj->level_name;
			$this->data[$id]['parent_name'] = $obj->parent_name;
			$this->data[$id]['region_name'] = $obj->name;
			$this->data[$id]['level'] = $obj->level;
			$this->data[$id]['parent'] = $obj->parent;

		}
	}

	protected function loadRegions() {
		$region = new Region();
		return $region->getList(
			'JOIN sys_regions reg ON reg.parent = t.id',
			'WHERE t.level > 2',
			'ORDER BY t.level ASC, p.name ASC, t.name ASC');
	}



	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		$smarty->assign('regions',    $this->loadRegions());
		if (isset($_GET['region']))
			$smarty->assign('selectedRegion', $_GET['region']);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('indexPage.html');
	}
}

?>