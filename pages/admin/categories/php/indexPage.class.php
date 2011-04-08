<?php

require_once('indexPageBase.class.php');

class indexPage extends indexPageBase {
	protected $sortDefault = 'id';





	public function show($smarty) {
		if (isset($_SESSION['error'])) {
			$smarty->assign('error', $_SESSION['error']);
			unset($_SESSION['error']);
		}

		$this->loadFromObject();
		parent::show($smarty);
	}




}

?>