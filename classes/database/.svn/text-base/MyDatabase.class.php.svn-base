<?php

require_once('Database.class.php');

/*
	Class: MyDatabase
	Manages a connection with a MySQL database.

	Most methods here are just implementations of specific functionality, so no documentation
	is given. See the <Database> class for relevant information.
*/
class MyDatabase extends Database {
	/*
		Property: $connection
		Holds the link to the database connection
	*/
	protected $connection;

	public function __construct($user, $pass, $dbname, $host = false) {
		$this->connection = mysql_connect($host, $user, $pass, true);

		$failure = ($this->connection === false) || (mysql_select_db($dbname, $this->connection) === false);
		if ($failure)
			throw new DatabaseException('Unable to connect to the database.');

		$this->query('SET NAMES utf8');
	}

	protected function escape($value, $type) {
		switch ($type) {
			case self::STRING: return '\''.mysql_real_escape_string($value, $this->connection).'\'';
			case self::HEX:    return 'x\''.bin2hex($value).'\'';
			default: return parent::escape($value, $type);
		}
	}

	protected function executeQuery($query) {
		$result = @mysql_query($query, $this->connection);
		if (!$result)
			return mysql_error($this->connection);
		else
			return new MyDatabaseResult($result);
	}

	protected function doPrepareQuery($name, $query) {
		throw new DatabaseException('Prepared queries not supported in MySQL database.');
	}

	protected function executePreparedQuery($name, $args) {
		throw new DatabaseException('Prepared queries not supported in MySQL database.');
	}

	public function getSerialVal($table, $column) {
		return mysql_insert_id($this->connection);
	}
}

class MyDatabaseResult extends DatabaseResult {
	public function __destruct() {
		if (is_resource($this->query)) {
			mysql_free_result($this->query);
		}
	}

	public function fetchCell() {
		$row = @mysql_fetch_row($this->query);
		if ($row)
			return reset($row);
		else
			return false;
	}

	public function fetchRow() {
		return @mysql_fetch_assoc($this->query);
	}

	protected function fetchAssoc() {
		$result = array();
		while ($row = mysql_fetch_assoc($this->query))
			$result[]= $row;
		return $result;
	}

	public function affectedRows() {
		return mysql_affected_rows();
	}

	public function numRows() {
		return mysql_num_rows($this->query);
	}
}

?>