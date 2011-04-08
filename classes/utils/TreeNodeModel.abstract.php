<?php


/**
* Generic stemming tree.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
abstract class TreeNodeModel {

	protected $name;
	protected $key;

	protected $level;
	protected $parent;
	protected $children;



	/**
	 * Construct new node.
	 * @param string $name name of the node
	 */
	public function __construct($name) {
		$this->name = $name;
		$this->key = self::stem($name);

		$this->level = -1;
		$this->parent = null;
		$this->children = array();
	}


	/**
	 * Returns original name.
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns stemmed name that is used by parent node as key.
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * Returns parent node.
	 * @return TreeNodeModel null if this is the root node
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * Returns current level starting from 1.
	 * @return integer
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * Returns list of childrens of this node.
	 * @return array of TreeNodeModel
	 */
	public function children() {
		return $this->children;
	}

	/**
	 * Returns child node by name
	 * @param string $name name of the child, will be stemmed first
	 * @return TreeNodeModel null if nothing found
	 */
	public function getChild($name) {
		$key = self::stem($name);
		if(!isset($this->children[$key])) return null;
		else return $this->children[$key];
	}

	/**
	 * Builds absolute string path to this region.
	 * @return string
	 */
	public function getPath() {
		$els = array();
		$p = $this;

		while ($p !== null) {
			$els[] = $p->getName();
			$p = $p->getParent();
		}

		return '/'.implode('/', array_reverse($els));
	}


	/**
	 * Resolve this node.
	 * This method will assign parent, calculate node level and
	 * add self to the childrens of the parent node.
	 *
	 * @param TreeNodeModel $parent parent node, null for the top root node
	 * @return void
	 */
	public function resolve($parent) {
		$this->parent = $parent;

		if($parent) {
			$parent->children[$this->key] = $this;
			$this->level = $parent->getLevel() + 1;
		} else $this->level = 1;
	}


	/**
	 * Stem the given key.
	 *
	 * This method converts the given string to lowercase, trim and replaces
	 * any '[^a-z0-9_]+' sequence by '_'.
	 *
	 * @param string $key key to stem
	 * @return string stemmed string
	 */
	public static function stem($key) {
		return preg_replace('#[^a-z0-9_]+#', '_', strtolower(trim($key)));
	}

	/**
	 * Parses path into path elements.
	 *
	 * Splits $path by '/' character removing any empty path element,
	 * each name along the path will be stemmed.
	 *
	 * If $forceStem is set and $path is an array, then each element
	 * of this array will be stemmed. Otherwise the array will be left untouched.
	 *
	 * @param string $path path to parse
	 * @param boolean $root will be set to true if this path is absolute, false otherwise
	 * @param boolean $forceStem if true, then path will be stemmed even if it is already parsed array of path elements
	 * @param array $names original names from the path will be assigned to this array
	 * @return array list of not empty path elements
	 */
	public static function parsePath($path, &$root, $forceStem = false, &$names = null) {
		if($path === null) { //relative path to current node
			$root = false;
			return array();
		}

		if(is_array($path)) { //already parsed relative path
			$root = false;

			if($forceStem) {
				$names = array_filter(array_map('trim', $path));
				return array_filter(array_map(array('self', 'stem'), $path));
			} else {
				$names = $path;
				return $path;
			}
		}

		if(is_string($path)) { //parse path
			$path = trim($path);
			if(strlen($path) > 0 && $path{0} == '/') { //absolute path
				$root = true;
				if($path == '/') {
					$names = array();
					return array(); //top node
				}
				else $path = substr($path, 1);
			} else $root = false;

			$path = explode('/', $path);
			$names = array_filter(array_map('trim', $path));
			return array_filter(array_map(array('self', 'stem'), $path));
		}

		throw new InvalidArgumentException("Expecting path as either string or array, something wrong is given instead!");
	}
}

?>