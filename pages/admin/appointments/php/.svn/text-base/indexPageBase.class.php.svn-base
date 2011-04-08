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
			'id' => null,
			'party_name' => null,
			'region_name' => null,
			'cat_name' => null,
			'time_start' => null,
			'time_end' => null,
			'description' => null,
		);
	}

	public function loadFromObject($politician, $order='', $limit='') {
		require_once('Appointment.class.php');
		$loader = new Appointment();

		if ($this->includeExpired)
			$objs = $loader->loadByPolitician($politician, $this->getOrder($order), $limit);
		else
			$objs = $loader->loadActiveByPolitician($politician, $this->getOrder($order), $limit);
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
			$this->data[$id]['party_name'] = $obj->party_name;
			$this->data[$id]['region_name'] = Region::formatRegionName($obj->region_name, $obj->level, $obj->level_name);
			$this->data[$id]['cat_name'] = $obj->cat_name;
			$this->data[$id]['time_start'] = $obj->time_start;
			$this->data[$id]['time_end'] = $obj->time_end;
			$this->data[$id]['description'] = $obj->description;
			$this->data[$id]['showOptions'] = Dispatcher::inst()->user->isSuperAdmin() || @$_SESSION['role']->getRecord()->id == $obj->region;
		}
	}

	public function show($smarty) {
		$smarty->assign('formdata', $this->data);
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('indexPage.html');
	}
}

?>