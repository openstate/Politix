<?php

function encodeHtml($html) {
	return htmlentities($html[0], ENT_COMPAT, 'UTF-8');
}

function sanitizeTable($html) {
	$matches = array();

	$class = null;
	if (preg_match('/class=[\'"][a-zA-Z0-9]*[\'"]/', $html, $matches)) {
		$class = $matches[0];
	}

	$border = null;
	if (preg_match('/border=[\'"]([0-9]*)[\'"]/', $html, $matches)) {
		$border = $matches[1];
	}

	if ($border !== null) {
		if ($border === '0')
			$class = 'class="noborder"';
		else
			$class = null;
	}

	if ($class === null)
		return '<table>';

	return '<table ' . $class . '>';
}

function stripAttribs($html) {
	var_dump($html);
	if (substr(strtolower($html[0]), 0, 2) == '<a') {
		// Filter out javascript: links
		$html[0] = preg_replace('/\bhref=([\'"])javascript:.*?\1/s', '', $html[0]);
	}
	if (substr(strtolower($html[0]), 0, 6) == '<table') {
		$html[0] = sanitizeTable($html[0]);
	}
	return preg_replace('/\bon[a-z]+\s*=\s*(["\']).*?\1/is', '', $html[0]);
}

function safeHtml($html) {
	// entity encode script, object & embed tags.
	$html = preg_replace_callback('!<(script|object|embed)[^>]*>.*?</\1>!s', 'encodeHtml', $html);
	// Remove potentially dangerous attributes: all those starting with 'on'
	$html = preg_replace_callback('!<[a-zA-Z]+\s+([a-zA-Z]+(\s*=\s*(["\']).*?\3\s*)?)+>!s', 'stripAttribs', $html);
	return $html;
}

?>
