<?php

require_once('Region.class.php');

class deletePage {
	private $id = '';
	
	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id']))
			Dispatcher::header('../');
		
		$this->id = $get['id'];
		
		$region = new Region();
		$region->load($this->id);
		
		try {
			$region->delete();
		} catch (Exception $e) {
			$_SESSION['error'] = 'De gekozen regio kan niet worden verwijderd.';
		}
	}
	
	public function show($smarty) {
			Dispatcher::header('../');
	}
}

?>