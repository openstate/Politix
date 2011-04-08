<?php

require_once('indexPageBase.class.php');
require_once('Pager.class.php');
require_once('BackofficeUser.class.php');

class indexPage extends indexPageBase {
	protected $sortDefault = 'id';
	protected $itemsPerPage = 20;
	protected $pager = null;


	public function processGet($get) {		
		$boUser = new BackofficeUser(true);
		if (!isset($get['start']) || !ctype_digit($get['start']))
			$get['start'] = 0;
		$this->pager = new Pager($boUser->getCount($this->getWhere(), ''), $get['start'], $this->itemsPerPage);
		
		$this->loadData($boUser->getList($this->getWhere(),
			$this->getOrder(),
			'LIMIT '.$this->pager->getLimit().' OFFSET '.$this->pager->getCurrent()
		));
		
	}



	public function show($smarty) {
		$smarty->assign('pager', $this->pager->getHTML('', 'start', 'sortcol='.$this->sorting['col'].'&amp;sort='.$this->sorting['dir'].(isset($_GET['q']) ? '&amp;q='.urlencode($_GET['q']) : '')));
		//$this->loadFromObject();
		parent::show($smarty);
	}




}

?>