<?php

require_once('indexPageBase.class.php');

class indexPage extends indexPageBase {
	public function show($smarty) {
		$this->loadFromObject();
		parent::show($smarty);
	}
}

?>