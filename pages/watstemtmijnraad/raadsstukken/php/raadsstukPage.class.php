<?php

require_once('IndexHandler.class.php');
require_once('Raadsstuk.class.php');
require_once('RaadsstukTag.class.php');
require_once('RaadsstukType.class.php');
require_once('RaadsstukCategory.class.php');
require_once('Submitter.class.php');
require_once('SubmitterParty.class.php');
require_once('PartyVoteCache.class.php');
require_once('VoteCache.class.php');
require_once('Council.class.php');
require_once('Vote.class.php');

class RaadsstukPage extends IndexHandler {
	private $rs;
	private $council;
	private $members;
	private $preview;
	private $totals;

	public function __construct() {
		$this->sortDefault = 'party_name';
		$this->sortKeys = array('id', 'party_name', 'vote_0', 'vote_1', 'vote_2', 'vote_3');
	}

	public function processGet($get) {
		try {
			$this->preview = @$get['preview'];
			if ($this->preview == 'rs')
				$this->rs = $_SESSION['preview']['rs'];
			else
				$this->rs = new Raadsstuk(@$get['id']);

			if ($this->preview == 'vote')
				$this->rs->result = $_SESSION['preview']['result'];

			$ids = Dispatcher::sessionUser() ? Dispatcher::sessionUser()->listSiteIds(): User::listDefaultSiteIds();
			if(!isset($ids[$this->rs->site_id])) Dispatcher::forbidden();


			//[FIXME: 07-08-2008: this will select all politicians in the region of the raadsstuk, it doesn't matter that not all of them made a vote]
			if ($this->preview == 'rs')
				$council = Council::getCouncilByDate($this->rs->region, strtotime($this->rs->vote_date));
			else
				$council = Council::getCouncilFromRaadsstuk($this->rs);

			//[FIXME: 07-08-2008: if a vote is not found in list, then it will be @supressed, this is weird]
			if ($this->preview)
				$this->council = $council->getView()->getMembersByPartyWithVotesAndNames(@$_SESSION['preview']['votes']);
			else {
				$vote = new Vote();
				$this->council = $council->getView()->getMembersByPartyWithVotesAndNames($vote->loadByRaadsstuk($this->rs->id));
			}

			$this->members = $council->getView()->getPartiesByMember();

			if ($this->preview) {
				$this->totals = new stdClass();
				$this->totals->vote_0 = $this->totals->vote_1 = $this->totals->vote_2 = $this->totals->vote_3 = 0;
				$this->data = array();
				foreach($this->council as $party => $array) {
					$el = new stdClass();
					$el->party = $array['id'];
					$el->party_name = $party;
					$el->vote_0 = $el->vote_1 = $el->vote_2 = $el->vote_3 = 0;
					foreach($array['politicians'] as $key => $politician)
						if ($politician['vote']) {
							$vt = 'vote_'.$politician['vote']->vote;
							$el->$vt++;
							$this->totals->$vt++;
						}
					$el->result = 0;
					if ($el->vote_0 && $el->vote_1) $el->result = -1;
					else for ($i = 0; $i < 4; $i++) {
						if ($el->{'vote_'.$i}) { $el->result = $i; break; }
					}
					$el->result_title = Vote::getVoteTitleStatic($el->result);
					$this->data[] = $el;
				}
			} else {
				$v = new PartyVoteCache();
				$this->data = $v->loadVotesList($this->rs->id, $this->getOrder());
			}

			//[FIX: 07-08-2008: filter out politicians that have not made that fucking vote and still are selected.]
			foreach ($this->council as $k => $con) {
				foreach ($con['politicians'] as $kp => $pol) {
					if($pol['vote'] == null) unset($this->council[$k]['politicians'][$kp]);
				}
				if(sizeof($this->council[$k]['politicians']) == 0) unset($this->council[$k]);
			}

			//hide Onbekend
			foreach ($this->council as $k => $con) {
				foreach ($con['politicians'] as $kp => $pol) {
					if($pol['def_party'] != null) unset($this->council[$k]['politicians'][$kp]);
				}
			}

			//[FIX: 07-08-2008: filter all empty parties]
			foreach ($this->data as $k => $row) {
				if(!isset($this->council[$row->party_name])) unset($this->data[$k]);
			}
		} catch (Exception $e) {
			var_dump($e->__toString());
			//Dispatcher::header('/');
		}
	}

	public function show($smarty) {
		$t = new RaadsstukTag();
		$c = new RaadsstukCategory();
		$s = new Submitter();
		$ps = new SubmitterParty();

		$smarty->assign('preview', $this->preview);

		$smarty->assign('img', @$_GET['img']);
		$smarty->assign('council', $this->council);
		$smarty->assign('categories', $this->preview == 'rs' ? $_SESSION['preview']['cat'] : $c->getCategoriesByRaadsstuk($this->rs->id));
		$smarty->assign('tags', $this->preview == 'rs' ? $_SESSION['preview']['tag'] : $t->getTagsByRaadsstuk($this->rs->id));
		$smarty->assign('politician_base_url', POLITICIAN_BASE_URL);

		$subs = array();
		$psub = null;

		//[FIXME: direct id is used, must be a kind of a member function is*()]
		if($this->rs->type == 1) { //Wetsvoorstel
			//[FIXME: inefficient, unneeded queries]
			$party_id = $ps->getSubmitterPartyByRaadsstuk($this->rs->id);
			if($party_id !== null) {
				try {
					$party = new Party();
					$party->load($party_id);
					$psub = $party;
				} catch (Exception $e) { //record not found, can't happen

				}
			} else $smarty->assign('regering', 'Regering'); //this sucks =/
		} else {
			foreach ($this->preview == 'rs' ? $_SESSION['preview']['subs'] : $s->getSubmittersNameByRaadsstuk($this->rs->id) as $id => $name) {
				$t = &$subs[@$this->members[$id]];
				$t[$id] = $name;
			}
		}

		$smarty->assign('submitters', $subs);
		$smarty->assign('paty_sbmitter', $psub);
		$smarty->assign('raadsstuk', $this->rs);

		$smarty->assign('totals', $this->preview ? $this->totals : $this->rs);

		if ($this->rs->parent)
			$smarty->assign('parent', new Raadsstuk($this->rs->parent));

		if (!$this->preview == 'rs') {
			$smarty->assign('amendementen', $this->rs->getList('', 'WHERE t.type = '.RaadsstukType::AMENDEMENT.' AND t.parent = '.$this->rs->id));
			$smarty->assign('moties', $this->rs->getList('', 'WHERE t.type = '.RaadsstukType::MOTIE.' AND t.parent = '.$this->rs->id));
		}

		parent::show($smarty);
	}
}

?>
