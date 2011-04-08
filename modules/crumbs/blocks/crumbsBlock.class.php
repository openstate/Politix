<?php

class CrumbsBlock {
	private $handler;

	public function __construct($handler) {
		$this->handler = $handler;
	}

	public function display($smarty) {
		// Check if the current url handler has the crumbs extension

		if (is_callable(array($this->handler, 'getCrumbs')))
			$crumbs = $this->handler->getCrumbs();
		else
			$crumbs = array();

		$smarty->assign('crumbs', $crumbs);

		$smarty->displayBlock('crumbs.html');
	}
}

?>