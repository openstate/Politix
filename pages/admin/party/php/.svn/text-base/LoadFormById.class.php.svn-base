<?php

require_once('FormPage.class.php');
require_once('Party.class.php');
require_once('PartyParent.class.php');

abstract class LoadFormById extends FormPage {
	protected $party;

	public function processGet($get) {
		try {
			$this->party = new Party(@$get['id']);
			if (!Dispatcher::inst()->user->canEditParty($this->party)) throw new Exception();
			$this->loadData($this->party);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
	}

	private function loadData($record) {
		$this->data['title'] = $record->name;
		$this->data['combination'] = $record->combination;
		$this->data['owner'] = $record->owner;

		$p = new PartyParent();
		$this->data['parents'] = $p->getParentsByParty($record->id);
	}

	protected function getRecord() {
		return $this->party;
	}

	public function show($smarty) {
		$p = new Party();
		$smarty->assign('parties', $p->getDropDownPartiesAll('WHERE t.id <> '.$this->getRecord()->id, 'ORDER BY name'));
		parent::show($smarty);
	}
}

?>
