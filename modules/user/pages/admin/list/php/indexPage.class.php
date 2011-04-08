<?php

require_once('indexPageBase.class.php');

class indexPage extends indexPageBase {
	protected $sortDefault = 'id';





	public function show($smarty) {
		$this->loadFromObject();
		parent::show($smarty);
	}




}

?>