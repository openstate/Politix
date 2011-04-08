<?php
// File: Databases

// == Exceptions thrown by the database class and related classes ==

/*
	Class: DatabaseException
	The database class will throw only this exception or descendants of it to make them
	easy to detect. Does not add any special logic, it's just a rename of the Exception
	class.
*/
class DatabaseException extends Exception { }

/*
	Class: DatabaseQueryException
	Thrown when a query fails. Contains extra information on the query and why it failed.
*/
class DatabaseQueryException extends DatabaseException {
	protected $sql, $error;

	/*
		Constructor: __construct
		Construct a new exception.

		Parameters:
		$message - The message of the exception, this is the same as for normal exceptions.
		$error   - The error message returned by the database.
		$sql     - The query that caused the error.
	*/
	public function __construct($message = '', $error = '', $sql = '') {
		parent::__construct($message);
		$this->sql = $sql;
		$this->error = $error;
	}

	/*
		Method: getSQL
		Returns the SQL query that caused this exception.
	*/
	public function getSQL() { return $this->sql; }
	/*
		Method: getError
		Returns the error message of the database.
	*/
	public function getError() { return $this->error; }

	/*
		Method: __toString
		Formats the exception into a string, incorporates the DB error message and the SQL query.
	*/
	public function __toString() {
		return parent::__toString().'<br />Error message: '.$this->error.'<br />SQL: '.$this->sql;
	}
}


/*
  Class: Database
  Manages a connection with the database. This is an abstract class which must be extended
	to provide the connection specifics.
 */
abstract class Database {
	/*
		Property: $queryArray
		Holds a list of all the queries executed on this database connection.
	*/
	protected $queryArray = array();

	// Group: Escape types

	/*
		Constant: INT
		Specifies that a variable should be escaped as an integer
	*/
	const INT    = 0;
	/*
		Constant: FLOAT
		Specifies that a variable should be escaped as a floating point number
	*/
	const FLOAT  = 1;
	/*
		Constant: BOOL
		Specifies that a variable should be escaped as a boolean
	*/
	const BOOL   = 2;
	/*
		Constant: STRING
		Specifies that a variable should be escaped as a string
	*/
	const STRING = 3;
	/*
		Constant: HEX
		Specifies that a variable should be escaped as a sequence of byte data
	*/
	const HEX    = 4;

	/*
		Constructor: __construct
		Creates a new database.

		Parameters:
		$user   - Username for the connection
		$pass   - Password for the connection
		$dbname - Database to connect to
		$host   - The hostname to connect to. If this value is *false*, it will use UNIX sockets to
		          make the connection instead of a TCP/IP socket, which reduces overhead.
							Depending on the database implementation, using false for this parameter may not
							be possible.
	*/
	public function __construct($user, $pass, $dbname, $host = false) {}

	public function __destruct() {}

	/*
		Group: Formatting functions
	*/

	/*
		Method: escape
		Escapes a single value according to a given type.

		This function should be able to escape values according to the <Escape types> specified
		in this class. This base class is only able to escape ints, floats and booleans, so
		actual implementations should override this class to provide the other escape types.

		Parameters:
		$value - The value to escape. This function may assume that it only has to do the actual
		         escaping, the given value will be of the given type. (e.g., when escaping an
						 integer, the value won't be a string).
		$type	 - The type to escape the value as.

		Returns:
		The escaped value, ready to use in a query.
	*/
	protected function escape($value, $type) {
		switch ($type) {
			case self::INT:    return $value;
			case self::FLOAT:  return $value;
			case self::BOOL:   return (int)$value;
			case self::STRING: throw new Exception('Base database can\'t escape strings');
			case self::HEX:    throw new Exception('Base database can\'t escape hex');
		}
	}

