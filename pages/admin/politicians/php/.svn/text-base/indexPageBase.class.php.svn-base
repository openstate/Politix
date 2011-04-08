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
			'first_name' => null,
			'last_name' => null,
			'email' => null,

		);


	}








	public function loadFromObject($where = '', $order = '', $limit = '') {
		require_once('Politician.class.php');
		$loader = new Politician();


		$objs = $loader->getList('', $this->getWhere($where), $this->getOrder($order), $limit);
		$this->loadData($objs);
	}

	protected function getWhere($where = '') {
		if (!isset($_GET['q']) || !$_GET['q']) return $where;
		if ($where == '') $where = 'WHERE '; else $where .= ' AND ';
		$query = str_replace(array('\\', '%', '_'), array('\\\\', '\%', '\_'), $_GET['q']);
		$where .= '('.implode(' OR ', array_map(create_function('$s', '
				$db = DBs::inst(DBs::SYSTEM);
				return strlen($s) ? $db->formatQuery("(t.first_name ILIKE %1 OR t.last_name ILIKE %1)", $s."%") : \'TRUE\';
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

	public function loadData($objs, $apps = null) {
		foreach ($objs as $obj) {
			$id = $obj->id;
			$this->data[$id]['id'] = $obj->id;
			$this->data[$id]['title'] = $obj->title;
			$this->data[$id]['first_name'] = $obj->first_name;
			$this->data[$id]['last_name'] = $obj->last_name;
			$this->data[$id]['gender_is_male'] = $obj->gender_is_male;
			$this->data[$id]['email'] = $obj->email;
			$this->data[$id]['extern_id'] = $obj->extern_id;
			$this->data[$id]['canDelete'] = Dispatcher::inst()->user->isSuperAdmin() || $obj->region_created == @$_SESSION['role']->getRecord()->id && !isset($apps[$id]);
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