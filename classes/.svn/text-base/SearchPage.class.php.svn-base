<?php

require_once('Region.class.php');
require_once('Party.class.php');
require_once('Politician.class.php');
require_once('Category.class.php');
require_once('RaadsstukType.class.php');
require_once('SearchEngine.class.php');

class SearchPage {
	protected $data = false;
	protected $params = array();

	protected $fields = array('region', 'code', 'title', 'summary', 'category', 'type', 'vote_date', 'tags', 'party', 'politician_id');
	protected $shortFields = array('r', 'c', 't', 's', 'a', 'y', 'd', 'g', 'p', 'u');

	protected $defaultFields = array('region', 'title', 'summary', 'category', 'type', 'vote_date', 'tags', 'party', 'politician_id');

	public function processGet($get) {
		foreach ($get as $key => $value) {
			if (preg_match('/^show_([a-z]+)$/', $key, $match)) {
				if (in_array($match[1], $this->fields) && $value) {
					$this->data[$key] = true;
				}
			}
			if (in_array($key, $this->fields)) {
				$this->params[$key] = $value;
			}
		}

		$db = DBs::inst(DBs::SYSTEM);

		if (!@$get['magic'] && count($this->params) == 1 && array_key_exists('party', $this->params)) {
			Dispatcher::header('/partij/'.$db->query('SELECT slug(coalesce(short_form, name)) FROM pol_parties WHERE id = %', $this->params['party'])->fetchCell());
			die;
		} else if (!@$get['magic'] && count($this->params) == 2 && array_key_exists('party', $this->params) && array_key_exists('region', $this->params)) {
			Dispatcher::header('/partij/'.$db->query('SELECT slug(coalesce(short_form, name)) FROM pol_parties p JOIN pol_party_regions pr ON pr.party = p.id WHERE p.id = % AND pr.region = %', $this->params['party'], $this->params['region'])->fetchCell());
			die;
		}

		$style = Dispatcher::inst()->style;
		if (isset($get['fields']) || strlen($style->fields)) {
			$fs = isset($get['fields']) ? $get['fields'] : $style->fields;
			$inverse = substr($fs, 0, 1) == '!';
			$this->setAllFields($inverse);
			$z = array_combine($this->shortFields, $this->fields);
			for ($i = $inverse ? 1 : 0; $i < strlen($fs); $i++) {
				$c = substr($fs, $i, 1);
				if (in_array($c, $this->shortFields))
					$this->data['show_'.$z[$c]] = !$inverse;
			}
		}

		if (false === $this->data)
			$this->setDefaultFields();

	}

	protected function setAllFields($value) {
		foreach ($this->fields as $f) {
			$this->data['show_'.$f] = $value;
		}
	}

	protected function setDefaultFields() {
		foreach ($this->fields as $f) {
			$this->data['show_'.$f] = false;
		}
		foreach ($this->defaultFields as $f) {
			$this->data['show_'.$f] = true;
		}
	}

	public function show($smarty) {
		$rt = new RaadsstukType();
		$c = new Category();
		$rg = new Region();
		$p = new Page();

		$q = Query::fromString(http_build_query($_GET));
		$smarty->assign('query', $q);

		$smarty->assign('form', $this->data);
		$smarty->assign('params', $this->params);
		$smarty->assign('page', $p->loadByUrl('search', Dispatcher::inst()->region));
		$smarty->assign('categories', array('' => 'Alle') + $c->getDropdownCategoriesAll());
		$smarty->assign('types', $rt->getSearchTypes());
		$smarty->assign('regions', array('' => 'Alle') + $rg->getDropDownRegions());

		$region = Dispatcher::inst()->region ? Dispatcher::inst()->region->id : $q->region;
	
		$parties = array('' => 'Alle') + Party::getDropDownParties($region);
		if (!isset($parties[$q->party])) {
			$allParties = array('' => 'Alle') + Party::getDropDownParties($region, true);
			if (isset($allParties[$q->party])) {
				$parties = $allParties;
				$smarty->assign('parExpired', true);
			}
		}
		$smarty->assign('parties', $parties);

		$politicians = array('' => 'Alle') + Politician::getDropDownPoliticians($q->party, $region);
		if (!isset($politicians[$q->politician_id])) {
			$allPoliticians = array('' => 'Alle') + Politician::getDropDownPoliticians($q->party, $region, true);
			if (isset($allPoliticians[$q->politician_id])) {
				$politicians = $allPoliticians;
				$smarty->assign('polExpired', true);
			}
		}
		$smarty->assign('politicians', $politicians);
	}
}