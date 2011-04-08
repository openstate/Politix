<?php

class Query {
	protected $params;

	public function __construct() {
		$this->clear();
	}

	public function insert($name, $value) {
		$this->params[$name] = $value;
		return $this;
	}

	public function remove($name) {
		unset($this->params[$name]);
		return $this;
	}

	public function merge(Query $query) {
		$this->params = array_merge($this->params, $query->params);
		return $this;
	}

	public function __get($name) {
		return @$this->params[$name];
	}

	public function count() {
		return count($this->params);
	}

	public function toString() {
		if ($this->count() == 0) return '';
		return http_build_query($this->params);
	}

	public static function fromString($s) {
		$query = new Query();
		$qs = explode('&',$s);
		foreach ($qs as $q) {
			$params = explode('=', $q, 2);
			if (!isset($params[0])) continue;
			$query->insert($params[0], isset($params[1]) ? $params[1] : '');
		}
		return $query;
	}

	public function clear() {
		$this->params = array();
	}
}

?>
