<?php
/**
* Light weight prequel script for CLI scripts.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/

//single namespace/package is a bad thing...
if($_SERVER['DOCUMENT_ROOT'] == '') $_SERVER['DOCUMENT_ROOT'] = '.';
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



/**
* Returns (singleton) PDO connection to watstemtmijnraad.nl.
* You may need this function if you preffer PDO instead of DBs.
*
* Note: PDO will be in exception mode.
*
* @return PDO pdo connection
*/
function getPDOConnection() {
	static $pdo = null;

	if($pdo == null) {
		$inf = require('database.private.php');
		$inf = $inf[DBs::SYSTEM];

		$config = array(
			'port' => 5432,
			'host' => $inf['host'],
			'user' => $inf['user'],
			'password' => $inf['pass'],
			'database' => $inf['database']
		);

		$pdo = new PDO("pgsql:host={$config['host']} port={$config['port']} dbname={$config['database']}", $config['user'], $config['password']);
		//$pdo->query("SET NAMES 'utf8'"); //[XXX: needed for MySQL 5.x on my machine, comment out if causes problems ]
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	return $pdo;
}
?>