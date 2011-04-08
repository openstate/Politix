<?php


/**
* Handles Sites.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class SiteModel {

	/** DB table name containing all categories. */
	const TABLE_NAME = 'sys_site';
	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'sys_site_id_seq';


	protected $id;
	protected $name;
	protected $key;

	protected $schema;
	protected $db;


	/**
	 * Construct new unresolved site.
	 *
	 * @param string $name site name
	 */
	public function __construct($name) {
		$this->id = null;
		$this->name = $name;
		$this->key = self::stem($name);

		$this->schema = null;
		$this->db = null;
	}


	/**
	 * Resolve this object.
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param SiteModelSchema $schema the parent schema
	 * @param PDO $db database link
	 * @param integer $id row id
	 * @param array $levels level description
	 */
	public function resolve(SiteModelSchema $schema, $db, $id) {
		$this->schema = $schema;
		$this->db = $db;

		if($id === null) {
			if(defined('DRY_RUN')) die("Before inserting new site: ".$this->name);

			$log = JLogger::getLogger('utils.import.schema.site');
			$log->preUpdate("Inserting new site '{$this->name}'");
			$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.' (title) VALUES(:title);');
			$ins->execute(array(
				':title' => $this->name,
			));

			if($ins->rowCount() != 1) throw new RuntimeException("Can't insert new site: {$this->name}");

			if(self::ID_SEQUENCE) $this->id = $this->db->lastInsertId(self::ID_SEQUENCE);
			else $this->id = $this->db->lastInsertId();

			$log->postUpdate("Successfully inserted new site '{$this->name}' as id: {$this->id}");
			unset($ins);
		} else  $this->id = $id;
	}


	/**
	 * Returns record ID of this site.
	 * @return integer
	 */
	public function getId() {
		if($this->id === null) throw new RuntimeException("Site '{$this->name}' is not yet resolved!");
		return $this->id;
	}

	/**
	 * Returns <tt>SiteModelSchema</tt>.
	 * @return SiteModelSchema
	 */
	public function getSchema() {
		if($this->schema == null) throw new RuntimeException("Site '{$this->name}' is not yet resolved");
		return $this->schema;
	}

	/**
	 * Returns site name.
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns stemmed site name.
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