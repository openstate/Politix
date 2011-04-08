<?php

require_once('indexPageBase.class.php');
require_once('Pager.class.php');
require_once('Politician.class.php');

class indexPage extends indexPageBase {
	protected $sortDefault = 'name_sortkey';
	protected $itemsPerPage = 20;
	protected $pager = null;

	public function processGet($get) {
		$politician = new Politician();
		if (!isset($get['start']) || !ctype_digit($get['start']))
			$get['start'] = 0;
		$join = $where = '';
		if (!Dispatcher::inst()->user->isSuperAdmin()) {
			$join = 'LEFT JOIN pol_politician_functions pf ON t.id = pf.politician';
			$where = 'WHERE (region = '.$_SESSION['role']->getRecord()->id.' OR region_created = '.$_SESSION['role']->getRecord()->id.')';
		}
		$this->pager = new Pager($politician->getCount($join, $this->getWhere($where)), $get['start'], $this->itemsPerPage);

		$objs = $politician->getList($join, $this->getWhere($where),$this->getOrder(),'LIMIT '.$this->pager->getLimit().' OFFSET '.$this->pager->getCurrent());
		$apps = array();

		if (count($objs))
			foreach (DBs::inst(DBs::SYSTEM)->query('SELECT politician, count(*) FROM pol_politician_functions WHERE politician IN ('.implode(',', array_keys($objs)).') GROUP BY politician')->fetchAllRows() as $row) {
				$apps[$row['politician']] = $row['count'];
			}

		$this->loadData($objs, $apps);
	}


	public function show($smarty) {
		if (isset($_SESSION['error'])) {
			$smarty->assign('error', $_SESSION['error']);
			unset($_SESSION['error']);
		}

		$smarty->assign('politician_base_url', POLITICIAN_BASE_URL);
		$smarty->assign('pager', $this->pager->getHTML('', 'start', 'sortcol='.$this->sorting['col'].'&amp;sort='.$this->sorting['dir'].(isset($_GET['q']) ? '&amp;q='.urlencode($_GET['q']) : '')));
		//$this->loadFromObject();
		parent::show($smarty);
	}




}

?>