<?php

$backoffice = array(
		'sets'       => array('admin', 'shared'),
		'modules'    => array('secure', 'crumbs', 'dbpages', 'user'),
		'title'      => 'Wat Stemt Mijn Raad Backoffice',
		'template'   => 'backoffice.html',
		'publicdir'  => 'backoffice',
		'systemMail' => 'no-reply@politix.nl',

		'locale' => array(
			'source'   => array('cookie', 'browser'),
			'locales'  => array('nl'),
			'defaults' => array(
				'/\.nl$/'     => 'nl',
				'/\.gl$/'     => 'nl',
				'/\.dev(elop)?$/'    => 'nl',
			)
		)
	);

$frontoffice = array(
		'sets'       => array('watstemtmijnraad', 'shared'),
		'modules'    => array('search', 'default', 'crumbs', 'dbpages', 'user', 'ajax', 'xml'),
		'title'      => 'Politix',
		'template'   => 'watstemtmijnraad.html',
		'publicdir'  => 'watstemtmijnraad',
		'systemMail' => 'no-reply@politix.nl',

		'locale' => array(
			'source'   => array('cookie'),
			'locales'  => array('nl'),
			'defaults' => array(
				'/\.nl$/'    => 'nl',
				'/\.gl$/'    => 'nl',
				'/\.dev(elop)?$/'   => 'nl',
			)
		)
	);

return array(
	'/^(?P<subdomain>backoffice)\.(?P<domain>politix)\.(?P<tld>[^.]+)$/' => $backoffice,
	'/^(?P<subdomain>backoffice)\.(?P<domain>politix)(?:\.nl)?\.accepte(project|live)\.(?P<tld>[^.]+)$/' => $backoffice,
	'/^(?P<subdomain>([^\.]*))?\.?(?P<domain>politix)\.(?P<tld>[^.]+)$/' => $frontoffice,
	'/^(?P<subdomain>([^\.]*))?\.?(?P<domain>politix)(?:\.nl)?\.accepte(project|live)\.(?P<tld>[^.]+)$/' => $frontoffice,
);

?>
