<?php

require_once(dirname(__FILE__).'/../classes/Page.class.php');

class DbpageBlock {
	public function display($smarty, $path = '') {
		$page = new Page();
		if (!$page->exists($path))
			throw new Exception('Path not found in '.$get_class($this).'::display()');
		
		$page->load($path);

		$smarty->assign('page', $page);
		$smarty->displayBlock('page.html');
	}
}
?> 
 
