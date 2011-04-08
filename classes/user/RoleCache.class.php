<?php

class RoleCache {
	private static $instance;
	
	const ROLECACHE_PROPERTY = 'roleCache';

	private function __construct() {
		$_SESSION[self::ROLECACHE_PROPERTY] = array();
	}

	public static function inst() {
		if (!isset(self::$instance)) {
			self::$instance = new RoleCache();
		}
		return self::$instance;
	}

	public function clear() {
		//self::$instance = new RoleCache();
	}

	public function __get($property) {
		return $_SESSION[self::ROLECACHE_PROPERTY][$property];
	}

	public function __set($property, $value) {
		$_SESSION[self::ROLECACHE_PROPERTY][$property] = $value;
		var_dump($_SESSION[self::ROLECACHE_PROPERTY]);
	}

	public function __isset($property) {
		var_dump($property);
		var_dump($_SESSION[self::ROLECACHE_PROPERTY]);
		die;
		return isset($_SESSION[self::ROLECACHE_PROPERTY][$property]);
	}

	public function __unset($property) {
		unset($GLOBALS['_SESSION'][self::ROLECACHE_PROPERTY][$property]);
	}
}

?>