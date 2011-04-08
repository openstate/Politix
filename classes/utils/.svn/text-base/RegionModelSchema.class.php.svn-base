<?php

require_once('NotFoundException.class.php');
require_once('RegionModel.class.php');


/**
* Handles region tree.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class RegionModelSchema {

	/** Default path used to resolve relative paths */
	const DEFAULT_PATH = '/Europa/Nederland';


	/** root regions */
	private $root_regions = array();
	/** default '/Europa/Nederland' region */
	private $relative_root_region = null;
	/** id lookup table */
	private $id_index = array();

	/** @var PDO */
	private $db;
	private $global_schema;


	/**
	 * Load region schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 * @param ModelSchema $global_schema the global schema
	 */
	public function __construct($db, ModelSchema $global_schema) {
		$this->db = $db;
		$this->global_schema = $global_schema;

		$log = JLogger::getLogger('utils.import.schema.region');
		$log->enter("Fetching whole region schema.");

		$log->preSelect("Fetching all regions.");
		$ret = $this->db->query('SELECT * FROM '.RegionModel::TABLE_NAME);
		$ret->setFetchMode(PDO::FETCH_ASSOC);

		$regions = array();
		foreach ($ret as $row) $regions[$row['id']] = $row;
		$i = sizeof($regions);

		$this->loadFromArray($regions);

		unset($ret);
		unset($regions);

		$log->leave("Fetched {$i} regions.");
	}

	/**
	 * Returns global schema.
	 * @return ModelSchema
	 */
	public function getGlobalSchema() {
		return $this->global_schema;
	}

	/**
	 * Loads region tree from the database record collection.
	 * This method clears any previous obtained region info.
	 *
	 * @throws RuntimeException on any database error
	 * @param array $regions (id => array) list of rows, each row contains keys ('id', 'parent' and 'name')
	 * @return void
	 */
	protected function loadFromArray($regions) {
		$resolved = array();
		$this->root_regions = array();
		$this->relative_root_region = null;

		while(!empty($regions)) {
			$reg = array_pop($regions);
			$this->resolveFromArray($reg, $regions, $resolved);
		}

		unset($resolved);

		$this->relative_root_region = $this->getRegion(self::DEFAULT_PATH);
	}

	/**
	 * Recursively rebuild the tree from the flat list (db record collection)
	 *
	 * @throws RuntimeException on any database error
	 * @param array $row record data containing keys ('id', 'parent' and 'name')
	 * @param array $regions (id => array) list of rows
	 * @param array $resolved (id => RegionModel) resolved regions
	 * @return void
	 */
	private function resolveFromArray($row, &$regions, &$resolved) {
		if($row['parent'] != '') { //find the parent
			if(!isset($resolved[$row['parent']])) {
				if(!isset($regions[$row['parent']])) throw new InvalidArgumentException("Parent region id '{$row['parent']}' for '{$row['name']}' is not found! Database is inconsistent!");
				$par = $regions[$row['parent']];
				unset($regions[$row['parent']]); //detect recursive loops

				$this->resolveFromArray($par, $regions, $resolved);
			}

			$reg = new RegionModel($row['name']);
			$reg->resolve($this, $this->db, $row['id'], $resolved[$row['parent']]);
			$resolved[$row['id']] = $reg;
		} else { //top root
			$reg = new RegionModel($row['name']);
			$reg->resolve($this, $this->db, $row['id'], null);
			$resolved[$row['id']] = $reg;
			$this->root_regions[$reg->getKey()] = $reg;
		}

		$this->id_index[$reg->getId()] = $reg;
	}


	/**
	 * Resolve (create) this region.
	 * This method is for internal use only!
	 *
	 * @access package
	 * @param RegionModel $reg region to resolve
	 * @param RegionModel|null $parent parent region
	 * @return RegionModel resolved region
	 */
	public function resolveRegion(RegionModel $reg, $parent) {
		$reg->resolve($this, $this->db, null, $parent);
		$this->id_index[$reg->getId()] = $reg;
		return $reg;
	}

	/**
	 * Returns region by id.
	 *
	 * @throws NotFoundException if region is not found
	 * @param integer $id
	 * @return RegionModel
	 */
	public function lookup($id) {
		if(!isset($this->id_index[$id])) { //lookup DB
			$log = JLogger::getLogger('utils.import.schema.region');
			$log->debug("Region by id '{$id}' is not found, performing database lookup.");

			$log->preSelect("Select region by id: {$id}");
			$sel = $this->db->prepare('SELECT * FROM '.RegionModel::TABLE_NAME.' WHERE id = :id;');
			$sel->execute(array(':id' => $id));

			$row = $sel->fetch(PDO::FETCH_ASSOC);
			if(!$row) throw new NotFoundException("The region for id: '{$id}' is not found!");

			$region = new RegionModel($row['name']);
			if($row['parent'] !== null) {
				$parent = $this->lookup($row['parent']);
				$region->resolve($this, $this->db, $row['id'], $parent);
			} else {
				$region->resolve($this, $this->db, $row['id'], null);
				$this->root_regions[$region->getKey()] = $region;
			}

			return ($this->id_index[$row[$id]] = $region);
		}

		return $this->id_index[$id];
	}


	/**
	 * Add region to the schema.
	 *
	 * Relative path will be resolved from the DEFAULT_PATH.
	 *
	 * @see RegionModel.addRegion()
	 * @param RegionModel $region the region to add
     * @param string|array $path '/' separated path or list of path elements
	 * @return RegionModel either new or already defined region object
	 */
	public function addRegion(RegionModel $region, $path = null) {
		//if path attribute is missing by Europa, fix creatin /Europa/Nederland/Europa...
		if($path == '' && $region->getKey() == 'europa') $path = '/';
		if($path == '' && $region->getKey() == 'nederland') $path = '/Europa';

		if(is_string($path) && $path == '/') {
			if(!isset($this->root_regions[$region->getKey()])) {
				$region->resolve($this, $this->db, null, null);
				$this->root_regions[$region->getKey()] = $region;
				$this->id_index[$region->getId()] = $region;
			}

			return $this->root_regions[$region->getKey()];
		} else return $this->getRegion($path)->addRegion($region);
	}


	/**
	 * Returns region by path, creating any missing region along the path.
	 * Relative path will be resolved from the DEFAULT_PATH.
	 *
	 * @param string|array $path path to the region
	 * @return RegionModel
	 */
	public function getRegion($path) {
		$root = false;
		$names = array();
		$els = RegionModel::parsePath($path, $root, false, $names);

		if($root) {
			$name = array_shift($names);
			$el = array_shift($els);
			if(!isset($this->root_regions[$el])) { //insert new
				$reg = new RegionModel($name);
				$reg->resolve($this, $this->db, null, null);
				$this->root_regions[$el] = $reg;
				$this->id_index[$reg->getId()] = $reg;
			}

			return $this->root_regions[$el]->getRegion(implode('/', $names));
		} else return $this->relative_root_region->getRegion($path);
	}


	/**
	 * Serialize this schema to the DOM tree.
	 *
	 * Method checks the 'regions.flat' option, if present then:
	 *
	 *   true  - serialize tree to a flat 'region' list with 'path' attributes
	 *   false - (default) - serialize tree to a 'region.regions' tree structure
	 *
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'regions' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options = null) {
		$el = $dom->createElement('regions');
		$root->appendChild($el);

		foreach ($this->root_regions as $reg) {
			$reg->toXml($dom, $el, $options);
		}
	}


	/**
	 * Read & update schema from XML data.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $node schema node
	 * @return void
	 */
	public function update(SimpleXMLElement $node, $cont = null) {
		if($cont == null) $cont = $this;

		foreach ($node->region as $reg) {
			$r = new RegionModel((string)$reg['name']);
			$r = $cont->addRegion($r, (string)$reg['path']);

			foreach ($reg->regions as $rgs) $this->update($rgs, $r);
		}
	}
}
?>