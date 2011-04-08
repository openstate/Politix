<?php

require_once('FormPage.class.php');
require_once('Politician.class.php');

abstract class LoadFormById extends FormPage {
	protected $p;

	public function processGet($get) {
		try {
			$this->p = new Politician($get['id']);
			$this->loadData($this->p);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
	}

	private function loadData($record) {
		$this->data['title'] = $record->title;
		$this->data['first_name'] = $record->first_name;
		$this->data['last_name'] = $record->last_name;
		$this->data['gender'] = $record->gender_is_male;
		$this->data['email'] = $record->email;
		$this->data['extern_id'] = $record->extern_id;
	}

	protected function getRecord() {
		return $this->p;
	}
}

?>
