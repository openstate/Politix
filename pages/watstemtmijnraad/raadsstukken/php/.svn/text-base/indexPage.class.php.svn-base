<?php

require_once('IndexHandler.class.php');
require_once('VoteCache.class.php');

class IndexPage extends IndexHandler {
	public function __construct() {
		$this->sortKeys = array('id', 'title', 'vote_date', 'vote_0', 'vote_1', 'vote_2', 'vote_3');
	}

	public function processGet($get) {
		try {
			$v = new VoteCache();
			$this->data = $v->loadVotesList(@$get['id'], $this->getOrder());
		} catch (Exception $e) {
			Dispatcher::header('/');
		}
	}
}

?>
