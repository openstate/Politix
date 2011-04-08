<?php

require_once('Query.class.php');

class SearchQuery extends Query {
	public static function fromString($s) {
		$query = new SearchQuery();
		$qs = array_slice(explode('/',$s), 2);
		for ($i = 0; $i < count($qs); $i += 2) {
			$query->insert($qs[$i], isset($qs[$i+1]) ? $qs[$i+1] : '');
		}
		return $query;
	}

	public function toString() {
		if ($this->count() == 0) return '';
		$s = '';
		foreach ($this->params as $key => $value) {
			$s .= '/'.$key.'/'.$value;
		}		
		return $s;
	}
}