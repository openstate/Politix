<?php

require_once('InputFilter.class.php');

class InputFilterFactory {
	private function __construct() {}

	private static $strictTags     = array('p','br','ul','ol','li','b','i','u','strong','em','a','table','caption','tbody','th','tr','td','h1','h2','h3','h4','h5','h6');
	private static $strictAttrs    = array('href'  , 'width'           , 'height'          , 'cellspacing'   , 'cellpadding'  , 'border'        , 'align' , 'summary', 'target');
	private static $strictAttrVals = array('/^.+$/', '/^[0-9]{1,3}%?$/', '/^[0-9]{1,3}%?$/', '/^[0-9]{1,2}$/','/^[0-9]{1,2}$/', '/^[0-9]{1,2}$/', '/^.+$/', '/^.+$/' , '/^_blank$/');

	/*
	 * Strict filter allowing only relatively harmless tags and attributes
	 * @return InputFilter implementing strict rules
	 */
	public static function filterHtmlStrict() {
		return $filter = new InputFilter(self::$strictTags, self::$strictAttrs, self::$strictAttrVals, 0, 0, 0);
	}

	/*
	 * Strict filter allowing only relatively harmless tags and attributes and the image tag and attributes
	 * @param Array $allowedImgSources List of allowed urls, default is to allow all sources
	 * @return InputFilter implementing strict rules with images
	 */
	public static function filterHtmlStrictAllowImg($allowedImgSources = false) {
		if ($allowedImgSources === false) {
			$regexp = '!^http://.+!';
		} else {
			$regexp = '!^'.str_replace('.', '\.', implode('|', array_map(create_function('$src', 'return "(http://".$src.")";'), $allowedImgSources))).'!';
		}
		return $filter = new InputFilter(array_merge(self::$strictTags, array('img')), 
																		 array_merge(self::$strictAttrs,    array('src'  , 'alt'   )), 
																		 array_merge(self::$strictAttrVals, array($regexp, '/^.+$/')), 0, 0, 0);
	}
}

?>