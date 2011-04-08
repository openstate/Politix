<?php

require_once('Record.class.php');

abstract class FormHandler {
	protected $data = array();
	protected $errors = array();

	public function processPost($post) {
		$this->assign($post);
		if (!$this->validate()) return;

		try {
			$this->save($this->getRecord());
		} catch (Exception $e) {
			$this->error($e);
			return;
		}
		
		$this->action();
	}

	protected function assign($post) {}
	
	protected function validate() {
		return !array_reduce($this->errors, '_or', false);
	}

	protected function save(Record $r) {}

	public function show($smarty) {
		$smarty->assign('formdata', $this->data);
		$smarty->assign('formerrors', $this->errors);
		$smarty->assign('form', $this->getFormParameters());
	}

	protected function action() {}
	protected function error($e) {}
	protected function getRecord() { return null; }
	protected function getFormParameters() { return array(); }
}

?>
