<?php

require_once('GettextPO.class.php');
require_once('Dispatcher.class.php');

/*
 * GettextPO with current module path.
 */
class GettextPOGlobal extends GettextPO {
	public function __construct($filename) {
		parent::__construct($_SERVER['DOCUMENT_ROOT'].'/../locale/'.Dispatcher::inst()->locale.'/'.$filename);
	}
}

?>
