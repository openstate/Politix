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
			'username' => null,
			'firstname' => null,
			'lastname' => null,
		);
	}

	public function loadFromObject($where = '', $order = '', $limit = '') {
		require_once('BackofficeUser.class.php');
		$loader = new BackofficeUser();


		$objs = $loader->getList('', $this->getWhere($where), $this->getOrder($order), $limit);
		$this->loadData($objs);
	}

	protected function getWhere($where = '') {
		if (!isset($_GET['q'])) return $where;
		if ($where == '') $where = 'WHERE '; else $where .= ' AND ';
		$query = str_replace(array('\\', '%', '_'), array('\\\\', '\%', '\_'), $_GET['q']);
		$where .= '('.implode(' OR ', array_map(create_function('$s', '
				$db = DBs::inst(DBs::SYSTEM); 
				return strlen($s) ? $db->formatQuery(\'(t.firstname ILIKE %1 OR t.lastname ILIKE %1)\', \'%\'.$s.\'%\') : \'TRUE\';
			'), explode(' ', $query))).')';
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
			$this->data[$id]['username'] = $obj->username;
			$this->data[$id]['firstname'] = $obj->firstname;
			$this->data[$id]['lastname'] = $obj->lastname;
		}
	}

	public function show($smarty) {
		if (isset($_GET['q'])) $smarty->assign('query', $_GET['q']);
		$smarty->assign('formdata',   $this->data);
		
		$smarty->assign('formsort', $this->sorting);
		$smarty->display('indexPage.html');
	}
}

?>