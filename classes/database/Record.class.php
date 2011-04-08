<?php
// File: Records

/*
	Class: NoSuchRecordException
	Thrown when a specified record does not exist in the database
*/
class NoSuchRecordException extends Exception {}

/*
	Class: NoSuchPropertyException
	The Record class will throw this exception when an attempt is made to access a non-existing property.
*/
class NoSuchPropertyException extends Exception {}

require_once('DBs.class.php');

/*
	Class: Record
	An ActiveRecord implementation for quickly building classes around database records.
*/
class Record {
	// Group: Configuration

	/*
		Property: $id
	  Contains the unique id of this record in the database, or *false* if no such id is assigned yet.
	  Can be read through $obj->id.

	  It is assumed that in the database table the id is stored in a column named 'id'.
	 */
	protected $id = false;

	/*
		Property: $data
		Contains the data of this record, as well as the names of the columns in the record.

		All of the columns available to the user should be present as keys in this record. Their
		values should be the default value for each column.
		These values can be read by and written to via $obj->name, where *name* is any name present
		in the keys of this array.
	*/
	protected $data = array();

	// Property: $tableName
	// Contains the name of the table that this record wraps.
	protected $tableName = '';

	/*
		Property: $nonwritable
		Contains a list of columns in the <$data> array that cannot be written to.
		Use this to protect certain columns.
	*/
	protected $nonwritable = array();

	/*
		Property: $extraCols
		Contains a list of columns that require custom expressions to query.
		This should be an associative array. The keys are names of columns also present in the <$data> array
		that will contain the result. The value is a custom SQL expression that returns the value that should
		be held in the column.

		This is also the only way to request data from tables other than the main table (as given in <$tableName>),
		see <$multiTables>. Columns specified in this property cannot be written to.
	*/
	protected $extraCols = array();

	/*
		Property: $multiTables
		Used to specify that data comes from multiple tables.

		If this property is *false* (the default), only the table in <$tableName> is read. Otherwise, this
		property must hold a complete join statement, including the base table.
	*/
	protected $multiTables = false;

	// Group: General
	/*
		Property: $dirty
		Specifies whether this record was changed since it was last loaded.
	*/
	protected $dirty = true;

	// Property: $db
	// Contains a <Database> instance which is used to load and store the record.
	protected $db;

	/*
		Constructor: __construct
		Creates a new record.
		All record properties are initialized to their default values, as given in <$data>.

		Parameters:
		$id - Which record to load after construction, if this parameter is not *false*.
	*/
	public function __construct($id = false) {
		$this->db = DBs::inst(DBs::SYSTEM);
		if ($id !== false)
			$this->load($id);
	}

	public function __wakeup() {
		$this->db = DBs::inst(DBs::SYSTEM);
	}

	/*
		Method: loadFromArray
		Loads the record from an associative array.

		Parameters:
		$data - The array to load the record from. Only keys present in <$data> will be loaded, the
		        others will be ignored. The record's <$id> will be read from the key named 'id'.
	*/
	protected function loadFromArray(array $data) {
		$this->id = $data['id'];
		$this->data = array_merge($this->data, array_intersect_key($data, $this->data));
		$this->dirty = false;
	}

	/*
		Method: getParts
		Internal function used to create the column and from part of the select statement.

		Returns:
		An array in which the key 'extra' is a part of the select statement that comes right after
		'SELECT *', and 'tables' is the part that comes directly after 'FROM'.
	*/
	protected function getParts() {
		$extra = '';
		foreach ($this->extraCols as $colName => $select)
			$extra.= ', '.$select.' AS '.$colName;

		if ($this->multiTables)
			$tables = $this->multiTables;
		else
			$tables = $this->tableName.' t';

		return array('extra' => $extra, 'tables' => $tables);
	}

	/*
		Method: exists
		Checks whether a record with a certain id exists.

		Parameters:
		$id - The id to check existence for.

		Returns:
		*true* if a record with the given id exists, *false* otherwise.
	*/
	public function exists($id) {
		$parts = $this->getParts();
		return (bool)$this->db->query('SELECT 1 FROM '.$parts['tables'].' WHERE t.id=%', $id)->fetchCell();
	}

	/*
		Method: refresh
		Reloads the current record from the database.
	*/
	public function refresh() {
		if ($this->id)
			$this->load($this->id);
	}

	/*
		Method: load
		Loads a specific record from the database.

		Parameters:
		$id - The id of the record to load.
	*/
	public function load($id) {
		$parts = $this->getParts();
		$row = $this->db->query('SELECT t.*'.$parts['extra'].' FROM '.$parts['tables'].' WHERE t.id=%', $id)->fetchRow();
		if ($row) {
			$this->loadFromArray($row);
		} else
			throw new NoSuchRecordException('Attempted to load a non-existant '.get_class($this).' (id '.$id.')');
	}

