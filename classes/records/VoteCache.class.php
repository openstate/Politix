<?php

class VoteCache extends Record {
	protected $data = array(
		'id' => null,
		'title' => null,
		'vote_date' => null,
		'vote_0' => null,
		'vote_1' => null,
		'vote_2' => null,
		'vote_3' => null,
	);

	protected $extraCols = array(
		'title' => 'rs.title',
		'vote_date' => 'rs.vote_date',
	);

	protected $tableName = 'rs_vote_cache';
	protected $multiTables = 'rs_vote_cache t JOIN rs_raadsstukken rs USING (id)';

	public function loadVotesList($region, $order) {
		return $this->getList('', 'WHERE rs.result > 0 AND rs.region = '.$region, $order);
	}

	public function save() {
		throw new Exception('Operation not supported');
	}
}

?>
