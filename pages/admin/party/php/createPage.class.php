<?php

require_once('FormPage.class.php');
require_once('Party.class.php');

class CreatePage extends FormPage {
	protected function getRecord() {
		return new Party();
	}

	protected function getFormParameters() {
		return array('name' => 'PartyCreate',
								 'header' => 'Nieuwe partij',
								 'submitText' => 'Toevoegen');
	}

	protected function getAction() {
		return 'create';
	}

	public function show($smarty) {
		$p = new Party();
		$smarty->assign('parties', $p->getDropDownPartiesAll($order = 'ORDER BY name'));
		parent::show($smarty);
	}
}

?>
