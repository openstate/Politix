<?php

require_once('SuspiciousWord.class.php');

class deletePage {

	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id'])) {
			Dispatcher::badRequest();
			die;
		}
			
		$word = new SuspiciousWord();
		$word->load($get['id']);
		$word->delete();
		
		Dispatcher::header('/words/');
	}
}

?>