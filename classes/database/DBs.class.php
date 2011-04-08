<?php
// File: DBs

require_once('MyDatabase.class.php');
require_once('PgDatabase.class.php');

/*
	Class: DBs
	Manages the configuration for multiple DB connections.

	In order to have the database links easily available, we have this class. It is essentially
	a global namespace that has a function to return a database class with a connection to a
	specific database. Database instances are reused if possible.

	Configuration of the available databases is done via an included file which should return
	an array of available database connections. The keys of this array of configurations should
	match whatever values are given to the <inst> method.

	Each of these configuration entries is an associative array with the following keys:

	type - The type of the database. Currently, must be one of *mysql* or *pgsql*.
	host - The host where the database resides
	user - The username used to connect to the database
	pass - The password used to connect to the database
	database - The name of the database to use within the connection.
*/
class DBs {
	// Constant: SYSTEM
	// The link to the System database.
	const SYSTEM = 0;

	// Property: $dbinfo
	// Contains host, username and password information of the databases.
	private static $dbinfo;

	// Property: $instances
	// Holds the <Database> instances
	private static $instances = array();

	// Property: $classes
	// Indicates which classes are used to manage which types in the database info array
	private static $classes = array(
		'mysql' => 'MyDatabase',
		'pgsql' => 'PgDatabase'
	);

	/*
		Method: inst
		Returns a database class to a certain connection.

		Parameters:
		$id - The identifier to a database connection. Normally, this is one of the link constants
		      defined in this class.

		Returns:
		An instance of a <Database> class for the given link.
	*/
	public static function inst($id) {
		if (!isset(self::$dbinfo[$id]))
			throw new DatabaseException('Unknown database identifier');
		if (!isset(self::$instances[$id]))
			self::$instances[$id] = new self::$classes[self::$dbinfo[$id]['type']](
				self::$dbinfo[$id]['user'],
				self::$dbinfo[$id]['pass'],
				self::$dbinfo[$id]['database'],
				self::$dbinfo[$id]['host']);
		return self::$instances[$id];
	}

	/*
		Method: loadDBInfo
		Load the private database information.
		It is assumed that the configuration resides in a file 'database.private.php' which is
		available within the include path.
	*/
	public static function loadDBInfo() {
		self::$dbinfo = require('database.private.php');
	}
}

DBs::loadDBInfo();

?>