	/*
		Method: formatSql
		Formats sql query strings. It functions similarly to php's fprintf.

		This method itself is protected, so unusable externally. Other query functions of
		the database class use it to format queries passed to them though, and it makes the
		most sense to explain the formatting method here.

		Parameters:
		$sql    - The query to format, including format specifiers
		$params - An array with the values to substitute for the format specifiers in the query string.
		          Functions that call this method tend not to have an array for this, instead they
		          just use any parameters given after the query, to mimick fprintf's behaviour.

		Returns:
		The query string formatted with the parameters.

		Format specifiers:
		Formatting is done by giving the character *%* in the query string. Each of these characters maps
		one parameter in order. If you just give a %, the type of the parameter will determine how to
		format the value. Types supported by this formatting routine are: integer, float, boolean, string
		and the null value. Other types will throw an exception. It is also possible to force the type
		of the parameter by giving an extra character after the %. All characters available for this are:

		i - Formats as an integer
		f - Formats as a float
		b - Formats as a boolean
		s - Formats as a string
		x - Formats as a byte array, generally for inserting BLOBs.
		l - Inserts the parameter literally - *be careful with this*.
		% - Inserts a literal %.

		Any other characters are ignored. If an explicit type is given, the value will be typecast so it
		is safe to format as that value.

		If you want to alter the order of parameter processing, or want to use the same parameter multiple
		times, you can give a number directly after the %. This argument number will then be used (counting
		from 1). Specifiers which do not give a number afterwards will count from the last specified
		argument. There must be at least a parameter for every specifier.
	*/
	protected function formatSql($sql, $params) {
		$prev = 0;     // Last position at which we encountered a %
		$newsql = '';  // The result of this function
		$argIdx = 0;   // Index of the next argument to insert

		while (($pos=strpos($sql, '%', $prev)) !== false) {
			// There is a % character present in the formatting string
			$newsql .= substr($sql, $prev, $pos-$prev);
			$prev = $pos + 1;
			if ($prev < strlen($sql) && $sql[$prev]=='%') {
				// If we have a %%, insert a literal % and continue.
				$newsql .= '%';
				$prev++;
				continue;
			}
			if (preg_match('/^[0-9]+/', substr($sql, $prev), $match)) {
				// A specific argument index was given
				$prev+= strlen($match[0]);
				$argIdx = ((int)$match[0])-1;
			}

			// Check if the arugment to substitute is actually available
			if (array_key_exists($argIdx, $params))
				$param = $params[$argIdx];
			else
				throw new DatabaseException('No parameter available for argument '.($argIdx+1));
			$argIdx++;

			$escaped = true;
			if ($prev < strlen($sql)) {
				if ($param === null && strpos('ifbsxl', $sql[$prev]) !== false)
					$prev++; // Do not escape a null, we do that at a later point.
				else switch ($sql[$prev]) {
					// Handle explicit escape types
					case 'i': $param = $this->escape((int)$param,     self::INT);    $prev++; break;
					case 'f': $param = $this->escape((float)$param,   self::FLOAT);  $prev++; break;
					case 'b': $param = $this->escape((bool)$param,    self::BOOL);   $prev++; break;
					case 's': $param = $this->escape((string)$param,  self::STRING); $prev++; break;
					case 'x': $param = $this->escape((string)$param,  self::HEX);    $prev++; break;
					case 'l':                                                        $prev++; break;
					default: $escaped = false;
				}
			} else
				$escaped = false;
			if (!$escaped) {
				// Automatic type-based escaping
				if      (is_integer($param)) $param = $this->escape((int)$param,     self::INT);
				else if (is_float($param))   $param = $this->escape((float)$param,   self::FLOAT);
				else if (is_bool($param))    $param = $this->escape((bool)$param,    self::BOOL);
				else if (is_string($param))  $param = $this->escape((string)$param,  self::STRING);
				else if ($param !== null)
					throw new DatabaseException('Unsupported parameter for argument '.$argIdx.': '.gettype($param));
			}

			// Escape the null value
			if ($param === null)
				$newsql.= 'NULL';
			else
				$newsql.= $param;
		}
		$newsql.= substr($sql, $prev);
		return $newsql;
	}

	/*
		Method: formatQuery
		Formats an sql query.

		Parameters:
		$query - The query to format. See <formatSql> for a description of the formatting string.
		...    - Any remaining parameters will be used as arguments to format into the query.

		Returns:
		The formatted query.
	*/
	public function formatQuery($query) {
		$args = func_get_args();
		return $this->formatSql($query, array_slice($args, 1));
	}

