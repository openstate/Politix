<?php

require_once('Database.class.php');

/*
	Class: PgDatabase
	Manages a connection with a PostgreSQL database.

	Most methods here are just implementations of specific functionality, so no documentation
	is given. See the <Database> class for relevant information.
*/
class PgDatabase extends Database {
	/*
		Property: $connection
		Holds the link to the database connection
	*/
	protected $connection;

	public function __construct($user, $pass, $dbname, $host = false) {
		parent::__construct($user, $pass, $dbname, $host);
		$this->connection = pg_connect(($host ? 'host=\''.$host.'\' ' : '').'user=\''.$user.'\' password=\''.$pass.'\' dbname=\''.$dbname.'\'');

		if ($this->connection === false) {
			throw new DatabaseException('Unable to connect to the database.');
		}
	}

	protected function escape($value, $type) {
		switch ($type) {
			case self::STRING: return '\''.pg_escape_string($value).'\'';
			case self::HEX:    return '\''.pg_escape_bytea($value).'\'';
			default: return parent::escape($value, $type);
		}
	}

	protected function executeQuery($query) {
		$result = @pg_query($this->connection, $query);
		if (!$result)
			return pg_last_error($this->connection);
		else
			return new PgDatabaseResult($result);
	}

	/*
		Method: doPrepareQuery
		Prepares a query for execution.

		Postgres' prepared query format uses *$n* as argument placeholders. n is the index of the parameter starting at 1.
		(e.g. insert into table ($1, $2)).
	*/
	protected function doPrepareQuery($name, $query) {
		$result = @pg_prepare($this->connection, $name, $query);
		if (!$result)
			return pg_last_error($this->connection);
		else
			return true;
	}

	protected function executePreparedQuery($name, $args) {
		$result = @pg_execute($this->connection, $name, $args);
		if (!$result)
			return pg_last_error($this->connection);
		else
			return new PgDatabaseResult($result);
	}

	public function getSerialVal($table, $column) {
		return $this->query('SELECT currval(pg_get_serial_sequence(\''.$table.'\', \''.$column.'\'))')->fetchCell();
	}
}

class PgDatabaseResult extends DatabaseResult {
	protected $fieldTables = null, $fieldNames;

	public function __destruct() {
		pg_free_result($this->query);
	}

	public function fetchCell() {
		return @pg_fetch_result($this->query, 0, 0);
	}

	public function fetchRow() {
		return @pg_fetch_assoc($this->query);
	}

	protected function initFieldNames() {
		if ($this->fieldTables) return;

		for ($i = 0; $i <pg_num_fields($this->query); $i++) {
			$this->fieldTables[$i] = pg_field_table($this->query, $i);
			$this->fieldNames[$i]  = pg_field_name($this->query, $i);
		}
	}

	public function fetchRowByTable() {
		$this->initFieldNames();
		$row = @pg_fetch_row($this->query);
		if (!$row)
			return false;
		$result = array();
		foreach ($row as $col => $value) {
			$result[$this->fieldTables[$col]][$this->fieldNames[$col]] = $value;
		}

		return $result;
	}

	protected function fetchAssoc() {
		return pg_fetch_all($this->query);
	}

	protected function fetchFirstColumn() {
		return pg_fetch_all_columns($this->query, 0);
	}

	public function affectedRows() {
		return pg_affected_rows($this->query);
	}

	public function numRows() {
		return pg_num_rows($this->query);
	}
}

?>