<?php


/**
* Handles tags.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class TagModel {

	/** DB table name containing all tags. */
	const TABLE_NAME = 'sys_tags';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'sys_tags_id_seq';


	protected $id;
	protected $name;

	protected $schema;
	protected $db;


	/**
	 * Construct new unresolved tag.
	 *
	 * @param string $name tag name
	 */
	public function __construct($name) {
		$this->id = null;
		$this->name = $name;
		$this->key = self::stem($name);
	}


	/**
	 * Resolve this object.
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param TagModelSchema $schema the parent schema
	 * @param PDO $db database link
	 * @param integer $id row id
	 */
	public function resolve(TagModelSchema $schema, $db, $id) {
		$this->schema = $schema;
		$this->db = $db;

		if($id === null) {
			$log = JLogger::getLogger('utils.import.schema.tag');
			if(defined('DRY_RUN')) die("Before inserting new tag: ".$this->name);

			$log->preUpdate("Inserting new tag: {$this->name}");
			$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.' (name) VALUES(:name);');
			$ins->execute(array( ':name' => $this->name ));

			if($ins->rowCount() != 1) throw new RuntimeException("Can't insert new tag: {$this->name}");

			if(self::ID_SEQUENCE) $this->id = $this->db->lastInsertId(self::ID_SEQUENCE);
			else $this->id = $this->db->lastInsertId();

			$log->postUpdate("Successfully inserted new tag '{$this->name}' as id: {$this->id}");
			unset($ins);
		} else  $this->id = $id;
	}


	/**
	 * Returns record ID of this tag.
	 * @return integer
	 */
	public function getId() {
		if($this->id === null) throw new RuntimeException("Tag '{$this->name}' is not yet resolved!");
		return $this->id;
	}

	/**
	 * Returns <tt>TagModelSchema</tt>.
	 * @return TagModelSchema
	 */
	public function getSchema() {
		if($this->schema == null) throw new RuntimeException("Tag '{$this->name}' is not yet resolved");
		return $this->schema;
	}

	/**
	 * Returns tag name.
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns stemmed tag name.
	 * @return string
	 */
	public function getKey() {
		return $this->key;
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
}


?>