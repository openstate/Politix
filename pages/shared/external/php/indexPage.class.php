<?php

class IndexPage {
	protected $href;
	protected $from;

	public function processGet($get) {
		if (!isset($get['href']))
			Dispatcher::badRequest();

		$this->href = $get['href'];
	}

	public function show($smarty) {
		$smarty->setBaseTemplate($_SERVER['DOCUMENT_ROOT'].'/../templates/popup.html');
		$smarty->assign('href', $this->href);
		$smarty->display('index.html');
	}
}

?>
