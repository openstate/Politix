<?php

require_once('GettextPO.class.php');
require_once('Dispatcher.class.php');

/*
 * GettextPO with current module path.
 */
class GettextPOModule extends GettextPO {
	public function __construct($filename) {
		parent::__construct('../pages/admin/'.Dispatcher::inst()->getModule().'/locale/'.Dispatcher::inst()->locale.'/'.$filename);
	}
}

?>
