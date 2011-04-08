<?php

require_once('FormHandler.class.php');

class FormHandlerLoad extends FormHandler {
	public function processGet($get) {
		$this->loadData($this->getRecord());
	}

	protected function loadData($record) {}
}