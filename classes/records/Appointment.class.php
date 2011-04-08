<?php

//require_once('Answer.class.php');

class Appointment extends Record {
	protected $data = array(
		'politician'  => null,
		'party'       => null,
		'party_name'  => null,
		'region'      => null,
		'region_name' => null,
		'level'       => null,
		'level_name'  => null,
		'category'    => null,
		'cat_name'    => null,
		'time_start'  => null,
		'time_end'    => null,
		'description' => null
	);
	protected $extraCols = array(
		'party_name'  => 'p.name',
		'region_name' => 'r.name',
		'cat_name'    => 'c.name',
		'level'       => 'l.id',
		'level_name'  => 'l.name'
	);
	protected $multiTables = '
		pol_politician_functions t
		JOIN pol_parties p ON p.id = t.party
		JOIN sys_regions r ON r.id = t.region
		JOIN sys_categories c ON c.id = t.category
		JOIN sys_levels l on r.level = l.id';
	protected $tableName = 'pol_politician_functions';

	public function loadByPolitician($politician, $order='', $limit='') {
		return $this->getList('', 'WHERE t.politician = '.$politician, $order, $limit);
	}

	public function loadActiveByPolitician($politician, $order='', $limit='') {
		return $this->getList('', 'WHERE t.politician = '.$politician.' AND time_end > now()', $order, $limit);
	}

	public function isExpired() {
		return $this->time_end < date('Y-m-d H:i:s');
	}

	/*	public function loadRandomPolitician($category, $party, $region) {
		$criteria = array(
			'cat'  => 't.category = '.$category,
			'pty'  => 't.party = '.$party,
			'reg'  => 't.region = '.$region,
			'time' => 'now() BETWEEN t.time_start AND t.time_end'
		);
		$results = array();
		$answer = new Answer();

		for ($i = 0; $i < 8; $i++) {
			$criteriaSpliced = $criteria;
			if ($i & 1) unset($criteriaSpliced['pty']);
			if ($i & 2) unset($criteriaSpliced['cat']);
			if ($i & 4) unset($criteriaSpliced['reg']);

			$results = $this->db->query('
				SELECT t.id, CASE WHEN a.count IS NULL THEN 0 ELSE a.count END AS count
				FROM '.$this->tableName.' t
				LEFT JOIN (SELECT politician, count(*) AS count
				           FROM '.$answer->getTableName().' WHERE is_final = 0
				           GROUP BY politician) a ON a.politician = t.politician
				WHERE '.implode(' AND ', $criteriaSpliced).'
				ORDER BY count ASC LIMIT 1')->fetchAllRows();

			if (count($results))
				break;
		}
		$result = array_pop($results);
		$this->load($result['id']);
	}

	public function findAppointment($politician, $category = false, $party = false, $region = false) {
		$criteria = array(
			'pol'  => 't.politician = '.$politician,
			'time' => 'now() BETWEEN t.time_start AND t.time_end'
		);
		if ($category) $criteria['cat'] = 't.category = '.$category;
		if ($party) $criteria['pty'] = 't.party = '.$party;
		if ($region) $criteria['reg']  = 't.region = '.$region;
		$results = array();
		$answer = new Answer();

		for ($i = 0; $i < 8; $i++) {
			$criteriaSpliced = $criteria;
			if ($i & 1) unset($criteriaSpliced['pty']);
			if ($i & 2) unset($criteriaSpliced['cat']);
			if ($i & 4) unset($criteriaSpliced['reg']);

			$results = $this->db->query('
				SELECT t.id
				FROM '.$this->tableName.' t
				WHERE '.implode(' AND ', $criteriaSpliced).'
				LIMIT 1')->fetchAllRows();

			if (count($results))
				break;
		}
		$result = array_pop($results);
		$this->load($result['id']);
		}*/

}

?>
