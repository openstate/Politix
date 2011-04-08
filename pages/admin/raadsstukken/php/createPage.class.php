<?php

require_once('FormPage.class.php');
require_once('Raadsstuk.class.php');

class CreatePage extends FormPage {
	protected $toVotes;
	protected $id;

	protected $rs = null;

	public function processGet($get) {
		$this->data['type'] = 1;
		$this->data['submit_type'] = 18; //Onbekend //[FIXME: direct id is used!]
		parent::processGet($get);
	}

	protected function getRecord() {
		if (!$this->rs) {
			$this->rs = new Raadsstuk();
			$this->rs->show = 1;
		}
		return $this->rs;
	}

	protected function getFormParameters() {
		return array('name' => 'RaadsstukCreate',
								 'header' => 'Nieuw voorstel',
								 'submitText' => 'Toevoegen',
								 'extraButton' => 'Toevoegen en naar stemming');
	}

	protected function getAction() {
		return 'create';
	}

	protected function save(Record $r) {
		$r->result = Raadsstuk::NOTVOTED;
		parent::save($r);
	}

	public function show($smarty) {
		$smarty->assign('cats', '[]');
		$smarty->assign('catNames', '[]');
		$smarty->assign('tags', '[]');
		parent::show($smarty);
	}
}

?>
