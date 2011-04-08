<?php

class testPage {
	private $id = null;
	
	public function processGet($get) {
		$this->id = $get['id']; //get's checked in ajaxHandler
	}
	
	public function show($smarty) {
		$smarty->setBaseTemplate($_SERVER['DOCUMENT_ROOT'].'/../templates/ajax.html');
		$smarty->assign('id', $this->id);
		$smarty->display('testPage.html');
	}
	
}
?>