<?php
abstract class RegionPageBase {
	protected $data;
	
	protected $dataLoaded = false;
	
	protected $sortDefault = 'id';
	protected $sortDirDefault = 'asc';
	protected $sorting = array('col' => '', 'dir' => 'asc');
	protected $sortKeys;
	
	protected $includeExpired = false;
	
	public function __construct() {
		$this->sortKeys = array(
			'id' => null,
			'party_name' => null,
		);
	}

	public function loadFromObject($where = '', $order = '', $limit = '') {
		require_once('LocalParty.class.php');
		$loader = new LocalParty();

		$objs = $loader->getList('', 'WHERE '.(!$this->includeExpired ? 'now() < time_end AND ' : '').'region = ' . $_SESSION['role']->getRecord()->id, $this->getOrder($order), $limit);
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
		}
	}

	public function show($smarty) {
		$smarty->assign('formdata',   $this->data);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('regionPage.html');
	}
}

?>