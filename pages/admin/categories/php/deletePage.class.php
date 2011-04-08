<?php

require_once('Category.class.php');

class deletePage {
	private $id = '';	
	
	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
		
		$this->id = $get['id'];
		
		$category = new Category();
		$category->load($this->id);
				
		try {
			$category->delete();
		} catch (Exception $e) {
			$_SESSION['error'] = 'De gekozen categorie kan niet worden verwijderd.';
		}
	}
	
	public function show($smarty) {		
		Dispatcher::header('../');
	}
}

?>