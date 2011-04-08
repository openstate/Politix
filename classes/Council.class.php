<?php

require_once('Party.class.php');
require_once('PartyVoteCache.class.php');

class Council {
	private static $_p;

	private $members = array();
	private $parties = array();

	private function __construct($members = null) {
		if (is_array($members))
			$this->members = $members;
	}

	public function addMember(CouncilMember $m) {
		$this->members[$m->id] = $m;
		if (!($p = &$this->parties[$m->party])) {
			$p = new CouncilParty($m->party, self::getParty($m->party)->name);
		}
		$p->addMember($m);
	}

	public function getMembers() {
		return $this->members;
	}

	public function getView() {
		return new CouncilView($this->members, $this->parties);
	}

	private static function getParty($id) {
		if (!self::$_p) {
			$p = new Party();
			self::$_p = $p->getList();
		}
		return self::$_p[$id];
	}

	public static function getCouncilByDate($region, $date = false) {
		if (!$date) $date = time();
		return self::getCouncil($region, 'SELECT pf.politician, po.first_name, po.last_name, po.extern_id, pf.party, po.def_party FROM pol_party_regions pr JOIN pol_politician_functions pf ON pf.region = pr.region AND pf.party = pr.party JOIN pol_politicians po ON po.id = pf.politician WHERE '.strftime('\'%Y-%m-%d\'', $date).' BETWEEN pf.time_start AND pf.time_end AND '.strftime('\'%Y-%m-%d\'', $date).' BETWEEN pr.time_start AND pr.time_end AND pr.region = % ORDER BY name_sortkey, last_name, first_name');
	}

	public static function getCurrentCouncil($region) {
		return self::getCouncil($region, 'SELECT pf.politician, po.first_name, po.last_name, po.extern_id, pf.party, po.def_party FROM pol_party_regions pr JOIN pol_politician_functions pf ON pf.region = pr.region AND pf.party = pr.party JOIN pol_politicians po ON po.id = pf.politician WHERE now() BETWEEN pf.time_start AND pf.time_end AND now() BETWEEN pr.time_start AND pr.time_end AND pr.region = % ORDER BY name_sortkey, last_name, first_name');
	}

	public static function getCouncilFromRaadsstuk($rs) {
		return self::getCouncil($rs, 'SELECT pf.politician, po.first_name, po.last_name, po.extern_id, pf.party, po.def_party FROM rs_raadsstukken r JOIN pol_party_regions pr ON r.region = pr.region JOIN pol_politician_functions pf ON pf.region = pr.region AND pf.party = pr.party JOIN pol_politicians po ON po.id = pf.politician WHERE r.vote_date BETWEEN pf.time_start AND pf.time_end AND r.vote_date BETWEEN pr.time_start AND pr.time_end AND r.id = % ORDER BY name_sortkey, last_name, first_name');
	}

	private static function getCouncil($obj, $query) {
		$id = is_object($obj) ? $obj->id : $obj;
		$me = new self();
		foreach (DBs::inst(DBs::SYSTEM)->query($query, $id)->fetchAllRows() as $v) {
			$me->addMember(new CouncilMember($v['politician'], $v['first_name'], $v['last_name'], $v['party'], $v['extern_id'], $v['def_party']));
		}
		return $me;
	}
}

class CouncilParty {
	public $id;
	public $name;
	private $members = array();

	public function __construct($id, $name, $members = null) {
		$this->id = $id;
		$this->name = $name;
		if (is_array($members))
			$this->members = $members;
	}

	public function addMember(CouncilMember $m) {
		$this->members[$m->id] = $m;
	}

	public function getMembers() {
		return $this->members;
	}
}


class CouncilMember {
	public $id;
	public $firstName;
	public $lastName;
	public $party;
	public $extern_id; //this code is pretty much fucked up... we have CouncilMember's and Politician's which handles the same records...
	public $def_party;

	public function __construct($id, $firstName, $lastName, $party, $extern_id = null, $def_party = null) {
		$this->id = $id;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->party = $party;
		$this->extern_id = $extern_id;
		$this->def_party = $def_party;
	}

	public function formatName() {
		return $this->firstName . ' ' . $this->lastName;
	}
}

class CouncilView {
	private $_m;
	private $_p;

	public function __construct(&$members, &$parties) {
		$this->_m =& $members;
		$this->_p =& $parties;
	}

	public function getMembersByParty() {
		$ret = array();
		foreach ($this->_p as $p) {
			$party = &$ret[$p->name];
			$party = array();
			foreach ($p->getMembers() as $m) {
				$party[$m->id] = $m->formatName();
			}
		}
		ksort($ret);
		return $ret;
	}

	public function getPartiesByMember() {
		$ret = array();
		foreach ($this->_m as $m) {
			$party = &$this->_p[$m->party];
			$ret[$m->id] = $party->name;
		}
		ksort($ret);
		return $ret;
	}

	public function getMembersByPartyWithVotesAndNames($votes) {
		$ret = array();
		foreach ($this->_p as $p) {
			$party = &$ret[$p->name];
			$party = array('id' => $p->id, 'politicians' => array());
			foreach ($p->getMembers() as $m) {
				$party['politicians'][$m->id] = array(
				  'name' => $m->formatName(),
				  'extern_id' => $m->extern_id,

				  /* [FIXME: What a fuck is this?! if $votes doesn't contain mapping for $m->id, then
				   *         we will catch deadly "method called on non object" in our templates and die unexpectedly!] */
				  'vote' => @$votes[$m->id],
				  'def_party' => $m->def_party
				  );
			}
		}
		ksort($ret);
		return $ret;
	}

	public function toXml($partyVotes, $votes, $xml) {
		$s = $xml->getTag('parties');
		foreach ($this->getMembersByPartyWithVotesAndNames($votes) as $pname => $party) {
			$s .= $xml->getTag('party').
				$xml->fieldToXml('id', $party['id']).
				$xml->fieldToXml('name', $pname, true);
			if (null == ($pv = @$partyVotes[$party['id']]))
				$pv = new PartyVoteCache();
				$s .= $pv->toXml($xml).$xml->getTag('politicians');
			foreach ($party['politicians'] as $pid => $politician) {
				$s .= $xml->getTag('politician').
					$xml->fieldToXml('id', $pid).
					$xml->fieldToXml('name', $politician['name'], true).
					$xml->fieldToXml('vote', @$politician['vote']->vote).
					$xml->getTag('politician', true);
			}
			$s .= $xml->getTag('politicians', true).
				$xml->getTag('party', true);
		}
		return $s.$xml->getTag('parties', true);
	}

	private function votesToXml($votes, $xml) {
		return $xml->getTag('votes').
			$votes->toXml($xml);
			$xml->getTag('votes', true);
	}
}

?>