	/*
		Group: Query functions
	*/


	/*
		Method: executeQuery
		Actually executes a given SQL query.
		This method is used internally to call the implementation-dependent query function.

		Parameter:
		$query - The query to execute.

		Returns:
		A <DatabaseResult> class with the result of the query, or a string with an error message if
		the query failed.
	*/
	abstract protected function executeQuery($query);

	/*
		Method: doPrepareQuery
		Prepares a given query
		This method is called internally to wrap the implementation-specific query preparation function.

		Parameters:
		$name  - The name under which to prepare the query.
		$query - The query to prepare.
	*/
	abstract protected function doPrepareQuery($name, $query);

	/*
		Method: executePreparedQuery
		Executes a previously prepared query
		This method is called internally to wrap the implementation-specific prepared query execution function.

		Parameters:
		$name - The name of the previously prepared query.
		$args - The arguments to execute the query with.
	*/
	abstract protected function executePreparedQuery($name, $args);

	/*
		Method: query
		Executes a direct sql query.

		Parameters:
		$query - The query to format. See <formatSql> for the format specifiers.
		         Multiple statements currently cannot be used, since MySQL does not support this natively.
		...    - Any remaining parameters will be used as arguments to format into the query.

		Returns:
		A <DatabaseResult> class representing the result of the query.
	*/
	public function query($query) {
		$args = func_get_args();
		if (count($args)>1)
			$sql = $this->formatSql($query, array_slice($args, 1));
		else
			$sql = $query;

		$start = microtime(true);
		$result = $this->executeQuery($sql);
		$end = microtime(true);
		$this->queryArray[]= array($sql, $end-$start);

		if (is_string($result))
			throw new DatabaseQueryException('An error occured while executing a query.', $result, $sql);

		return $result;
	}

	/*
		Method: prepareQuery
		Prepares a query for execution.

		Parameters:
		$query - The query string to prepare. This may only contain one single SQL statement.

		Note that the method to specify the parameter arguments is implementation-specific, and tends to
		differ from the way they are specified in <formatSql>. See the implementation-specific subclasses
		for details, or check the relevant database's documentation.

		Returns:
		An identifier to the prepared query that can be used to execute it later.
	*/
	public function prepareQuery($query) {
		// Create random statement name
		$name = md5(microtime().$query);

		$start = microtime(true);
		$result = $this->doPrepareQuery($name, $query);
		$end = microtime(true);
		$this->queryArray[]= array($query.' -- prepared as '.$name, $end-$start);

		if ($result !== true)
			throw new DatabaseQueryException('An error occured while preparing a query.', $result, $query);

		return $name;
	}

	/*
		Method: executePrepared
		Executes a previously prepared query.

		Parameters:
		$name - The identifier of the prepared query.
		...   - Any remaining parameters will be used as arguments for the query.

		Returns:
		A <DatabaseResult> class representing the result of the query.
	*/
	public function executePrepared($name) {
		$args = array_slice(func_get_args(), 1);
		$start = microtime(true);
		$result = $this->executePreparedQuery($name, $args);
		$end = microtime(true);
		$this->queryArray[]= array('Prepared query '.$name.' with args '.implode(', ', $args), $end-$start);

		if (is_string($result))
			throw new DatabaseQueryException('An error occured while executing a prepared query.', $result,
				'Prepared query '.$name.' with args '.implode(', ', $args));

		return $result;
	}

	/*
		Method: getSerialVal
		Returns the last returned value of a serial column of a table.

		This function can be used to get the insert id.

		Parameters:
		$table  - The name of the table.
		$column - The name of the serial column.

		Returns:
		The serial value.
	*/
	abstract public function getSerialVal($table, $column);

	/*
		Method: getLastQuery
		Returns the most recently executed queries

		Parameters:
		$count - The number of queries to return. If -1 is given, all queries executed on this database
		         will be returned.
	*/
	public function getLastQuery($count = 1) {
		if ($count==-1)
			return $this->queryArray;
		else
			return array_slice($this->queryArray, -$count);
	}
}

