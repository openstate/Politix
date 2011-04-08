<?php

require_once('createPageBase.class.php');

class createPage extends createPageBase {
	

	public function show($smarty) {
		
		parent::show($smarty);
	}

	public function saveToObject() {
		require_once('Page.class.php');
		$obj = new Page();
		DBs::inst(DBs::SYSTEM)->query('INSERT INTO '.$obj->getTableName().' ("%l") VALUES (%l)',
			implode('","', array_keys($this->data)),
			implode(',', array_map(create_function('$s', 'return DBs::inst(DBs::SYSTEM)->formatQuery(\'%s\', $s);'), $this->data)));
	}

	public function action() {
		$this->saveToObject();
		Dispatcher::header('../');
	}



}

?>