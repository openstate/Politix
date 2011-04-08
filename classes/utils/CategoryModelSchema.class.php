<?php

require_once('CategoryModel.class.php');
require_once('NotFoundException.class.php');
require_once('JLogger.class.php');


/**
* Handles category set.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class CategoryModelSchema {

	/** Id of the category object that represents "No category" ("Geen") */
	const NO_CATEGORY_OBJECT = -1;


	/** category index by stemmed name */
	private $categories = array();
	/** category index by id */
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
		$log = JLogger::getLogger('utils.import.schema.category');

		$this->db = $db;
		$this->global_schema = $global_schema;

		$log->enter("Starting with fetch of the whole category schema.");

		$log->preSelect("Fetching all category level registrations.");
		$levs = $this->db->query('SELECT * FROM '.CategoryModel::LEVEL_CAT_TABLE.';');
  		$levs->setFetchMode(PDO::FETCH_ASSOC);

		$levdescr = array();
		foreach ($levs as $lv) $levdescr[$lv['category']][$lv['level']] = $lv['description'];

		$log->preSelect("Fetching all categories");
		$ret = $this->db->query('SELECT * FROM '.CategoryModel::TABLE_NAME);
		$ret->setFetchMode(PDO::FETCH_ASSOC);


  		foreach ($ret as $row) {
			$cat = new CategoryModel($row['name'], $row['description']);

			$lvs = isset($levdescr[$row['id']])? $levdescr[$row['id']]: array();
  			$cat->resolve($this, $this->db, $row['id'], $lvs);
			$this->id_index[$cat->getId()] = $cat;
			$this->categories[$cat->getKey()] = $cat;
  		}

  		$log->leave("Successfully ended fetching category schema.");
	}


	/**
	 * Add/resolve category
	 *
	 * @param CategoryModel $cat
	 * @return CategoryModel either new or already defined category
	 */
	public function addCategory(CategoryModel $cat) {
		if(isset($this->categories[$cat->getKey()])) return $this->categories[$cat->getKey()];

		$log = JLogger::getLogger('utils.import.schema.category');
		$log->debug("Creating new category: {$cat->getName()}");

		$cat->resolve($this, $this->db, null, array());

		$this->id_index[$cat->getId()] = $cat;
		$this->categories[$cat->getKey()] = $cat;
		return $cat;
	}


	/**
	 * Returns category by name.
	 * Method creates category without description on demand.
	 *
	 * @param string $name name of the category
	 * @return CategoryModel
	 */
	public function getCategory($name) {
		$key = CategoryModel::stem($name);

		if(!isset($this->categories[$key])) {
			$log = JLogger::getLogger('utils.import.schema.category');
			$log->debug("Creating new category: {$name}");

			$c = new CategoryModel($name, null);
			$c->resolve($this, $this->db, null, array());
			$this->id_index[$c->getId()] = $c;
			$this->categories[$key] = $c;
		}

		return $this->categories[$key];
	}


	/**
	 * Returns category by id.
	 *
	 * @throws NotFoundException if category with such id is not foun
	 * @param integer $id category id
	 * @return CategoryModel
	 */
	public function lookup($id) {
		if(!isset($this->id_index[$id])) {
			$log = JLogger::getLogger('utils.import.schema.category');
			$log->enter("Database lookup for category id: {$id}");
			$log->preSelect("Fetching category by id: {$id}");

			$sel = $this->db->prepare('SELECT * FROM '.CategoryModel::TABLE_NAME.' WHERE id = :id');
			$row = $sel->execute(array(':id' => $id))->fetch(PDO::FETCH_ASSOC);

			if(!$row) throw new NotFoundException("Can't find category by id: {$id}");

			$log->debug("Category with id '{$id}' is found as '{$row['name']}'.");
			$log->preSelect("Fetching all category dependences for: {$id} - '{$row['name']}'");
			$levs = $this->db->prepare('SELECT * FROM '.CategoryModel::LEVEL_CAT_TABLE.' WHERE category = :category;');
  			$levs->setFetchMode(PDO::FETCH_ASSOC);
  			$levs->execute(array(':category' => $id));

			$levdescr = array();
			foreach ($levs as $lv) $levdescr[$lv['level']] = $lv['description'];

			$ret = new CategoryModel($row['name'], $row['description']);
			$ret->resolve($this, $this->db, $row['id'], $levdescr);

			$this->id_index[$ret->getId()] = $ret;
			$this->categories[$ret->getKey()] = $ret;

			$log->leave("Successfully recovered category '{$ret->getName()}' by id: {$id}");

			return $ret;
		}

		return $this->id_index[$id];
	}


	/**
	 * Serialize this category schema to the DOM tree.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'categories' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options = null) {
		$el = $dom->createElement('categories');
		$root->appendChild($el);

		foreach ($this->categories as $cat) {
			$cat->toXml($dom, $el, $options);
		}
	}

	/**
	 * Read & update schema from XML data.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $node schema node
	 * @return void
	 */
	public function update(SimpleXMLElement $node) {
		$log = JLogger::getLogger('utils.import.schema.category');
		$log->enter("Updating cateogry schema from XML source.");

		foreach ($node ->category as $cat) {
			$c = new CategoryModel((string)$cat['name'], (string)$cat['description']);
			$c = $this->addCategory($c);

			foreach ($cat->inlevel as $lev) $c->registerLevelDescription((int)$lev['level'], (string)$lev['description']);
		}

		$log->leave("Successfully updated category schema from XML source.");
	}
}
?>