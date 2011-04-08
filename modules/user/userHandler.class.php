<?php

class userHandler {
	public $urlMap = array(
		'!^/(login|logout)/?$!' => 'handler',
		'!^/(login)/(password)/?$!' => 'handler',
		'!^/(login)/(reset)/([a-zA-Z0-9]+)?/?$!' => 'handler',
		'!^/users(/[a-zA-Z]+)*(/[0-9]+)?/?$!'    => 'adminHandler'
	);

	public function handler($match, array $pageSets) {
		$get = array();
		if ($match[1] == 'login') {
			if (isset($match[2])) {
				$className = $match[2].'Page';
			} else
				$className = 'indexPage';
			if (isset($match[3]))
				$get['hash'] = $match[3];
		} else
			$className = 'logoutPage';

		return array(
			'file'  => dirname(__FILE__).'/pages/login/php/'.$className.'.class.php',
			'class' => $className,
			'get'   => $get
		);
	}

	public function adminHandler($match, array $pageSets) {
		if (!in_array('admin', $pageSets))
			return false;
					
		if(!Dispatcher::inst()->user->rights['users']->access) {
			return false;
		}

		$parts = explode('/', substr($match[0], 6));
		$parts = array_slice($parts, 1);
		if ($parts[count($parts)-1] == '')
			$parts = array_slice($parts, 0, -1);

		if (count($parts) > 0 && ctype_digit($parts[count($parts)-1])) {
			$id = $parts[count($parts)-1];
			$parts = array_slice($parts, 0, -1);
		}

		$pageClass = 'class';
		$fileName = '/'.implode('/', array_slice($parts, 0, -1));

		if (count($parts) > 0) {
			$lastPart = $parts[count($parts)-1];
			$lastPart = array($lastPart => '/php/'.$lastPart.'Page.class.php', 'index' => '/'.$lastPart.'/php/indexPage.class.php');
		} else {
			return false;
		}

		foreach ($lastPart as $class => $file) {
			if (file_exists(dirname(__FILE__).'/pages/admin/'.$fileName.$file)) {
				$fileName = dirname(__FILE__).'/pages/admin/'.$fileName.$file;
				$className = $class.'Page';
				break;
			}
		}

		if (!isset($className))
			return false;

		return array(
			'file'  => $fileName,
			'class' => $className,
			'get'   => isset($id) ? array('id' => $id) : array()
		);
	}
}

?>