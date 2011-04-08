<?php

require_once('Politician.class.php');
require_once('GettextPOGlobal.class.php');

class Vote extends Record {
	private static $pofile;

	protected $data = array(
		'politician' => null,
		'title' => null,
		'first_name' => null,
		'last_name' => null,
		'gender_is_male' => null,
		'raadsstuk' => null,
		'vote' => null,
	);

	protected $extraCols = array(
		'title' => 'p.title',
		'first_name' => 'p.first_name',
		'last_name' => 'p.last_name',
		'gender_is_male' => 'p.gender_is_male',
	);

	protected $tableName = 'rs_votes';
	protected $multiTables = 'rs_votes t JOIN pol_politicians p ON t.politician = p.id';
	

	public function loadByRaadsstuk($raadsstuk) {
		$votes = array();
		foreach ($this->getList($where = 'WHERE raadsstuk = '.$raadsstuk) as $vote) {
			$votes[$vote->politician] = $vote;
		}
		return $votes;
	}

	public function formatName() {
		return Politician::formatPoliticianName($this->title, $this->first_name, $this->last_name, $this->gender_is_male);
	}

	public function getVoteTitle() {
		return self::getVoteTitleStatic($this->vote);
	}

	public static function getVoteTitleStatic($vote) {
		if (!self::$pofile)
			self::$pofile = new GettextPOGlobal('votes.po');

		switch ($vote) {
		case -1: return self::$pofile->getMsgStr('votes.verdeeld');
		case 0: return self::$pofile->getMsgStr('votes.voor');
		case 1: return self::$pofile->getMsgStr('votes.tegen');
		case 2: return self::$pofile->getMsgStr('votes.onthouden');
		case 3: return self::$pofile->getMsgStr('votes.afwezig');
		}
	}
}

?>
