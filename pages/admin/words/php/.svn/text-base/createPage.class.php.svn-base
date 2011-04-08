<?php

require_once('SuspiciousWord.class.php');

class CreatePage {
	protected $data;
	protected $errors = array();

	public function __construct() {
		$this->errors = array(
			'word_0' => false,
			'word_1' => false
		);
	}

	public function processPost($post) {
		if (!isset($post['word']) || !preg_match('/[A-Za-z0-9]+/', $post['word'])) {
			$this->errors['word_0'] = true;
			return false;
		}
		try {
			$w = new SuspiciousWord();
			$w->word = $post['word'];
			$w->save();
			Dispatcher::header('/words/');
		} catch (Exception $e) {
			$this->errors['word_1'] = true;
			return false;
		}
	}

	public function show($smarty) {
		$smarty->assign('formerrors', $this->errors);
		
		$smarty->display('createPage.html');
	}
}

?>