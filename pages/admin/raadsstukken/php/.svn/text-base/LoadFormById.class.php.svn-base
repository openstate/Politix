<?php

require_once('FormPage.class.php');
require_once('Raadsstuk.class.php');
require_once('Submitter.class.php');
require_once('RaadsstukTag.class.php');
require_once('RaadsstukCategory.class.php');
require_once('Category.class.php');

abstract class LoadFormById extends FormPage {
	protected $rs;

	public function processGet($get) {
		try {
			$this->rs = new Raadsstuk($get['id']);

			$ids = $_SESSION['user']->listSiteIds();
			if(!isset($ids[$this->rs->site_id])) Dispatcher::forbidden();

			if ($this->rs->region != $_SESSION['role']->getRecord()->id)
				Dispatcher::forbidden();
			$this->loadData($this->rs);
		} catch (Exception $e) {
			Dispatcher::forbidden();
		}
		$date = strtotime($this->getRecord()->vote_date);
		$this->council = Council::getCouncilByDate($_SESSION['role']->getRecord()->id, $date);
		$rs = new Raadsstuk();
		$this->parents = array(0 => "\xC2\xA0") + array_map(array($this, 'formatParent'), $rs->getList('', 'WHERE region = '.$_SESSION['role']->getRecord()->id.' AND t.id != '.$this->getRecord()->id.' AND t.parent IS NULL'.(!$this->data['unrestrict_parent'] ? ' AND \''.($date ? strftime('%Y-%m-%d', $date) : 'now').'\' BETWEEN vote_date - \'2 weeks\'::interval AND vote_date + \'2 weeks\'::interval' : '')));
	}

	private function loadData($record) {
		$this->data['id'] = $record->id;
		$this->data['title'] = $record->title;
		$this->data['vote_date'] = $record->vote_date;
		$this->data['summary'] = $record->summary;
		$this->data['code'] = $record->code;
		$this->data['type'] = $record->type;
		$this->data['type_name'] = $record->type_name;
		$this->data['submit_type'] = $record->submitter;
		$this->data['submit_type_name'] = $record->submit_type_name;
		$this->data['parent'] = $record->parent;
		$this->data['show'] = $record->show;
		$this->data['site_id'] = $record->site_id;

		if($record->submit_type_name == 'Partij') {
			$s = new SubmitterParty();
			$this->data['submitters'] = $s->getSubmitterPartyByRaadsstuk($record->id);
		} else { //politicians
			$s = new Submitter();
			$this->data['submitters'] = $s->getSubmittersByRaadsstuk($record->id);
		}

		$t = new RaadsstukTag();
		$this->data['tags'] = array_values($t->getTagsByRaadsstuk($record->id));

		$c = new RaadsstukCategory();
		$this->data['cats'] = $c->getCategoriesByRaadsstuk($record->id);
	}

	protected function getRecord() {
		return $this->rs;
	}
}

?>
