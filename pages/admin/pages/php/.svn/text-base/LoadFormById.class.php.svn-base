<?php

require_once('FormPage.class.php');
require_once('Page.class.php');

abstract class LoadFormById extends FormPage {
	public function processGet($get) {
		if (!isset($_SESSION['role'])) Dispatcher::forbidden();
		try {
			$this->page = new Page($get['id']);
			$this->loadData($this->page);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
	}

	protected function loadData($record) {
		$this->data['showInMenu'] = $record->showInMenu;
		parent::loadData($record);
	}
}

?>
