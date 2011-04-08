<?php
	// Start output buffering
	ob_start();

	// Set include path
	set_include_path(
		implode(PATH_SEPARATOR, array(
			get_include_path(),
			$_SERVER['DOCUMENT_ROOT'].'/../classes/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/database/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/smarty/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/records/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/user/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/email/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/exceptions/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/graph/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/utils/',
			$_SERVER['DOCUMENT_ROOT'].'/../classes/logger/',
			$_SERVER['DOCUMENT_ROOT'].'/../modules/',
			$_SERVER['DOCUMENT_ROOT'].'/../includes/',
			$_SERVER['DOCUMENT_ROOT'].'/../privates/',
			$_SERVER['DOCUMENT_ROOT'].'/editor/',
		))
	);

	// Include global settings
	require_once('settings.include.php');

	// Include private settings
	require_once('settings.private.php');

	// Include default classes
	require_once('DBs.class.php');
	require_once('Session.class.php');
//	require_once('ErrorHandler.class.php');
//	$handler = new ErrorHandler();

	// Improved strftime
	require_once('strftime.include.php');

	// Extra functions
	require_once('functions.include.php');
	require_once('formlib.php');

	// Include objects that can be stored in a session
	require_once('User.class.php');
	require_once('UserFactory.class.php'); // Should include any custom user classes
	require_once('Message.class.php');

	// This class has to be included before the session
	require_once('SearchResult.class.php');

	// Backoffice user roles
	require_once('BOUserRolePolitician.class.php');
	require_once('BOUserRoleSecretary.class.php');
	require_once('BOUserRoleClerk.class.php');

  define('NEG_INFINITY', '-infinity');
  define('POS_INFINITY', 'infinity');

	define('CACHE_LIFETIME', 300);
	// Start session
	Session::start();
?>
