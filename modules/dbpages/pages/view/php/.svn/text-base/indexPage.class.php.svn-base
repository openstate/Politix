<?php

require_once('Page.class.php');

class indexPage {
	public function processGet($get) {
		if (!isset($get['id']))
			Dispatcher::header('/');

		$p = new Page();
		$this->page = $p->loadByUrl($get['id'], @Dispatcher::inst()->region);
	}

	public function show($smarty) {
		$smarty->assign('page', $this->page);
		$smarty->display('indexPage.html');
	}
}

?>