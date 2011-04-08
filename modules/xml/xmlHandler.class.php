<?php

class XmlHandler {
	public $urlMap = array(
		'!^/xml(/[\w\d]+)(/\d+)?/?$!' => 'handler',
		'!^/xml(/[\w\d]+)(/.+)?/?$!' => 'nonIdHandler',
	);

	public function handler($match, array $pageSets) {
		$name = trim($match[1], '/');
		$id = @trim($match[2], '/');

		$fileName = dirname(__FILE__).'/pages/php/'.$name.'Page.class.php';

		if (file_exists($fileName)) {
			ob_clean();
			header('Content-type: text/xml; charset=UTF-8');
			return array(
				'file' => $fileName,
				'class' => $name.'Page',
				'get' => strlen($id) ? array('id' => $id) : array()
			);
		}
		return false;
	}


	/** Allows sting parameters  */
	public function nonIdHandler($match, array $pageSets) {
		$name = trim($match[1], '/');
		$arg = @trim($match[2], '/');

		$fileName = dirname(__FILE__).'/pages/php/'.$name.'APage.class.php';

		if (file_exists($fileName)) {
			ob_clean();
			header('Content-type: text/xml; charset=UTF-8');
			return array(
				'file' => $fileName,
				'class' => $name.'Page',
				'get' => strlen($arg) ? array('arg' => $arg) : array()
			);
		}
		return false;
	}
}

?>