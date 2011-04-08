<?php

require_once('Vote.class.php');

class PartyVoteCache extends Record {
	protected $data = array(
		'id' => null,
		'party' => null,
		'party_name' => null,
		'party_short_name' => null,
		'raadsstuk' => null,
		'vote_0' => 0,
		'vote_1' => 0,
		'vote_2' => 0,
		'vote_3' => 0,
	);

	protected $extraCols = array(
		'party_name' => 'p.name',
		'party_short_name' => 'p.short_form',
	);

	protected $tableName = 'rs_party_vote_cache';
	protected $multiTables = 'rs_party_vote_cache t JOIN pol_parties p ON p.id = t.party';

	public function loadVotesList($raadsstuk, $order = null) {
		return $this->getList('', 'WHERE t.raadsstuk = '.$raadsstuk, $order);
	}

	public function loadVotesListAssociativeOnParty($raadsstuk, $order = null) {
		$result = array();
		foreach ($this->loadVotesList($raadsstuk, $order) as $votes) {
			$result[$votes->party] = $votes;
		}
		return $result;
	}

	public function getResult() {
		if ($this->vote_0 && $this->vote_1) return -1;
		for ($i = 0; $i < 4; $i++) {
			if ($this->{'vote_'.$i}) return $i;
		}
	}

	public function getResultTitle() {
		return Vote::getVoteTitleStatic($this->getResult());
	}

	public function toXml($xml) {
		return $xml->getTag('votes').
			$xml->fieldToXml('yea', $this->vote_0).
			$xml->fieldToXml('nay', $this->vote_1).
			$xml->fieldToXml('abstain', $this->vote_2).
			$xml->fieldToXml('absent', $this->vote_3).
			$xml->getTag('votes', true);
	}

	public function save() {
		throw new Exception('Operation not supported');
	}
}

?>
