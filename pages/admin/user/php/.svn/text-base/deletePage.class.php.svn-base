<?php

class deletePage {
	public function processGet($get) {
		if(!isset($get['id']) || !ctype_digit($get['id'])) 
			Dispatcher::badRequest();
			
		$obj = new BackofficeUser();
		$obj->load($get['id']);
		$obj->delete();
		
		Dispatcher::header('/user/');
	}
}

?>