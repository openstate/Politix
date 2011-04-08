<?php
// File: Session

/*
	Class: Session
	Provides custom session handling for storage in a database.
*/
class Session {
	/*
		Property: $database
		Instance of the <Database> class pointing to the database with the session table.
	*/
	private static $db;

	// Group: Functions
	/*
		Constructor: __construct
		Creates a new Session object.

		The database handle will be instantiated and the appropriate session handlers will be set.
	*/
	public static function init() {
		self::$db = DBs::inst(DBs::SYSTEM);

		session_set_save_handler(
			array('Session', 'open'),
			array('Session', 'close'),
			array('Session', 'read'),
			array('Session', 'write'),
			array('Session', 'destroy'),
			array('Session', 'gc'));
	}

	/*
		Method: write_close
		Write and close the current session.
	*/
	public static function write_close() {
		@session_write_close();
	}

	/*
		Method: start
		Start/resume the current session.
	*/
	public static function start() {
		session_start();
	}

	// Group: Callback Functions
	/*
		Method: open
		Opens the session.
	*/
	public static function open() {
		return true;
	}

	/*
		Method: close
		Closes the session.
	*/
	public static function close() {
		return true;
	}

	/*
		Method: read
		Reads session data from the database.
	*/
	public static function read($id) {
		return pg_unescape_bytea(self::$db->query('SELECT data FROM sys_sessions WHERE id = %', $id)->fetchCell());
	}

	/*
		Method: write
		Inserts the session into the database or updates the existing entry.
	*/
	public static function write($id, $data) {
		self::$db->query('BEGIN');
		if (self::$db->query('SELECT id FROM sys_sessions WHERE id = % FOR UPDATE', $id)->fetchCell())
			self::$db->query('UPDATE sys_sessions SET data = %x, created = now() WHERE id = %', $data, $id);
		else
			self::$db->query('INSERT INTO sys_sessions (id, data) VALUES (%, %x)', $id, $data);
		self::$db->query('COMMIT');
		return true;
	}

	/*
		Method: destroy
		Deletes the session from the database.
	*/
	public static function destroy($id) {
		self::$db->query('DELETE FROM sys_sessions WHERE id = %', $id);
		return true;
	}

	/*
		Method: gc
		Deletes old sessions from the database.
	*/
	public static function gc($maxLifetime) {
		self::$db->query('DELETE FROM sys_sessions WHERE (now() - created) > interval \'% second\'', $maxLifetime);
		return true;
	}
}

Session::init();

?>