<?php

require_once('GettextPOGlobal.class.php');

class Raadsstuk extends Record {
	private static $pofile;

	const NOTVOTED = 0;
	const ACCEPTED = 1;
	const REJECTED = 2;

	protected $data = array(
		'region' => null,
		'region_name' => null,
		'title' => null,
		'vote_date' => null,
		'summary' => null,
		'code' => null,
		'type' => null,
		'type_name' => null,
		'result' => null,
		'submitter' => null,
		'submit_type_name' => null,
		'parent' => null,
		'show' => null,
		'site_id' => null,
		'site' => null,
		'vote_0' => null,
		'vote_1' => null,
		'vote_2' => null,
		'vote_3' => null,
	);

	protected $extraCols = array(
		'region_name' => 'r.name',
		'type_name' => 'rt.name',
		'submit_type_name' => 'st.name',
		'site' => 'ss.title',
		'vote_0' => 'v.vote_0',
		'vote_1' => 'v.vote_1',
		'vote_2' => 'v.vote_2',
		'vote_3' => 'v.vote_3',
	);

	protected $tableName = 'rs_raadsstukken';
	protected $multiTables = 'rs_raadsstukken t JOIN sys_site ss ON ss.id = t.site_id JOIN sys_regions r ON r.id = t.region JOIN rs_raadsstukken_type rt ON t.type = rt.id JOIN rs_raadsstukken_submit_type st ON t.submitter = st.id JOIN rs_vote_cache v ON t.id = v.id';


	private function _filterSite() {
		$ids = array_keys(isset($_SESSION['user'])? $_SESSION['user']->listSiteIds(): User::listDefaultSiteIds());
		if(empty($ids)) $wher = ' AND FALSE';
		else $wher = ' AND t.site_id IN ('.implode(', ', $ids).')';
		return $wher;
	}

	public function getListByRegion($region, $order = '', $limit = '') {
		return $this->getList('', 'WHERE region = '.$region.' '.$this->_filterSite(), $order, $limit);
	}

	public function getCountByRegion($region) {
		return $this->getCount('WHERE region = '.$region.' '.$this->_filterSite());
	}

	public function getCountByCategory($region) {
		return $this->db->query('select c.id as category, c.name as name, count(*) from rs_raadsstukken t join rs_raadsstukken_categories rc on t.id = rc.raadsstuk join sys_categories c on rc.category = c.id where '.($region ? 't.region=% and ' : '').'t.result > 0 '.$this->_filterSite().' group by c.id, c.name order by c.name', $region)->fetchAllRows();
	}

	public function showVotes() {
		return strtotime($this->vote_date) <= time();
	}

	public function getVoters() {
		$voters = array();
		foreach ($this->db->query('SELECT pf.politician, po.first_name, po.last_name, pf.party FROM rs_raadsstukken r JOIN pol_party_regions pr ON r.region = pr.region JOIN pol_politician_functions pf ON pf.region = pr.region AND pf.party = pr.party JOIN pol_politicians po ON po.id = pf.politician WHERE r.vote_date BETWEEN pf.time_start AND pf.time_end AND r.id = %', $this->id)->fetchAllRows() as $voter) {
			$voters[$voter['politician']] = $voter;
		}
		return $voters;
	}

	public function hasResult() {
		return $this->result > 0;
	}

	public function getResultTitle() {
		return self::getResultName($this->result);
	}

	public static function getResultName($result) {
		if (!self::$pofile)
			self::$pofile = new GettextPOGlobal('raadsstuk.po');

		switch ($result) {
		case self::NOTVOTED: return self::$pofile->getMsgStr('raadsstuk.notvoted');
		case self::ACCEPTED: return self::$pofile->getMsgStr('raadsstuk.accepted');
		case self::REJECTED: return self::$pofile->getMsgStr('raadsstuk.rejected');
		}
	}

	public static function getResultArray() {
		$names = array();
		for ($i = 0; $i < 3; $i++) {
			$names[$i] = self::getResultName($i);
		}
		return $names;
	}
}

?>
