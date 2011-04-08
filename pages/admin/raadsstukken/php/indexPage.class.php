<?php

require_once('IndexHandler.class.php');
require_once('Raadsstuk.class.php');
require_once('Pager.class.php');

class IndexPage extends IndexHandler {
	private $itemsPerPage = 20;
	private $pager;

	public function __construct() {
		$this->sortKeys = array('id', 'title', 'site', 'code', 'vote_date', 'category_name', 'type_name',);
		$this->sortDefault = 'vote_date';
		$this->sortDirDefault = 'desc';
	}

	public function processGet($get) {
		$rs = new Raadsstuk();

		$region = $_SESSION['role']->getRecord()->id;
		$this->pager = new Pager($rs->getCountByRegion($region), (int)@$_GET['start'], $this->itemsPerPage);
		$this->data = $rs->getListByRegion($region, $this->getOrder(), 'LIMIT '.$this->pager->getLimit().' OFFSET '.$this->pager->getCurrent());
	}

	public function show($smarty) {
		$smarty->assign('pager', $this->pager->getHTML('', 'start', 'sortcol='.$this->sorting['col'].'&amp;sort='.$this->sorting['dir']));
		parent::show($smarty);
	}
}

?>
