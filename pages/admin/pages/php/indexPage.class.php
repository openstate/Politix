<?php

require_once('IndexHandler.class.php');
require_once('Page.class.php');
require_once('Pager.class.php');

class IndexPage extends IndexHandler {
	private $default;
	private $region;

	public function __construct() {
		$this->sortKeys = array('id', 'url', 'title');
		$this->sortDefault = 'url';
	}

	public function processGet($get) {
		$p = new Page();

		$this->region = (int)$_SESSION['role']->getRecord()->id;
		$this->data = $p->getVisiblePages($this->region);
		$this->default = $p->getDefaultPages($this->region);
	}

	public function show($smarty) {
		$smarty->assign('region', $this->region);
		$smarty->assign('default', $this->default);
		parent::show($smarty);
	}
}

?>
