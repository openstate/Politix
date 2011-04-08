<?php

class Page extends Record {
	protected $data = array(
		'url'     => null,
		'region'  => null,
		'title'   => null,
		'content' => null,
		'linkText'=> null,
		'showInMenu' => null,
	);

	protected $tableName = 'pg_pages';
	protected $defaultNames = array("'home'", "'search'", "'about'");

	public function loadByUrl($url, $region = null) {
		$result = $this->getList($this->db->formatQuery('WHERE url = %', $url).' AND region '.(null == $region ? 'IS NULL' : '= '._id($region)));
		if (count($result)) return reset($result);
		else if ($region != null) return $this->loadByUrl($url);
		else return null;
	}

	public function exists($url, $region) {
		return $this->db->query('select 1 from pg_pages where url = % and region '.(null == $region ? 'IS NULL' : '= '._id($region)), $url)->fetchCell() == 1;
	}

	public function isSpecial() {
		return in_array("'".$this->url."'", $this->defaultNames);
	}

	public function getVisiblePages($region) {
		return $this->getList('WHERE region '.(null == $region ? 'IS NULL' : '= '._id($region)).' AND "showInMenu" = 1');
	}

	public function getDefaultPages($region) {
		$custom = $this->getList('where url in ('.implode(',', $this->defaultNames).') and region = '._id($region));
		$default = $this->getList('where url in ('.implode(',', $this->defaultNames).') and region IS NULL');

		$result = array();
		foreach ($default as $p) {
			$result[$p->url] = $p;
		}
		foreach ($custom as $p) {
			$result[$p->url] = $p;
		}
		return $result;
	}
}