/*
	Class: DatabaseResult
  Contains a result of a database query and gives functionality to query its results.
*/
abstract class DatabaseResult {
	/*
		Property: $query
		Holds the query result handle.
	*/
	protected $query;

	public function __construct($result) {
		$this->query = $result;
	}

	/*
		Method: fetchCell
		Fetches the value in the first column of the first row of the result.
	*/
	abstract public function fetchCell();

	/*
		Method: fetchRow
		Fetches the current row of the result as an associative array, then increments the row pointer.

		Returns:
		The row if there is still a result, or *false* if there are no more results.
	*/
	abstract public function fetchRow();

	/*
		Method: fetchAssoc
		Fetches all rows in the result set as associative arrays.
		This is an internal function for the implementation-specific fetch function. It is
		used by <fetchAllRows>.
	*/
	abstract protected function fetchAssoc();

	/*
		Method: fetchFirstColumn
		Fetches the first column for all rows in the result set.
		This is an internal function used by <fetchAllCells>. Normally it simply uses <fetchAssoc>
		and extracts the first columns from that result, but if the specific database implementation
		supports a direct function for this, children can override this method.
	*/
	protected function fetchFirstColumn() {
		$ar = $this->fetchAssoc();
		array_walk($ar, array($this, 'makeCell'));
		return $ar;
	}

	/*
		Method: fetchAllRows
		Fetches all rows in the result set. The returned rows are associative arrays.

		Parameters:
		$index - Gives the column name that the results should be indexed by.
		         If given, the key of each row will be this value. Exceptions
		         will be thrown if this column does not exist or has duplicate
		         entries.
		         If false, the keys will have no special meaning.
		$group - Groups by the given column name. The result will be an associative
		         array with the keys being the values of this column, and the values
		         an array of the rows. Throws an exception if the column does not
		         exist. Can be combined with $index.
	*/
	public function fetchAllRows($index = false, $group = false) {
		if ($this->numRows()==0)
			return array();
		else {
			$qresult = $this->fetchAssoc();

			$firstRow = reset($qresult);
			if ($group && !isset($firstRow[$group]))
				throw new DatabaseException('Grouping column does not exist: '.$group);
			if ($index && !isset($firstRow[$index]))
				throw new DatabaseException('Indexing column does not exist: '.$index);

			if ($group) {
				$result = array();
				foreach ($qresult as $key => $row) {
					if ($index) {
						if (isset($result[$row[$group]][$row[$index]]))
							throw new DatabaseException('Duplicate index for key '.$row[$index]);
						$result[$row[$group]][$row[$index]] = $row;
					} else
						$result[$row[$group]][$key] = $row;
				}

				return $result;
			}

			if ($index) {
				$result = array();
				foreach ($qresult as $row) {
					if (isset($result[$row[$index]]))
						throw new DatabaseException('Duplicate index for key '.$row[$index]);
					$result[$row[$index]] = $row;
				}

				return $result;
			}

			return $qresult;
		}
	}

	/*
		Method: makeCell
		An internal function to extract the first column from rows.
		Used by <fetchAllCells>
	*/
	private function makeCell(&$el, $key) {
		$el = reset($el);
	}

	/*
		Method: fetchAllCells
		Fetches the first column of all rows in the result set. Otherwise functions the
		same as <fetchAllRows>.

		Parameters:
		$index - Indicates if the result array should be indexed.
		$group - Indicates if the result array should be grouped.
	*/
	public function fetchAllCells($index = false, $group = false) {
		if (!$index && !$group)
			return $this->fetchFirstColumn();
		else {
			$result = $this->fetchAllRows($index, $group);
			if ($group) {
				foreach ($result as &$r) {
					array_walk($r, array($this, 'makeCell'));
				}
			} else
				array_walk($result, array($this, 'makeCell'));
			return $result;
		}
	}

	/*
		Method: affectedRows
		Returns the number of rows changed by this query.
	*/
	abstract public function affectedRows();

	/*
	  Method: numRows
	  Returns the number of rows in the result set of this query
	*/
	abstract public function numRows();
}

?>