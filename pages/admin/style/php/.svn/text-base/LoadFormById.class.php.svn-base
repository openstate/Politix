<?php

require_once('FormPage.class.php');
require_once('Style.class.php');

abstract class LoadFormById extends FormPage {
	protected $s;

	public function processGet($get) {
		if (!isset($_SESSION['role'])) Dispatcher::forbidden();
		try {
			$this->s = new Style($_SESSION['role']->getRecord()->id);
		} catch (Exception $e) {
			$this->s = Style::getDefault();
		}
		$this->loadData($this->s);
	}

	private function loadData($record) {
		$this->data['id'] = $record->id;
		$this->data['color1'] = $record->color1;
		$this->data['color2'] = $record->color2;
		$this->data['color3'] = $record->color3;
		$this->data['color4'] = $record->color4;
		$this->data['color5'] = $record->color5;
		$this->data['color6'] = $record->color6;
		$this->data['color7'] = $record->color7;
		$this->data['color8'] = $record->color8;
		$this->data['slogan'] = $record->slogan;
		$this->data['font_family'] = $record->font_family;
		$this->data['font_color'] = $record->font_color;
		$this->data['font_size'] = $record->font_size;
		$this->data['bg_color'] = $record->bg_color;
		$this->data['logo'] = $record->logo;
		$this->data['fields'] = $record->fields;
	}

	protected function getRecord() {
		return $this->s;
	}
}

?>
