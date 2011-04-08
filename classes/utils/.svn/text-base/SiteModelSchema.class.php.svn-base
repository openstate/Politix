<?php

require_once('JLogger.class.php');
require_once('SiteModel.class.php');
require_once('NotFoundException.class.php');


/**
* Handles site set.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class SiteModelSchema {

	/** site index by stemmed name */
	private $sites = array();
	/** site index by id */
	private $id_index = array();

	/** @var PDO */
	private $db;
	private $global_schema;


	/**
	 * Load category schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 * @param ModelSchema $global_schema the global schema
	 */
	public function __construct($db, ModelSchema $global_schema) {
		$this->db = $db;
		$this->global_schema = $global_schema;

		$log = JLogger::getLogger('utils.import.schema.site');
		$log->enter("Fetching whole site schema.");

		$log->preSelect("Fetching all sites.");
		$ret = $this->db->query('SELECT * FROM '.SiteModel::TABLE_NAME);
		$ret->setFetchMode(PDO::FETCH_ASSOC);

		$i = 0;
  		foreach ($ret as $row) {
			$cat = new SiteModel($row['title']);
  			$cat->resolve($this, $this->db, $row['id']);

			$this->id_index[$cat->getId()] = $cat;
			$this->sites[$cat->getKey()] = $cat;

			$i += 1;
  		}

  		$log->leave("Fetched {$i} sites.");
	}

	/**
	 * Returns site by name.
	 *
	 * @throws NotFoundException if such site is not found
	 * @param string $name name of the category
	 * @return SiteModel
	 */
	public function getSite($name) {
		$key = SiteModel::stem($name);

		if(!isset($this->sites[$key])) throw new NotFoundException("Site named '{$name}' is not found!");
		else return $this->sites[$key];
	}


	/**
	 * Returns site by id.
	 *
	 * @throws NotFoundException if site with such id is not found
	 * @param integer $id category id
	 * @return SiteModel
	 */
	public function lookup($id) {
		if(!isset($this->id_index[$id])) {
			$log = JLogger::getLogger('utils.import.schema.site');
			$log->debug("Site by id '{$id}' is not found, performing database lookup.");

			$log->preSelect("Select site by id: {$id}");
			$sel = $this->db->prepare('SELECT * FROM '.SiteModel::TABLE_NAME.' WHERE id = :id');
			$row = $sel->execute(array(':id' => $id))->fetch(PDO::FETCH_ASSOC);

			if(!$row) throw new NotFoundException("Can't find site by id: {$id}");

			$ret = new CategoryModel($row['name'], $row['description']);
			$ret->resolve($this, $this->db, $row['id'], $levdescr);

			$this->id_index[$ret->getId()] = $ret;
			$this->categories[$ret->getKey()] = $ret;

			return $ret;
		}

		return $this->id_index[$id];
	}
}
?>