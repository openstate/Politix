<?php

require_once('indexPageBase.class.php');
require_once('Pager.class.php');
require_once('Region.class.php');

class indexPage extends indexPageBase {
	protected $sortDefault = 'level';
	protected $itemsPerPage = 20;
	protected $pager = null;
	
	protected $sortKeys = array(
			'id' => false,
			'id' => null,
			'level_name' => null,
			'parent_name' => null,
			'name' => null,
			'level' => null,
			'parent' => null,
		);

	public function processGet($get) {		
		$region = new Region();
		if (!isset($get['start']) || !ctype_digit($get['start']))
			$get['start'] = 0;
		$this->pager = new Pager($region->getCount($this->getWhere(), ''), $get['start'], $this->itemsPerPage);
		
		$this->loadData($region->getList($this->getWhere(),
			$this->getOrder(),
			'LIMIT '.$this->pager->getLimit().' OFFSET '.$this->pager->getCurrent()
		));
		
	}

	public function show($smarty) {		
		if (isset($_SESSION['error'])) {
			$smarty->assign('error', $_SESSION['error']);
			unset($_SESSION['error']);
		}

		$smarty->assign('pager', $this->pager->getHTML('', 'start', 'sortcol='.$this->sorting['col'].'&amp;sort='.$this->sorting['dir'].(isset($_GET['region']) ? '&amp;region='.(integer)$_GET['region'] : '')));
		//$this->loadFromObject();
		parent::show($smarty);
	}	
}

?>