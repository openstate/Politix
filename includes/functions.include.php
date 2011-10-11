<?php

function randomString($length) {
	$chars = '';
	for ($i = 'a'; $i < 'z'; $i++) $chars .= $i;
	for ($i = 'A'; $i < 'Z'; $i++) $chars .= $i;
	for ($i = '0'; $i < '9'; $i++) $chars .= $i;

	$result = '';
	for ($i = 0; $i < $length; $i++)
		$result .= $chars[mt_rand(0, strlen($chars) - 1)];

	return $result;
}

function roundComma($number, $digits = 0) {
	return str_replace('.', ',', round($number, $digits));
}

function replaceExternalLinks($content, $from = false) {
	$internalRegex = '!^(https?://([^.]*)\.watstemtmijnraad\.((nl)|(gl)|(dev)))?/!';
	$external = 'http://'.$_SERVER['HTTP_HOST'].'/external/?'.($from ? 'from='.$from.'&amp;' : '').'href=';

	$content = str_replace('<a ', '<a target="_blank" ', $content);

	preg_match_all('/href="([^"]*)"/i', $content, $matches, PREG_SET_ORDER);
	$patterns = array();
	$replaces = array();

	foreach ($matches as $match) {
		if (!preg_match($internalRegex, $match[1])) {
			$patterns[] = $match[0];
			$replaces[] = str_replace('href="', 'href="'.$external, $match[0]);
		}
	}

	return str_replace($patterns, $replaces, $content);
}

function checkdateArray($array) {
	return checkdate($array['month'], $array['day'], $array['year']);
}

function compare($a, $b) {
	if ($a < $b)
		return -1;
	else
		if ($a > $b)
			return 1;
		else
			return 0;
}

function compareDateArray($a, $b) {
	if ($a['year'] == $b['year'])
		if ($a['month'] == $b['month'])
			return compare((int)$a['day'], (int)$b['day']);
		else
			return compare((int)$a['month'], (int)$b['month']);
	else
		return compare((int)$a['year'], (int)$b['year']);
}


function _and($a, $b) {
	return $a && $b;
}

function _or($a, $b) {
	return $a || $b;
}

// lcfirst already exists in PHP 5.3+
if (!function_exists('lcfirst')) {
    function lcfirst($str) {
    	return strtolower(substr($str, 0, 1)) . substr($str, 1);
    }
}

function dump($var) {
	ob_start();
	var_dump($var);
	echo '<pre>'.htmlspecialchars(preg_replace("/\]\=\>\n(\s+)/m", "] => ", ob_get_clean()), ENT_QUOTES).'</pre>';
}

function _id($obj) {
	if ($obj instanceOf Record) return $obj->id;
	elseif (is_int($obj)) return $obj;
	return false;
}

?>
