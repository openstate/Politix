<?php

/* Exception that is thrown when an object is added that is of the wrong type */
class WrongClassException extends Exception {}

/* Exception that is thrown when an object is added with an id that is already used in the list */
class IdAlreadyExistsException extends Exception {}

/* Exception that is thrown when an id is accesed that doesnt exist */
class IdDoesntExistException extends Exception {}


/* List Object
  This object holds a list of objects of similar type.
  During construction a classname is given to the list. All objects added to the list have to be of this class or else an exception is thrown
 */
class ObjectList implements Countable, Iterator {
	protected $list = array();	// stores the objects contained in this list
	protected $className;  		// classname of the objects contained in this list

	protected $current = 0;		// needed for iterator implementation
	protected $keys = array();	// needed for iterator implementation

	// constructor. $className is the classname of the objects that are going to be put in this list
	public function __construct($className) {
		$this->className = $className;
		$this->list = array();
	}

	// add. $obj is the object to be added to the list. $id is the identifier for that object.
	public function add($obj, $id = false) {
		if ($obj instanceof $this->className) {
			if (isset($this->list[$id]) && $id !== false) {
				throw new IdAlreadyExistsException();
			}
			if ($id === false)
				$this->list[] = $obj;
			else
				$this->list[$id] = $obj;
			$this->keys = array_keys($this->list);
		} else {
			throw new WrongClassException();
		}
	}

	// delete. $id is the identifier of the object to be deleted
	public function delete($id) {
		if (!isset($this->list[$id])) {
			throw new IdDoesntExistException;
		}
		unset($this->list[$id]);
		$this->keys = array_keys($this->list);
	}

	// get.
	public function get($id) {
		if (isset($this->list[$id])) {
			return $this->list[$id];
		} else {
			throw new Exception(get_class().'::get called for non-existant id (\''.$id.'\')');
		}
	}

	// exists.
	public function exists($id) {
		return isset($this->list[$id]);
	}

	// ask the className of the objects in this list
	public function getClassName() {
		return $this->className;
	}

	// countable implementation
	public function count() {
		return count($this->list);
	}

	// iterator implementation
	public function current() {
		if (isset($this->list[$this->keys[$this->current]]))
			return $this->list[$this->keys[$this->current]];
	}

	public function key() {
		if(isset($this->keys[$this->current]))
			return $this->keys[$this->current];
		else
			return null;
	}

	public function next() {
		$this->current++;
	}

	public function rewind() {
		$this->current = 0;
	}

	public function valid() {
		return isset($this->keys[$this->current]);
	}
}

?>