<?php

require_once('IndexHandler.class.php');
require_once('Raadsstuk.class.php');
require_once('Party.class.php');
require_once('Vote.class.php');

class PartyPage extends IndexHandler {
	private $rs;

	public function __construct() {
		$this->sortDefault = 'name_sortkey';
		$this->sortKeys = array('id', 'first_name', 'name_sortkey');
	}

	public function processGet($get) {
		try {
			$this->rs = new Raadsstuk(@$get['raadsstuk']);

			$ids = isset($_SESSION['user'])? $_SESSION['user']->listSiteIds(): User::listDefaultSiteIds();
			if(!isset($ids[$this->rs->site_id])) Dispatcher::forbidden();

			$this->party = new Party(@$get['id']);
			$vote = new Vote();

			//29-07-2008
			//added r.vote_date BETWEEN pf.time_start AND pf.time_end to filter out inconsistent data
			$this->data = $vote->getList('JOIN rs_raadsstukken r ON r.id = t.raadsstuk JOIN pol_politician_functions pf ON pf.region = r.region AND t.politician = pf.politician AND r.vote_date BETWEEN pf.time_start AND pf.time_end', 'WHERE r.id = '.$this->rs->id.' AND pf.party = '.$this->party->id, $this->getOrder());
			//end of the fix

		} catch (Exception $e) {
			Dispatcher::header('/');
		}
	}

	public function show($smarty) {
		$smarty->assign('raadsstuk', $this->rs);
		$smarty->assign('party', $this->party);
		parent::show($smarty);
	}
}

?>
