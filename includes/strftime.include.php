<?php

$GLOBALS['strftimeNames'] = array(
	'nl' => array(
		'fullMonthNames'  => array(1 => 'januari', 'februari', 'maart', 'april', 'mei', 'juni',
		                          'juli', 'augustus', 'september', 'oktober', 'november', 'december'),
		'shortMonthNames' => array(1 => 'jan', 'feb', 'maa', 'apr', 'mei', 'jun',
	                             'jul', 'aug', 'sep', 'okt', 'nov', 'dec'),
		'fullDayNames'    => array('zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag'),
		'shortDayNames'   => array('zo', 'ma', 'di', 'wo', 'do', 'vr', 'za')
	),
	'en' => array(
		'fullMonthNames'  => array(1 => 'January', 'February', 'March', 'April', 'May', 'June',
		                          'July', 'August', 'September', 'October', 'November', 'December'),
		'shortMonthNames' => array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
	                             'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
		'fullDayNames'    => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
		'shortDayNames'   => array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')
	),
	'de' => array(
		'fullMonthNames'  => array(1 => 'Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
		                          'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'),
		'shortMonthNames' => array(1 => 'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun',
	                             'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'),
		'fullDayNames'    => array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'),
		'shortDayNames'   => array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa')
	)
);

$GLOBALS['fullMonthNames'] = array(
	1 => 'januari', 'februari', 'maart', 'april', 'mei', 'juni',
	'juli', 'augustus', 'september', 'oktober', 'november', 'december');
$GLOBALS['shortMonthNames'] = array(
	1 => 'jan', 'feb', 'maa', 'apr', 'mei', 'jun',
	     'jul', 'aug', 'sep', 'okt', 'nov', 'dec');
$GLOBALS['fullDayNames']  = array('zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag');
$GLOBALS['shortDayNames'] = array('zo', 'ma', 'di', 'wo', 'do', 'vr', 'za');

function strftime2($format, $timestamp = false) {
	if ($timestamp === false)
		$timestamp = time();

	$_loc_from = array();
	$_loc_to   = array();
	if (strpos($format, '%B') !== false) {
		$_loc_from[] = '%B';
		$_loc_to[]	 = $GLOBALS['fullMonthNames'][(int)date('n', $timestamp)];
	}
	if (strpos($format, '%b') !== false) {
		$_loc_from[] = '%b';
		$_loc_to[]	 = $GLOBALS['shortMonthNames'][(int)date('n', $timestamp)];
	}
	if (strpos($format, '%A') !== false) {
		$_loc_from[] = '%A';
		$_loc_to[]	 = $GLOBALS['fullDayNames'][(int)date('w', $timestamp)];
	}
	if (strpos($format, '%a') !== false) {
		$_loc_from[] = '%a';
		$_loc_to[]	 = $GLOBALS['shortDayNames'][(int)date('w', $timestamp)];
	}
	return strftime(str_replace($_loc_from, $_loc_to, $format), $timestamp);
}

?>