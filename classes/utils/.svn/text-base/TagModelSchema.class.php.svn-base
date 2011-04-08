<?php

require_once('TagModel.class.php');
require_once('NotFoundException.class.php');


/**
* Handles category set.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class TagModelSchema {

	/** tag index by stemmed name */
	private $tags = array();
	/** tag index by id */
	private $id_index = array();

	/** @var PDO */
	private $db;
	private $global_schema;


	/**
	 * Load tag schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 * @param ModelSchema $global_schema the global schema
	 */
	public function __construct($db, ModelSchema $global_schema) {
		$this->db = $db;
		$this->global_schema = $global_schema;


		$log = JLogger::getLogger('utils.import.schema.tag');
		$log->enter("Fetching whole tag schema.");

		$log->preSelect("Fetching all tags.");
		$tags = $this->db->query('SELECT * FROM '.TagModel::TABLE_NAME.';');
  		$tags->setFetchMode(PDO::FETCH_ASSOC);

  		$i = 0;
  		foreach ($tags as $row) {
			$tag = new TagModel($row['name']);
  			$tag->resolve($this, $this->db, $row['id']);

			$this->id_index[$tag->getId()] = $tag;
			$this->tags[$tag->getKey()] = $tag;

			$i += 1;
  		}

  		$log->leave("Fetched {$i} tags.");
	}


	/**
	 * Add/resolve categtagry
	 *
	 * @param TagModel $tag
	 * @return TagModel either new or already defined tag
	 */
	public function addTag(TagModel $tag) {
		if(isset($this->tags[$tag->getKey()])) return $this->tags[$tag->getKey()];

		$log = JLogger::getLogger('utils.import.schema.tag');
		$log->debug("Creating new tag: {$tag->getName()}");
		$tag->resolve($this, $this->db, null);

		$this->id_index[$tag->getId()] = $tag;
		$this->tags[$tag->getKey()] = $tag;
		return $tag;
	}


	/**
	 * Returns tag by name.
	 * Method creates tag without description on demand.
	 *
	 * @param string $name name of the tag
	 * @return TagModel
	 */
	public function getTag($name) {
		$key = TagModel::stem($name);
		if(!isset($this->tags[$key])) {
			$c = new TagModel($name);

			$log = JLogger::getLogger('utils.import.schema.tag');
			$log->debug("Tag is not found, creating new tag: {$tag->getName()}");
			$c->resolve($this, $this->db, null);
			$this->id_index[$c->getId()] = $c;
			$this->tags[$key] = $c;
		}

		return $this->tags[$key];
	}


	/**
	 * Returns tag by id.
	 *
	 * @throws NotFoundException if tag with such id is not found
	 * @param integer $id tag id
	 * @return TagModel
	 */
	public function lookup($id) {
		if(!isset($this->id_index[$id])) {
			$log = JLogger::getLogger('utils.import.schema.tag');
			$log->debug("Tag by id '{$id}' is not found, performing database lookup.");

			$log->preSelect("Select tag by id: {$id}");
			$sel = $this->db->prepare('SELECT * FROM '.TagModel::TABLE_NAME.' WHERE id = :id');
			$row = $sel->execute(array(':id' => $id))->fetch(PDO::FETCH_ASSOC);

			if(!$row) throw new NotFoundException("Can't find tag by id: {$id}");

			$ret = new TagModel($row['name']);
			$ret->resolve($this, $this->db, $row['id']);

			$this->id_index[$ret->getId()] = $ret;
			$this->tags[$ret->getKey()] = $ret;

			return $ret;
		}

		return $this->id_index[$id];
	}
}
?>