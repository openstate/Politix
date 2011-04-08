<?php

require_once('NotFoundException.class.php');
require_once('RegionModelSchema.class.php');
require_once('TreeNodeModel.abstract.php');

/**
* Region model.
* Resolves and represents the region tree.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class RegionModel extends TreeNodeModel {

	/** DB table name containing all regions. */
	const TABLE_NAME = 'sys_regions';

	/** used by lastInertId() to retrieve the last inserted ID. null for MySQL */
	const ID_SEQUENCE = 'sys_regions_id_seq';


	/** record id */
	protected $id;

	/** @var RegionModelSchema */
	protected $schema;
	protected $db;

	/**
	 * Contruct new unresolved region.
	 * You should add this object to the region tree to get the actual record id.
	 *
	 * @param string $name name of the region
	 */
	public function __construct($name) {
		parent::__construct($name);
		$this->id = null;
		$this->schema = null;
	}

	/**
	 * Resolve this object.
	 * This method is for internal use only.
	 *
	 * @access package
	 * @param integer $id this object id
	 * @param RegionModelSchema $schema the schema
	 * @param RegionModel $parent parent region
	 * @return void
	 */
	public function resolve($schema, $db, $id, $parent) {
		$this->schema = $schema;
		$this->db = $db;

		parent::resolve($parent);

		if($id === null) { //create self
			if(defined('DRY_RUN')) die("Before inserting new region: ".$this->name);

			$log = JLogger::getLogger('utils.import.schema.region');
			$log->preUpdate("Inserting new region: '{$this->getName()}'");
			$ins = $this->db->prepare('INSERT INTO '.self::TABLE_NAME.' (name, level, parent) VALUES(:name, :level, :parent);');
			$ins->execute(array(
				':name' => $this->name,
				':level' => $this->getLevel(),
				':parent' => $parent? $parent->getId(): null
			));

			if($ins->rowCount() != 1) throw new RuntimeException("Can't insert new region '{$this->name}' ".($parent? "into parent '{$parent->getId()}:{$parent->getName()}'": " as root"));

			if(self::ID_SEQUENCE) $this->id = $this->db->lastInsertId(self::ID_SEQUENCE);
			else $this->id = $this->db->lastInsertId();

			if($log->isEnabled(JLogger::POST_UPDATE)) $log->postUpdate("Successfully inserted new region '{$this->getPath()}' as id: {$this->id}");
			unset($ins);
		} else $this->id = $id;
	}

	/**
	 * Returns ID of this region object.
	 * Method throws exception if this regions is not added to the region tree, wich is part
	 * of the <tt>RegionModelSchema</tt>.
	 *
	 * @throws RuntimeException if this object is not resolved
	 * @return integer region record id
	 */
	public function getId() {
		if($this->id === null) throw new RuntimeException("Region '{$this->name}' is not yet resolved!");
		return $this->id;
	}

	/**
	 * Returns <tt>RegionModelSchema</tt> that handles this region tree.
	 * @return RegionModelSchema
	 */
	public function getSchema() {
		if($this->schema === null) throw new RuntimeException("This region '{$this->name}' is not part of the region tree!");
		return $this->schema;
	}

	/**
	 * Add child region to this region.
	 *
	 * If $path starts with '/' then it will be resolved from the root of the region tree.
	 * If $path is an array then it will be seen as a relative list of path elements.
	 * Any missing region along the path will be created on demand.
	 *
	 * @throws RuntimeException if this region is not part of the resolved region tree
	 * @param RegionModel $region the region to add
	 * @param string|array $path path to the region
	 * @return RegionModel either new region or already defined region object
	 */
	public function addRegion(RegionModel $region, $path = null) {
		if($this->schema === null || $this->id === null) throw new RuntimeException("This region '{$this->name}' is not part of the region tree!");

		$root = false;
		$els = self::parsePath($path, $root);

		if($root) return $this->schema->addRegion($region, $path);
		else { //relative path
			if(empty($els)) {
				if(!isset($this->children[$region->getKey()])) return $this->schema->resolveRegion($region, $this);
				else return $this->children[$region->getKey()];
			} else return $this->getRegion($els)->addRegion($region);
		}
	}

	/**
	 * Returns region by path, creating any missing region along the path.
	 * If $path starts with '/' then it will be resolved from the root of the region tree.
	 * If $path is an array then it will be seen as a relative list of path elements.
	 *
	 * @throws RuntimeException if this region is not part of the resolved region tree or on any other error
	 * @param string|array $path path to the region
	 * @return RegionModel
	 */
	public function getRegion($path) {
		if($this->schema === null || $this->id === null) throw new RuntimeException("This region '{$this->name}' is not part of the region tree!");

		$root = false;
		$names = array();
		$els = self::parsePath($path, $root, false, $names);

		if($root) return $this->schema->getRegion($path);
		else {
			$p = $this;

			foreach ($els as $k => $el) { //recreate on demand
				if(!isset($p->children[$el])) {
					$reg = new RegionModel($names[$k]);
					$this->schema->resolveRegion($reg, $p);
				}
				$p = $p->children[$el];
			}

			return $p;
		}
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
	 * @param DOMElement $root where to 'region' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $el, $options) {
		$me = $dom->createElement('region');
		$me->setAttribute('name', $this->name);
		$el->appendChild($me);


		//check for flat
		if(isset($options['regions.flat']) && $options['regions.flat']) {
			$me->setAttribute('path', $this->parent? $this->parent->getPath(): '/');
		} else {
			if($this->getLevel() == 1) $me->setAttribute('path', '/');

			if(sizeof($this->children) > 0) {
				$el = $dom->createElement('regions');
				$me->appendChild($el);
			}
		}


		foreach ($this->children as $chld) {
			$chld->toXml($dom, $el, $options);
		}
	}
}


?>