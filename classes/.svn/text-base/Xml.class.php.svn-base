<?php

class Xml {
	protected $namespace;

	public function __construct($namespace = '') {
		$this->setNamespace($namespace);
	}

	public static function getDefault() {
		return new self('wsmr');
	}

	public function getNamespace() {
		return $this->namespace;
	}

	public function setNamespace($namespace) {
		$this->namespace = $namespace;
	}

	public function getRoot($name, $xsdName = null) {
		if (null == $xsdName) $xsdName = $name;
		return '<'.(strlen($this->namespace) ? $this->namespace.':' : '').
			$name.' xmlns'.(strlen($this->namespace) ? ':'.$this->namespace : '').'="http://www.politix.nl" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.politix.nl http'.(isset($_SERVER['HTTPS'])?'s':'').'://'.$_SERVER['SERVER_NAME'].'/xml/'.$xsdName.'.xsd">';
	}

	public function getTag($name, $close = false) {
		$ret = '<';
		if ($close) $ret .= '/';
		if (strlen($this->namespace)) $ret .= $this->namespace.':';
		return $ret.$name.'>';
	}

	public function fieldToXml($name, $value, $escape = false) {
		if ($escape) $value = $this->cdata_escape($value);
		return $this->getTag($name).$value.$this->getTag($name, true);
	}

	public static function getPrelude() {
		return '<?xml version="1.0" encoding="UTF-8"?>';
	}

	protected function cdata_escape($value) {
		return '<![CDATA['.str_replace(']]>', ']]]]><![CDATA[>', $value).']]>';
	}
}

?>