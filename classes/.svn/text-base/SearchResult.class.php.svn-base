<?php

require_once('Xml.class.php');
require_once('Raadsstuk.class.php');

class SearchResult {
	protected $xml;
	protected $hl;

	protected $data = array(
		'id' => null,
    'region' => null,
		'region_name' => null,
    'title' => null,
		'title_hl' => null,
    'vote_date' => null,
    'categories' => null,
    'summary' => null,
		'summary_hl' => null,
    'code' => null,
    'type' => null,
		'type_name' => null,
    'result' => null,
		'tags' => null,
		'vote_0' => null,
		'vote_1' => null,
		'vote_2' => null,
		'vote_3' => null,
	);

	public function __construct($data, $tags = null, $categories = null) {
		$this->data = array_merge($this->data, array_intersect_key($data, $this->data));
		$this->data['tags'] = $tags;
		$this->data['categories'] = $categories;
		$this->hl = false;
	}

	public function hasProperty($name) {
		return array_key_exists($name, $this->data);
	}

	public function __get($name) {
		if ($this->hasProperty($name)) {
			if ('hl' == substr($name, -2))
				$this->modifyHeadlines();
			return $this->data[$name];
		}
	}

	public function __set($name, $value) {
		if ($this->hasProperty($name))
			$this->data[$name] = $value;
	}

	private function modifyHeadlines() {
		if (!$this->hl) {
			foreach ($this->data as $key => $value) {
				if ('hl' == substr($key, -2)) {
					$this->modifyHeadline($key, substr($key, 0, -3));
				}
			}
			$this->hl = true;
		}
	}

	private function modifyHeadline($hlkey, $key) {
		$hl = $this->data[$hlkey];
		$hlNew = $hl;
		
		$hl = strip_tags(trim(preg_replace('/\s+/', ' ', $hl)));
		$v = strip_tags(trim($this->data[$key]));
		if (substr($v, 0, strlen($hl)) != $hl) {
			$hlNew = '... '.$hlNew;
		}
		if (substr($v, -strlen($hl)) != $hl) {
			$hlNew .= ' ...';
		}
		$this->data[$hlkey] = $hlNew;
	}

	public function getResultTitle($result = null) {
		return Raadsstuk::getResultName($result ? $result : $this->result);
	}

	private function fieldToXml($name, $escape = false, $xmlName = null) {
		if (null == $xmlName) $xmlName = $name;
		$data = $this->$name;
		return $this->xml->fieldToXml($xmlName, $data, $escape);
	}

	public function toXml($xml) {
		$this->xml = $xml;
		$this->data['vote_date'] = substr($this->data['vote_date'], 0, 10);

		return $this->xml->getTag('raadsstuk').
			$this->fieldToXml('id').
			$this->xml->getTag('region').
			$this->fieldToXml('region', false, 'id').
			$this->fieldToXml('region_name', true, 'name').
			$this->xml->getTag('region', true).
			$this->fieldToXml('title', true).
			$this->fieldToXml('summary', true).
			$this->categoriesToXml().
			$this->fieldToXml('code', true).
			$this->xml->getTag('type').
			$this->fieldToXml('type', false, 'id').
			$this->fieldToXml('type_name', true, 'name').
			$this->xml->getTag('type', true).
			$this->fieldToXml('vote_date', false, 'date').
			$this->fieldToXml('result').
			$this->xml->getTag('votes').
			$this->fieldToXml('vote_0', false, 'yea').
			$this->fieldToXml('vote_1', false, 'nay').
			$this->fieldToXml('vote_2', false, 'abstain').
			$this->fieldToXml('vote_3', false, 'absent').
			$this->xml->getTag('votes', true).
			$this->tagsToXml().
			$this->xml->getTag('raadsstuk', true);
	}

	private function categoriesToXml() {
		$s = $this->xml->getTag('categories');
		if (@count($this->data['categories']) > 0) {
			foreach ($this->data['categories'] as $i) {
				$s .= $this->xml->getTag('category') .
					$this->xml->fieldToXml('id', $i['id'], true) .
					$this->xml->fieldToXml('name', $i['name'], true) .
					$this->xml->getTag('category', true);
			}
		}
		return $s.$this->xml->getTag('categories', true);
	}

	private function tagsToXml() {
		$s = $this->xml->getTag('tags');
		if (@count($this->data['tags']) > 0) {
			foreach ($this->data['tags'] as $i) {
				$s .= $this->xml->fieldToXml('tag', $i['name'], true);
			}
		}
		return $s.$this->xml->getTag('tags', true);
	}
}

?>
