<?php

class ajaxHandler {
	private $page;

	public $urlMap = array(
		'!^/ajax/([^/]*)/([a-zA-Z0-9]+)?/?$!' => 'handler',
	);

	public function handler($match, array $pageSets) {
		
		$className = $match[1].'Page';
		$fileName = dirname(__FILE__).'/pages/php/'.$className.'.class.php';
						
		$parts = explode('/', substr($match[0], 6));
		$parts = array_slice($parts, 1);
		if ($parts[count($parts)-1] == '')
			$parts = array_slice($parts, 0, -1);
					
		if (count($parts) > 0 && ctype_digit($parts[count($parts)-1])) {
			$id = $parts[count($parts)-1];			
		}
				
		if(file_exists($fileName)) {			
			return array(
				'file'  => $fileName,
				'class' => $className,
				'get'   => isset($id) ? array('id' => $id) : array()
			);
		} else {
			return false;
		}
	}

	public function getCrumbs() {
		return array();
	}
}

?>