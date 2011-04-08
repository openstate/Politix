<?php

require_once('Region.class.php');
require_once('Category.class.php');
require_once('RaadsstukType.class.php');
require_once('Xml.class.php');

class FormPage {
	public function processGet($get) {
		$r = new Region();
		$c = new Category();
		$t = new RaadsstukType();

		$xml = Xml::getDefault();
		echo Xml::getPrelude();
		echo $xml->getRoot('form');
		echo $this->listToXml($r->getList('ORDER BY id'), $xml, 'regions');
		echo $this->listToXml($c->getList('ORDER BY id'), $xml, 'categories');
		echo $this->listToXml($t->getList('ORDER BY id'), $xml, 'types');
		echo $xml->getTag('form', true);
	}

	private function listToXml($list, $xml, $tag) {
		$s = $xml->getTag($tag);
		foreach ($list as $i) {
			$s .= $i->toXml($xml);
		}
		return $s.$xml->getTag($tag, true);
	}
}

?>