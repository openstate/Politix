<?php
abstract class PartyPageBase {
	protected $data;
	
	protected $dataLoaded = false;
	
	protected $sortDefault = 'name';
	protected $sortDirDefault = 'asc';
	protected $sorting = array('col' => '', 'dir' => 'asc');
	protected $sortKeys;

	protected $includeExpired = false;
	
	public function __construct() {
		$this->sortKeys = array(
			'id' => array('id'),
			'name' => array('name_sortkey', 'last_name', 'first_name'),
			'cat_name' => array('cat_name'),
			'time_start' => array('time_start'),
			'time_end' => array('time_end'),
			'description' => array('description')
		);
	}

	public function loadFromObject($localparty, $order = '', $limit = '') {
		require_once('Politician.class.php');
		$loader = new Politician();

		$objs = $loader->loadByParty($localparty, $this->includeExpired, $this->getOrder($order), $limit);
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
			$order = 'ORDER BY '.implode(' '.$dir.', ', $this->sortKeys[$sortCol]).' '.$dir;
			$this->sorting['col'] = $sortCol;
			$this->sorting['dir'] = $dir;
		}
		return $order;
	}

	public function loadData($objs) {
		foreach ($objs as $obj) {
			$id = $obj['pid'];
			$this->data[$id]['id'] = $obj['pid'];
			$this->data[$id]['pid'] = $obj['id'];
			$this->data[$id]['name'] = $obj['first_name'].' '.$obj['last_name'];
			$this->data[$id]['cat_name'] = $obj['cat_name'];
			$this->data[$id]['time_start'] = $obj['time_start'];
			$this->data[$id]['time_end'] = $obj['time_end'];
			$this->data[$id]['description'] = $obj['description'];
		}
	}

	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('partyPage.html');
	}
}

?>