	/*
		Method: getFilter
		Returns an expression which can be used to filter lists of this record.

		Parameters:
		$column - The column name to filter on
		$value  - The value to filter on. This value is matched via a like '%...%'.

		Returns:
		A string with the expression.
	*/
	public function getFilter($column, $value) {
		if (isset($this->extraCols[$column]))
			$result = $this->extraCols[$column];
		else
			$result = 't."'.$column.'"';

		$result.= ' ILIKE '.$this->db->formatQuery('%', '%'.preg_replace('/[%\\\\]/', '\\\\$0', $value).'%');
		return $result;
	}

	/*
		Method: getList
		Returns a list of records.

		Parameters:
		$join  - Extra JOIN statements to add in the list query, or an empty string.
		$where - A WHERE statement (including the keyword) to filter the result, or an empty string.
		$order - An ORDER BY statement (including the keyword) to order the result by, or an empty string.
		$limit - A LIMIT statement (including the keyword) to limit the result by, or an empty string.

		Result:
		An associative array of record ids to instances of this record.
	*/
	public function getList($join = '', $where = '', $order = '', $limit = '') {
		$parts = $this->getParts();

		$rows = $this->db->query('SELECT t.*'.$parts['extra'].' FROM '.$parts['tables'].' '.$join.' '.$where.' '.$order.' '.$limit)->fetchAllRows();

		$result = array();
		$class = get_class($this);
		foreach ($rows as $row) {
			$obj = new $class();
			$obj->loadFromArray($row);
			$result[$obj->id]= $obj;
		}

		return $result;
	}

	/*
		Method: getCount
		Returns the number of records of this type

		Parameters:
		$join  - Extra JOIN statements to add in the list query, or an empty string.
		$where - A WHERE statement (including the keyword) to filter the result, or an empty string.

		Returns:
		The number of records that were counted.
	*/
	public function getCount($join = '', $where = '') {
		$parts = $this->getParts();
		return $this->db->query('SELECT COUNT(*) FROM '.$parts['tables'].' '.$join.' '.$where)->fetchCell();
	}

	/*
		Method: save
		Saves the current record to the database.

		The record will be saved only if the record is modified (see <$dirty>). If no id has been assigned
		yet (i.e., this is a new record), it will be inserted into the database, and <$id> will be set to
		the newly assigned id. If it was already saved, the record will be updated.
	*/
	public function save() {
		if (!$this->dirty) return;

		$data = array_diff_key($this->data, $this->extraCols);

		if (!$this->id) {
			$keys = array();
			$fields = array();
			foreach ($data as $key => $val) {
				$keys[]= $key;
				$fields[]= $this->db->formatQuery('%', $val);
			}

			$this->db->query('INSERT INTO '.$this->tableName.' ("%l") VALUES (%l)', implode('","', $keys), implode(',', $fields));
			if (isset($data['id'])) {
				$this->id = $data['id'];
			} else {
				$this->id = $this->db->getSerialVal($this->tableName, 'id');
			}
		} else {
			$fields = array();
			foreach ($data as $key => $val)
				$fields[]= $this->db->formatQuery('"'.$key.'" = %', $val);

			$this->db->query('UPDATE '.$this->tableName.' SET %l WHERE id=%', implode(',', $fields), $this->id);
		}
		$this->dirty = false;
	}

	/*
		Method: delete
		Deletes a record from the database

		Parameters:
		$id - The id of the record to delete. If this is *false*, the record currently held in the instance
		      will be deleted.
	*/
	public function delete($id = false) {
		if (!$id)
			$id = $this->id;
		if (!$id)
			throw new Exception('No record given to delete.');
		$this->db->query('DELETE FROM '.$this->tableName.' WHERE id=%', $id);
	}

	/*
		Method: hasProperty
		Checks if this class has a property named "$name".

		Parameters:
		$name - The name of the property to check for.

		Returns:
		true if the property exists, false if it does not.
	*/
	public function hasProperty($name) {
		return array_key_exists($name, $this->data);
	}

	public function getTableName() {
		return $this->tableName;
	}

	public function __set($name, $value) {
		if ($this->hasProperty($name)) {
			if ($name=='id')
				throw new Exception('Attempting to write to a record id.');
			if (in_array($name, $this->nonwritable) or isset($this->extraCols[$name]))
				throw new Exception('Attempting to write to read-only property '.get_class($this).'::$'.$name);
			$this->data[$name] = $value;
			$this->dirty = true;
		} else
			throw new NoSuchPropertyException('Undefined property: '.get_class($this).'::$'.$name);
	}

	public function __get($name) {
		if ($name=='id') {
			return $this->id;
		} else if ($this->hasProperty($name)) {
			return $this->data[$name];
		} else {
			throw new NoSuchPropertyException('Undefined property: '.get_class($this).'::$'.$name);
		}
	}

	public function __sleep() {
		return array('id', 'data');
	}
}

?>
