<?php
/**
* File contains the package of classes used to import politix database into watstemtmijnraad.nl database.
*
* @category utils
* @author Sardar Yumatov <ja.doma@gmail.com>
*
* @PHP5Only
*/



interface ImportTableLog {

}



/**
* Reads the politix table schema and mappings.
*
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTableSchema {

	/** @var array (column => paty key) */
	private $parties;

	/** @var array  (name => PolitixTableMap) */
	private $maps;

	/** Source table name */
	private $source_table;

	/** Create new empty schema. */
	public function __construct($souce_table) {
		$this->source_table = $souce_table;
		$this->parties = array();
		$this->maps = array();
	}


	/**
	 * Initialize the schema from given $xml.
	 *
	 * This method expects XML of the following structure:
	 *
	 *   politix[
	 * 		table                  -- source table name
	 *   ] ->
	 *       parties ->
	 *              party[
	 *                  column     -- the column name in politix table
	 *                  keyname    -- the key for 'party' map, used to link the party
	 *              ]
	 *
	 *       maps ->
	 *              map[
	 * 					name       -- name of the map ('party', 'category' etc)
	 *                 ,table      -- table tame where in
	 *                 ,sequence   -- sequence name in 'table'
	 *                 ,link_table -- many-to-many relation table
	 *                 ,depends    -- comma separated list of map names where this map depend of
	 *                 ,type       -- mapping type 'simple', 'list', 'party' or 'politician'
	 *              ] ->
	 * 					list[
	 *                     key     -- cell value from politix table
	 *                  ] ->
	 *                      mapval[
	 *                         name   -- the corresponding object name (eg. category name etc) in watstemtmijnraad.nl
	 *                         id     -- optional, corresponding id. if set, then will not be resolved dynamically.
	 *                         *      -- other data that may be required by specific maps
	 *                      ]
	 *              OR
	 * 					mapval[
	 *                      key    -- cell value from politix table
	 *                      name   -- the corresponding object name (eg. category name etc) in watstemtmijnraad.nl
	 *                      id     -- optional, corresponding id. if set, then will not be resolved dynamically.
	 *                      *      -- other data that may be required by specific maps
	 *                  ]
	 *
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $xml the parsed schema file
	 * @return PolitixTableSchema new schema
	 */
	public static function fromXml(SimpleXMLElement $xml) {
		$ret = new self($xml['table']);
		$ret->source_table = (string)$xml['table'];

		foreach($xml->parties->party as $party)
			$ret->addParty((string)$party['column'], (string)$party['keyname']);

		foreach($xml->maps->map as $map) $ret->addMap(PolitixTableMap::fromXml($map));

		return $ret;
	}


	/** Returns source table name. */
	public function getSourceTable() {
		return $this->source_table;
	}

	/**
	 * Returns all maps.
	 * @return array list of (name => PolitixTableMapping) pairs
	 */
	public function listMaps() {
		return $this->maps;
	}

	/**
	 * Returns map for (column) name.
	 *
	 * @throws RuntimeException if mapping is not found
	 * @param string $name name of the map (usually a column in target table)
	 * @return PolitixTableMap associated map
	 */
	public function getMap($name) {
		if(!isset($this->maps[$name])) throw new RuntimeException("Map for '{$name}' is not defined!");
		return $this->maps[$name];
	}


	/**
	 * Add new map.
	 * If a map with equal name already exists, then notice will be raised and old one will be replaced.
	 * @param PolitixTableMap $map the map to add
	 * @return void
	 */
	public function addMap(PolitixTableMap $map) {
		if(isset($this->maps[$map->name])) trigger_error("Map named '{$map->name}' already exists!", E_USER_NOTICE);
		$this->maps[$map->name] = $map;
	}


	/**
	 * Returns all parties defined in the source table.
	 * @return array list of (column_name => pary_map_key) pairs
	 */
	public function listParties() {
		return $this->parties;
	}

	/**
	 * Add party column.
	 * @param string $column the column name in the source table
	 * @param string $keyname the key in the party map, if not set, then column name is used
	 * @return void
	 */
	public function addParty($column, $keyname = null) {
		$this->parties[$column] = $keyname;
	}

	/**
	 * Resolve this schema.
	 * @throws RuntimeException on any error
	 * @param PolitixTableImport $import the data to import
	 * @return void
	 */
	public function resolve(PolitixTableImport $import) {
		$deps = array();
		foreach ($this->maps as $map) $deps[$map->name] = $map->listDependencies();

		//order by dependency
		$resolving = array();
		$resolve_order = array();
		//trace dependencies
		foreach (array_keys($deps) as $name) $this->depSort($name, $deps, $resolving, $resolve_order);

		//resolve in order
		foreach (array_keys($resolve_order) as $map) $this->maps[$map]->resolve($import, $this);
	}

	/** Resolve dependencies recursively */
	private function depSort($name, $deps, &$resolving, &$order) {
		if(isset($order[$name])) return;



		if(!array_key_exists($name, $deps)) throw new RuntimeException("Dependency resolve: map named '{$name}' is not defined!");

		$maps = $deps[$name];
		if(empty($maps)) $order[$name] = true;
		else {
			if(isset($resolving[$name])) throw new RuntimeException("Recursive dependency detected, resolving: {$name}!");
			else $resolving[$name] = true;

			foreach($maps as $mp) $this->depSort($mp, $deps, $resolving, $order);

			$order[$name] = true;
			unset($resolving[$name]);
		}
	}

	/**
	 * Serialize contents of this schema into a DOM structure.
	 * @param DOMDocument $dom the DOM document
	 * @param DOMElement $node the root node where in 'parties' and 'maps' nodes will be placed.
	 * @return void
	 */
	public function dumpToXml($dom, $node) {
		$node->setAttribute('table', $this->source_table);

		//parties
		$part = $dom->createElement('parties');
		foreach ($this->parties as $col => $key) {
			$pn = $dom->createElement('party');
			$pn->setAttribute('column', $col);
			$pn->setAttribute('keyname', $key);
			$part->appendChild($pn);
		}
		$node->appendChild($part);

		//maps
		$maps = $dom->createElement('maps');
		foreach ($this->maps as $map) $map->dumpToXml($dom, $maps);
		$node->appendChild($maps);
	}
}


/**
* Contains mappping of specific field value to watstemtmijnraad.nl alternative.
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTableMap {

	/** Type of this map */
	protected $type;
	/** Name of this map */
	protected $name;
	/** Target table */
	protected $table;
	/** Sequence of target table (PostgresSQL specific) */
	protected $sequence;
	/** list of map names where this map depends from */
	protected $dependencies;

	private $mapping;
	private $resolved;



	/**
	 * Construct new map.
	 *
	 * The $type of the map can be:
	 *   'simple' - each mapping is a simple PolitixTableMapping object
	 *   'list'   - each mapping is  list of PolitixTableMapping object
	 *   'party'  - each mapping is a PolitixTablePartyMapping object
	 *   'politician'-- each mapping is a PolitixTablePoliticianMapping object
	 *
	 * @param string $type the type of this map
	 * @param string $name name of the map (usually column name in target table)
	 * @param string $table name of the target db table, there in the new records will be inserted
	 * @param string $sequence name of the sequence (for lastInsertId)
	 * @param string $dependencies list of map names where this map depends from
	 */
	public function __construct($type, $name, $table, $sequence = null, $dependencies = null) {
		$this->type = $type;
		$this->name = $name;
		$this->table = $table;
		$this->sequence = $sequence;
		$this->dependencies = $dependencies;

		$this->mapping = array();
		$this->resolved = false;
	}

	/**
	 * Construct new map from XML schema file.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $xml the schema data, "map" tag
	 * @return PolitixTableMap new map
	 */
	public static function fromXml(SimpleXMLElement $xml) {
		if(isset($xml['depends'])) $dep = array_map('trim', explode(',', (string)$xml['depends']));
		else $dep = null;

		$ret = new self((string)$xml['type'], (string)$xml['name'], (string)$xml['table'], (string)$xml['sequence'], $dep);

		switch ((string)$xml['type']) {
			case 'simple': foreach($xml->mapval as $mp) $ret->addMapping(PolitixTableMapping::fromXml($mp)); break;

			case 'list':   foreach ($xml->list as $list) {
						   		$key = (string)$list['key'];
								$ls = array();
								foreach ($list->mapval as $mp) $ls[] = PolitixTableMapping::fromXml($mp, $key);
								$ret->addMapping($key, $ls);
						   }

						   break;

			case 'party':  foreach ($xml->mapval as $mp) $ret->addMapping(PolitixTablePartyMapping::fromXml($mp)); break;

			case 'politician': foreach ($xml->mapval as $mp) $ret->addMapping(PolitixTablePoliticianMapping::fromXml($mp)); break;

			default:
					throw new RuntimeException("Unknown map type: '{$xml['type']}'");
		}

		return $ret;
	}

	/**
	 * Map given $value to mapping info.
	 *
	 * @throws RuntimeException if mapping is not found or is not resolved.
	 * @param mixed $value the value to map
	 * @return PolitixTableMapping|array single mapping or [PolitixTableMapping]
	 */
	public function map($value) {
		if(!$this->resolved) throw new RuntimeException("Mapping '{$this->name}' is not resolved!");
		if(!isset($this->mapping[$value])) throw new RuntimeException("Mapping for key '{$value}' is not defined!");
		return $this->mapping[$value];
	}

	/**
	 * Returns all mappings.
	 * @return array list of (key => mapping) pairs
	 */
	public function listMappings() {
		return $this->mapping;
	}

	/**
	 * Add new mapping.
	 *
	 * If mapping is not resolved, then the whole map will become in not resolved state.
	 * The $map can be either PolitixTableMapping if simple mapping is being added or
	 * a string representing the key. If $map is a string, then $list is required and should
	 * be the list of PolitixTableMapping objects.
	 *
	 * @param PolitixTableMapping|string $map
	 * @param array $list list of PolitixTableMapping for list mappings
	 * @return void
	 */
	public function addMapping($map, $list = null) {
		if($map instanceof PolitixTableMapping) {
			if($this->type == 'list') throw new InvalidArgumentException("Can't add non-list mapping to map of type list!");
			if(isset($this->mapping[$map->key])) trigger_error("Mapping '{$map->key}' => '{$map->name}' already exists. Overwriting.", E_USER_NOTICE);
			$this->mapping[$map->key] = $map;
			$this->resolved &= $map->isResolved();
		} else {
			if($this->type != 'list') throw new InvalidArgumentException("Can't add list mapping to map of non-list type!");
			$this->mapping[$map] = $list;
			foreach ($list as $m) $this->resolved &= $m->isResolved();
		}
	}

	/**
	 * Returns list of map names where this map depends from.
	 * @return array list of strings
	 */
	public function listDependencies() {
		return $this->dependencies;
	}

	/**
	 * Add new dependency.
	 * @param string $dep map name where this map depends from
	 * @return void
	 */
	public function addDependency($dep) {
		$this->dependencies[] = $dep;
	}

	/** Read only access to public fields. */
	public function __get($name) {
		if(isset($this->$name)) return $this->$name;
		trigger_error("Property '{$name}' is not defined.", E_USER_NOTICE);
		return null;
	}

	/** Discards any changes. */
	public function __set($name, $value) {
		trigger_error("Property '{$name}' is read-only. Discarding '{$value}'", E_USER_NOTICE);
	}

	/**
	 * Ensure all mappings are present.
	 *
	 * @throws RuntimeException on any error
	 * @param PolitixTableImport $import the data to import
	 * @param PolitixTableSchema $schema the table schema
	 * @return void
	 */
	public function resolve(PolitixTableImport $import, PolitixTableSchema $schema) {
		$import->message(PolitixTableImport::BEGIN, "Resolving map '{$this->name}' in table '{$this->table}'.");

		if($this->type == 'list') {
			foreach ($this->mapping as $map) {
				foreach ($map as $m) $m->resolve($this, $import, $schema);
			}
		} else foreach ($this->mapping as $map) $map->resolve($this, $import, $schema);

		$import->message(PolitixTableImport::SUCCESS, "Successful resolved map '{$this->name}' in table '{$this->table}'.");
		$this->resolved = true;
	}

	/**
	 * Dump this map to DOM tree.
	 *
	 * @param DOMDocument $dom the target document
	 * @param DOMElement $maps the parent 'maps' element where in 'map' elements will be added
	 * @return DOMElement created 'map' element
	 */
	public function dumpToXml($dom, $maps) {
		$map = $dom->createElement('map');
		$map->setAttribute('name', $this->name);
		$map->setAttribute('table', $this->table);
		$map->setAttribute('sequence', $this->sequence);
		$map->setAttribute('type', $this->type);
		if(!empty($this->dependencies)) $map->setAttribute('depends', implode(',', $this->dependencies));

		if($this->type == 'list') {
			foreach ($this->mapping as $key => $ls) {
				$list = $dom->createElement('list');
				$list->setAttribute('key', $key);
				foreach ($ls as $mapping) $mapping->dumpToXml($dom, $list);
				$map->appendChild($list);
			}
		} else {
			foreach ($this->mapping as $mapping) $mapping->dumpToXml($dom, $map);
		}

		$maps->appendChild($map);

		return $map;
	}
}


/**
* Simple mapping (tags, categories etc).
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTableMapping {
	/** mapping key (source table value) */
	protected $key;
	/** record id, null if not resolved */
	protected $id;
	/** record name (value of 'name' column) */
	protected $name;


	/**
	 * Create new mappping.
	 *
	 * @param string $key the mapping key (source table cell value)
	 * @param string $name name of the record (name column value)
	 * @param integer $id the record id, if null, then mapping will be unresolved
	 */
	public function __construct($key, $name, $id = null) {
		$this->id = "{$id}" == ''? null: intval($id);

		//if("{$key}" == '') throw new RuntimeException("The mapping key is null!");
		$this->key = $key;

		if("{$name}" == '') throw new RuntimeException("The key '{$this->key}' can't be mapped, foreign value (name) is not set!");
		$this->name = $name;
	}


	/**
	 * Create new mapping.
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $data the mapping data
	 * @return PolitixTableMapping new mapping
	 */
	public static function fromXml(SimpleXMLElement $data, $key = null) {
		return new self($key? $key: (string)$data['key'], (string)$data['name'], isset($data['id'])? (string)$data['id']: null);
	}

	/**
	 * Returns true if id of this mapping is defined.
	 * @return boolean
	 */
	public function isResolved() {
		return $this->id !== null;
	}

	/**
	 * Finds the mapping for assigned key.
	 * Method handles direct mappings like tags or categories.
	 *
	 * @throws RuntimeException on any error
	 * @param PolitixTableMap $map the parent map
	 * @param PolitixTableImport $import the data currently being imported
	 * @param PolitixTableSchema $schema the parent schema
	 * @return void
	 */
	public function resolve(PolitixTableMap $map, PolitixTableImport $import, PolitixTableSchema $schema) {
		$db = $import->getTargetDatabase();

		if($this->id === null) {
			if("{$map->table}" == '') throw new RuntimeException("The table for map '{$map->table}' is not defined! Probably this mapping is not tabled one.");

			$import->message(PolitixTableImport::INFO, "Searching for {$map->name}: {$this->name}");

			static $sel_stms = array();
			if(!isset($sel_stms[$map->table])) {
				$sql = "SELECT id FROM {$map->table} WHERE name = :name;";
				$sel_stms[$map->table] = $db->prepare($sql);
			}

			$stm = $sel_stms[$map->table];
			$stm->execute(array(':name' => $this->name));

			if($stm->rowCount() != 0) {
				$row = $stm->fetch(PDO::FETCH_ASSOC);
				$this->id = $row['id'];
				$import->message(PolitixTableImport::INFO, "Map {$map->name}: key '{$this->key}' is mapped to {$this->id} named '{$this->name}'");
			} else { //insert new
				$import->message(PolitixTableImport::INFO, "Map {$map->name}: key '{$this->key}' is not found as '{$this->name}' in {$map->table}. Creating new record.");

				static $ins_stms = array();
				if(!isset($ins_stms[$map->table])) {
					$sql = "INSERT INTO {$map->table}(name) VALUES(:name);";
					$ins_stms[$map->table] = $db->prepare($sql);
				}

				$stm = $ins_stms[$map->table];
				$stm->execute(array(':name' => $this->name));
				if($stm->rowCount() != 1) throw new RuntimeException("Map {$map->name}: can't insert new record '{$this->key}' => '{$this->name}'");

				$this->id = $db->lastInsertId($map->sequence);
				if("{$this->id}" == '') throw new RuntimeException("Map {$map->name}: can't fetch id for new mapping '{$this->key}' => '{$this->name}'");

				$import->message(PolitixTableImport::SUCCESS, "Map {$map->name}: key '{$this->key}' mapped as '{$this->name}', ref.id: {$this->id}");
			}
		}
	}


	/** Returns read-only fields of this object. */
	public function __get($name) {
		if($name == 'id') {
			if($this->id === null) throw new RuntimeException("Mapping for key '{$this->key}' is not resolved!");
			else return $this->id;
		}

		if(isset($this->$name)) return $this->$name;
		trigger_error("The field '{$name}' is not defined in mapping '{$this->key}'", E_USER_NOTICE);
		return null;
	}

	/** Ignores everything, raises notices. */
	public function __set($name, $value) {
		trigger_error("The field '{$name}' is read-only in mapping '{$this->key}'. Discarding value '{$value}'!", E_USER_NOTICE);
	}


	/**
	 * Dump contents of this mapping into DOM structure.
	 *
	 * @param DOMDocument $dom the target document
	 * @param DOMElement $map the parent 'map' element where in 'mapval' nodes will be inserted
	 * @return DOMElement created 'mapval' element
	 */
	public function dumpToXml($dom, $map) {
		$mapval = $dom->createElement('mapval');
		$mapval->setAttribute('key', $this->key);
		$mapval->setAttribute('name', $this->name);
		if($this->id !== null) $mapval->setAttribute('id', $this->id);

		$map->appendChild($mapval);
		return $mapval;
	}
}



/**
* Handles mappings for parties.
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTablePartyMapping extends PolitixTableMapping {

	/** Is this a combination of parties */
	protected $combination = 0;
	/** Owner region, by default 'Nederland' */
    protected $owner = 'Nederland';
    /** Short form (key) */
  	protected $short_form;

  	//prepared query
  	private static $stm = null;
  	private static $sel_stm = null;
  	private static $reg_sel_stm = null;
  	private static $reg_ins_stm = null;


  	/**
	 * Create new mappping.
	 *
	 * @param string $key the mapping key (source table cell value)
	 * @param string $name name of the record (name column value)
	 * @param integer $id the record id, if null, then mapping will be unresolved
	 */
	public function __construct($key, $name, $id = null, $owner = 'Nederland', $combination = 0, $short_form = null) {
		parent::__construct($key, $name, $id);
		$this->owner = $owner;
		$this->combination = $combination;
		$this->short_form = $short_form? $short_form: $key;
	}

	/**
	 * Create new mapping.
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $data the mapping data
	 * @return PolitixTablePartyMapping new mapping
	 */
	public static function fromXml(SimpleXMLElement $data, $key = null) {
		if(isset($data['owner'])) {
			$owner = (string)$data['owner'];
			if("{$owner}" == '') throw new RuntimeException("Owner region is empty!");
		} else $owner = 'Nederland';

		return new self($key? $key: (string)$data['key'], (string)$data['name'], isset($data['id'])? (string)$data['id']: null, $owner, isset($data['combination'])? (string)$data['combination']: 0, isset($data['short_form'])? (string)$data['short_form']: $key);
  	}


	/**
	 * Finds the mapping for assigned key.
	 *
	 * @throws RuntimeException on any error
	 * @param PolitixTableMap $map the parent map
	 * @param PolitixTableImport $import the data currently being imported
	 * @param PolitixTableSchema $schema the parent schema
	 * @return void
	 */
	public function resolve(PolitixTableMap $map, PolitixTableImport $import, PolitixTableSchema $schema) {
		$db = $import->getTargetDatabase();

		if(self::$stm == null) {
			$sql = "SELECT id FROM {$map->table} WHERE name = :name;";
			self::$sel_stm = $db->prepare($sql);

			$sql = "INSERT INTO {$map->table}(name, combination, owner, short_form) VALUES(:name, :combination, :owner, :short_form);";
			self::$stm = $db->prepare($sql);

			$sql = "SELECT id FROM pol_party_regions WHERE party = :party AND region = :region AND time_start <= :time_start AND time_end >= :time_end";
			self::$reg_sel_stm = $db->prepare($sql);

			$sql = "INSERT INTO pol_party_regions(party, region, bo_user, time_start, time_end) VALUES(:party, :region, NULL, :time_start, :time_end)";
			self::$reg_ins_stm = $db->prepare($sql);;
		}


		if($this->name == null) throw new RuntimeException("Map {$map->name}: the key '{$this->key}' can't be mapped, foreign value (name) is not set!");

		if($this->id === null) {
			$import->message('info', "Searching for {$map->name}: {$this->name}");
			self::$sel_stm->execute(array(':name' => $this->name));

			if(self::$sel_stm->rowCount() != 0) {
				$row = self::$sel_stm->fetch(PDO::FETCH_ASSOC);
				$this->id = $row['id'];
				$import->message(PolitixTableImport::INFO, "Map {$map->name}: party '{$this->key}' is mapped to {$this->id} named '{$this->name}'");
			} else { //insert new
				$import->message(PolitixTableImport::INFO, "Map {$map->name}: party '{$this->key}' is not found as '{$this->name}' in {$map->table}. Creating new record.");

				$region = $schema->getMap('region')->map($this->owner)->id;
				self::$stm->execute(array(
					':name' => $this->name,
					':combination' => $this->combination,
					':owner' => $region,
					':short_form' => $this->short_form
				));

				if(self::$stm->rowCount() != 1) throw new RuntimeException("Map {$map->name}: can't insert new party '{$this->key}' => '{$this->name}'");

				$this->id = $db->lastInsertId($map->sequence);
				if("{$this->id}" == '') throw new RuntimeException("Map {$map->name}: can't fetch id for new party '{$this->key}' => '{$this->name}'");

				$import->message(PolitixTableImport::SUCCESS, "Map {$map->name}: party '{$this->key}' mapped as '{$this->name}', ref.id: {$this->id}");
			}
		}


		//check if party is valid in our regions
		$regions = $schema->getMap('region')->listMappings();
		foreach ($regions as $region) {
				if(!$region->isResolved()) throw new RuntimeException("Region map is invalid for '{$region->name}'. This map depends on regions, the regions must be resolved prior to this map!");

				self::$reg_sel_stm->execute(array(
					':party' => $this->id,
					':region' => $region->id,
					':time_start' => $import->getStartDate(),
					':time_end' => $import->getEndDate()
				));

				if(self::$reg_sel_stm->rowCount() != 0) {
					$import->message(PolitixTableImport::INFO, "No change. Party '{$this->name}' valid in region '{$region->name}' for [{$import->getStartDate()} - {$import->getEndDate()}]");
				} else {
					$import->message(PolitixTableImport::INFO, "Party '{$this->name}' is not valid in region '{$region->name}'. Registering for period [{$import->getStartDate()} - {$import->getEndDate()}].");

					self::$reg_ins_stm->execute(array(
						':party' => $this->id,
						':region' => $region->id,
						':time_start' => $import->getStartDate(),
						':time_end' => $import->getEndDate()
					));

					if(self::$reg_ins_stm->rowCount() != 1) throw new RuntimeException("Can't link party mapping '{$this->name}' with region '{$region->name}' for period [{$import->getStartDate()} - {$import->getEndDate()}]. Query failed.");
					$import->message(PolitixTableImport::SUCCESS, "Party '{$this->name}' is registered in region '{$region->name}' for period [{$import->getStartDate()} - {$import->getEndDate()}].");
				}
			}
	}

	/**
	 * Dump contents of this mapping into DOM structure.
	 *
	 * @param DOMDocument $dom the target document
	 * @param DOMElement $map the parent 'map' element where in 'mapval' nodes will be inserted
	 * @return DOMElement created 'mapval' element
	 */
	public function dumpToXml($dom, $map) {
		$node = parent::dumpToXml($dom, $map);
		$node->setAttribute('owner', $this->owner);
		$node->setAttribute('combination', $this->combination);
		$node->setAttribute('short_form', $this->short_form);
	}
}


/**
* Handles mappings for politicians.
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTablePoliticianMapping extends PolitixTableMapping {

	private static $sel_stm = null;
	private static $ins_stm = null;
	private static $reg_sel = null;
	private static $reg_ins = null;

	/**
	 * Create new mapping.
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $data the mapping data
	 * @return PolitixTablePartyMapping new mapping
	 */
	public static function fromXml(SimpleXMLElement $data, $key = null) {
		if(isset($data['owner'])) {
			$owner = (string)$data['owner'];
			if("{$owner}" == '') throw new RuntimeException("Owner region is empty!");
		} else $owner = 'Nederland';

		return new self($key? $key: (string)$data['key'], (string)$data['name'], isset($data['id'])? (string)$data['id']: null);
  	}

	/**
	 * Finds the mapping for assigned key.
	 *
	 * @throws RuntimeException on any error
	 * @param PolitixTableMap $map the parent map
	 * @param PolitixTableImport $import the data currently being imported
	 * @param PolitixTableSchema $schema the parent schema
	 * @return void
	 */
	public function resolve(PolitixTableMap $map, PolitixTableImport $import, PolitixTableSchema $schema) {
		$db = $import->getTargetDatabase();

		if(self::$sel_stm == null) {
			//we have the guy that works for our party (has at least one linking function)
			$sql = "SELECT p.id FROM {$map->table} p INNER JOIN pol_politician_functions pf ON pf.politician = p.id WHERE last_name = :last_name AND pf.party = :party;";
			self::$sel_stm = $db->prepare($sql);


			$sql = "INSERT INTO {$map->table}(title, first_name, last_name, gender_is_male, email, name_sortkey, region_created)
					VALUES(NULL,  NULL,       :last_name,        1,              NULL,  :name_sortkey,           NULL);";

			self::$ins_stm = $db->prepare($sql);

			$sql = "SELECT id FROM pol_politician_functions WHERE politician = :politician AND party = :party AND region = :region AND time_start <= :time_start AND time_end >= :time_end";
			self::$reg_sel = $db->prepare($sql);

			$sql = "INSERT INTO pol_politician_functions(politician, party, region, category, time_start, time_end, description)
					VALUES(:politician, :party, :region, -1, :time_start, :time_end, NULL)";
			self::$reg_ins = $db->prepare($sql);
		}


		$party = $schema->getMap('party')->map($this->key);
		if(!$party->isResolved()) throw new RuntimeException("The required party mapping is not resolved! The politician map depends on party map!");

		static $polids = array();

		if($this->id !== null) {
			if(isset($polids[$this->id])) throw new RuntimeException("Preassigned politician '{$this->id}' already works for party '{$polids[$this->id]}'. Collision detected!");
			$polids[$this->id] = $party->name;
		} else { //resolve
			$import->message(PolitixTableImport::INFO, "Searching for {$map->name}: {$this->name}");
			self::$sel_stm->execute(array(':last_name' => $this->name, ':party' => $party->id));

			$pass = false;
			if(self::$sel_stm->rowCount() != 0) {
				$i = 0;
				while(($row = self::$sel_stm->fetch(PDO::FETCH_ASSOC))) {
					$id = $row['id'];

					if(!isset($polids[$id])) {
						$polids[$id] = $party->name;
						$this->id = $id;

						$import->message(PolitixTableImport::INFO, "Politician '{$this->name}' is found as {$this->name} in party '{$party->name}'");
						$pass = true;
						break;
					} else $i += 1;
				}

				if(!$pass) $import->message(PolitixTableImport::WARNING, "{$i} politicians named '{$this->name}' are found for party '{$party->name}' but they already work for other parties. This should not happen if you assign votes to 'Onbekend' politicians!");
			}

			if(!$pass) { //insert new politician
				$import->message(PolitixTableImport::INFO, "Politician '{$this->name}' is not found for party '{$party->name}', creating new one.");

				self::$ins_stm->execute(array(
					':last_name' => $this->name,
					':name_sortkey' => $this->name
				));

				if(self::$ins_stm->rowCount() != 1) throw new RuntimeException("Can not inset politician '{$this->name}' in party '{$party->name}', query failed.");

				$this->id = $db->lastInsertId($map->sequence);
				if("{$this->id}" == '') throw new RuntimeException("Map {$map->name}: can't fetch id for new politician '{$this->key}' => '{$this->name}'");

				$import->message(PolitixTableImport::SUCCESS, "Map {$map->name}: politician '{$this->name}' mapped as '{$this->key}' => {$this->id} in party {$party->name}");
			}
		}


		//check if politican is valid in our region
		$regions = $schema->getMap('region')->listMappings();
		foreach ($regions as $region) {
			if(!$region->isResolved()) throw new RuntimeException("Region map is invalid for '{$region->name}'. This map depends on regions, the regions must be resolved prior to this map!");

			self::$reg_sel->execute(array(
			 	':politician' => $this->id,
			 	':party' => $party->id,
			 	':region' => $region->id,
			 	':time_start' => $import->getStartDate(),
				':time_end' => $import->getEndDate()
			));

			if(self::$reg_sel->rowCount() != 0) {
				$import->message(PolitixTableImport::INFO, "No change. Politician '{$this->name}' is valid in region '{$region->name}' for [{$import->getStartDate()} - {$import->getEndDate()}]");
			} else {
				$import->message(PolitixTableImport::INFO, "Politician '{$this->name}' is not valid in region '{$region->name}'. Registering for period [{$import->getStartDate()} - {$import->getEndDate()}].");

				self::$reg_ins->execute(array(
					':politician' => $this->id,
					':party' => $party->id,
					':region' => $region->id,
					':time_start' => $import->getStartDate(),
					':time_end' => $import->getEndDate()
				));

				if(self::$reg_ins->rowCount() != 1) throw new RuntimeException("Can't link politician mapping '{$this->name}' of party '{$party->name}' with region '{$region->name}' for period [{$import->getStartDate()} - {$import->getEndDate()}]. Query failed.");
				$import->message(PolitixTableImport::SUCCESS, "Politician '{$this->name}' from party '{$party->name}' is registered in region '{$region->name}' for period [{$import->getStartDate()} - {$import->getEndDate()}].");
			}
		}
	}
}


/**
* Reads politix .data.xml and imports that in current database.
*
* This class uses SAX parser, so it is very memory efficient.
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class PolitixTableImport {

	/** Block size to read from input stream. */
	const READ_BLOCK_SIZE = 8192; //8kb

	//Message types
	/** Some operation block is started. */
	const BEGIN = 'begin';
	/** Operation block is ended. */
	const END = 'end';
	/** The import operation is ended successfully. */
	const ALL_SUCCESS = 'all-success';
	/** Operation ended successfully. */
	const SUCCESS = 'success';
	/** Operation ended successfully. */
	const INFO = 'info';
	/** Some warning (non fatal error, is fixed) */
	const WARNING = 'warning';
	/** Operation is failed. */
	const ERROR = 'error';
	/** The SQL query that failed (if SQL was executing) */
	const ERROR_SQL = 'error-sql';
	/** Database error (if SQL was executing) */
	const ERROR_SQL_DETAIL = 'error-sql-detail';


	/** @var PolitixTableSchema */
	private $schema;
	/** @var PDO */
	private $db;

	/** @var array */
	private $messages;
	/** @var array */
	private $message_filter = array(
		self::BEGIN => true,
		self::END => true,
		self::ALL_SUCCESS => true,
		self::SUCCESS => true,
		self::INFO => true,
		self::WARNING => true,
		self::ERROR => true,
		self::ERROR_SQL => true,
		self::ERROR_SQL_DETAIL => true
	);

	/** @var string */
	private $error;

	/** Id of the last inserted raadsstuk, used by dependent inserts.
	 * @var integer */
	private $raadsstuk_id = null;
	/** The earliest vote date in the dump. */
	private $time_start = null;
	/** The latest vote date in the dump. */
	private $time_end = null;

	//prepared statements
	private static $raadsstuk_stm;
	private static $category_stm;
	private static $tag_stm;
	private static $vote_stm;

	/**
	 * Create new importer.
	 *
     * @param PDO $db the target database
	 * @param PolitixTableSchema $schema contains all required mappings
	 */
	public function __construct($db, PolitixTableSchema $schema) {
		$this->db = $db;
		$this->schema = $schema;

		if(self::$raadsstuk_stm == null) {
			$raadsstuk_sql = "INSERT INTO rs_raadsstukken(region, title, vote_date, summary, code, type, result, submitter, parent, show)
							  VALUES(:region, :title, :vote_date, :summary, :code, :type, :result, :submitter, NULL, :show)";
			self::$raadsstuk_stm = $this->db->prepare($raadsstuk_sql);

			$category_sql = "INSERT INTO rs_raadsstukken_categories(raadsstuk, category) VALUES(:raadsstuk, :category)";
			self::$category_stm = $this->db->prepare($category_sql);

			$tag_sql = "INSERT INTO rs_raadsstukken_tags(raadsstuk, tag) VALUES(:raadsstuk, :tag)";
			self::$tag_stm = $this->db->prepare($tag_sql);

			$vote_sql = "INSERT INTO rs_votes(politician, raadsstuk, vote) VALUES(:politician, :raadsstuk, :vote)";
			self::$vote_stm = $this->db->prepare($vote_sql);
		}
	}


	/**
	 * Returns associated mapping schema
	 * @return PolitixTableSchema
	 */
	public function getSchema() {
		return $this->schema;
	}

	/**
	 * Returns target database connection.
	 * @return PDO
	 */
	public function getTargetDatabase() {
		return $this->db;
	}

	/**
	 * Returns date of the earliest raadsstuk in the dataset.
	 * @return string
	 */
	public function getStartDate() {
		return $this->time_start;
	}

	/**
	 * Returns date of the latest raadsstuk in the database.
	 * @return string
	 */
    public function getEndDate() {
    	return $this->time_end;
    }

	/**
	 * Import the data to the given database connecttion.
	 *
	 * If $file is a string, then it is assumed to be a path and will be opened
	 * using fopen.
	 *
	 * This method assumes the database contains following tables:
	 *
	 *   - rs_raadsstukken -- table where in new raadsstukken will be added
	 *   - rs_raadsstukken_categories, sys_categories -- links to categories
	 *   - rs_raadsstukken_tags, sys_tags -- links to tags
	 *   - rs_votes, pol_politicians -- voting table
	 *
	 * Method will resolve internal $schema first, ensuring the politicians:politician_functions
	 * and party:party_region constraints are properly met. The schema will be resolved
	 * for time-range from the first raadsstuk up to the last raadsstuk.
	 *
	 * The format of the import file:
	 *
	 *    politix[
	 *       time_start  -- the earliest vote date of all raadsstukken
	 *      ,time_end    -- the latest vote date of all raadsstukken
	 *      ,count       -- number of raadsstukken to insert
	 *    ] ->
	 *        raadsstuk[
	 *           region     -- region key for region mapping
	 *          ,title      -- raadsstuk title
	 *          ,vote_date  -- vote date as Unix timestamp
	 *          ,summary    -- summary text
	 *          ,code       -- the code field (source id, wet.nr, kamer.nr)
	 *          ,type       -- raadsstuk type key for mapping
	 *          ,result     -- key for result mapping
	 *          ,submitter  -- submitter type, key for mapping
	 *          ,show       -- show (1) or hide(0) the imported raadsstukken
	 *        ] ->
	 *            category[
	 * 				 name   -- teh category name, key for mapping
	 * 			  ]
	 *
	 *           ,vote[
	 *               party  -- the party name, key for mapping
	 *               vote   -- the vote, key for mapping
	 *            ]
	 *
	 *           ,tag[
	 *               name   -- the tag to assign, key for mapping
	 * 			  ]
	 *
	 *
	 * If key for mapping is expected, then use original value from the politix database and
	 * provide mapping for that value in the schema.
	 *
	 * Note: method starts dataabase transaction, on any error the rollback will be sent.
	 *
	 * @throws RuntimeException on any error
	 * @param string|resource $file resource used with fread(), feof(), if string, then fopen() first
	 * @return void
	 */
	public function import($file) {
		$this->messages = array();
		$this->error = false;

		$this->db->query("START TRANSACTION");

		try{
			$xml = xml_parser_create();
			if(!$xml) throw new RuntimeException("Can't create SAX parser!");
			xml_parser_set_option($xml, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);

			xml_set_element_handler($xml, array($this, '_tagStart'), array($this, '_tagEnd'));

			if(is_string($file)) $fp = fopen($file, 'r');
			else $fp = $file;
			if(!is_resource($fp)) throw new RuntimeException("Can't obtain data input stream, either invalid resource or path to file.");

			while(!$this->error && ($chunk = fread($fp, self::READ_BLOCK_SIZE))) {
               	if (!xml_parse($xml, $chunk, feof($fp))) {
               		fclose($fp);
               		$errline = xml_get_current_line_number($xml);
               		$errcol = xml_get_current_column_number($xml);
               		$err = xml_error_string($xml);

					xml_parser_free($xml);
                   	throw new RuntimeException(sprintf("XML error at line %d column %d:%s", $errline, $errcol, $err));
            	}
			}

            fclose($fp);
			xml_parser_free($xml);
            if($this->error) throw new RuntimeException($this->error);

			$this->db->query('ROLLBACK;');
			//$this->db->query('COMMIT;');

			$this->message(self::ALL_SUCCESS, "Success =)");
		} catch (Exception $e) {
			$this->db->query('ROLLBACK;');

			$this->message(self::ERROR, $e->getMessage());
			if($e instanceof DatabaseException) {
				$this->message(self::ERROR_SQL, $e->getSQL());
				$this->message(self::ERROR_SQL_DETAIL, $e->getError());
			}
		}
	}


	/**
	 * Returns all of the messages collected during the import operation.
	 * @return array [[type, message]], where type is one of the constants of this class.
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * Enable/disabl message of specific type.
	 *
	 * @param string $type of the message constants
	 * @param boolean $set true - include messages of specified type, false - discard these messages
	 * @return void
	 */
	public function setMessageFilter($type, $set) {
		if($set) $this->message_filter[$type] = true;
		else unset($this->message_filter[$type]);
	}

	/**
	 * Returns list of all accepted message types.
	 * @return array list of (type => true) pairs
	 */
	public function getMessageFilters() {
		return $this->message_filter;
	}

	/**
	 * Report message.
	 * @param string $type one of the type constants
	 * @param string $message the message to report
	 */
	public function message($type, $message) {
		if(isset($this->message_filter[$type])) $this->messages[] = array($type, $message);
	}


	/**
	 * Process the tag. Called by SAX parser.
	 * @param resource $parser SAX parser
	 * @param string $tagname tag currently being processed
	 * @param array $row set of attributes
	 * @return void
	 */
	public function _tagStart($parser, $tagname, $row) {
		if($this->error) return;

		try {
			switch ($tagname) {
				case 'politix':
					$this->message(self::BEGIN, 'Inserting '.$row['count'].' raadsstukken');

					if($row['time_start'] >= $row['time_end']) throw new RuntimeException("Time range for raadsstukken is invalid or zero: ".date('Y-m-d', $row['time_start'])." - ".date('Y-m-d', $row['time_end']));
					$this->time_start = date('Y-m-d', $row['time_start']);
					$this->time_end = date('Y-m-d', $row['time_end']);

					$this->schema->resolve($this);
					break;

				case 'raadsstuk':
					$this->message(self::INFO, "Inserting raadsstuk: '{$row['title']}'");
					self::$raadsstuk_stm->execute(array(
						':region' => $this->schema->getMap('region')->map($row['region'])->id
						,':title' => $row['title']
						,':vote_date' => date("Y-m-d", $row['vote_date'])
						,':summary' => $row['summary']
						,':code' => $row['code']
						,':type' => $this->schema->getMap('type')->map($row['type'])->id
						,':result' => $this->schema->getMap('result')->map($row['result'])->id
						,':submitter' => $this->schema->getMap('submitter')->map($row['submitter'])->id
						,':show' => $row['show']
					));
					if(self::$raadsstuk_stm->rowCount() != 1) throw new RuntimeException("Failed to insert raadsstuk '{$row['title']}'");

					$this->raadsstuk_id = $this->db->lastInsertId('rs_raadsstukken_id_seq');
					if("{$this->raadsstuk_id}" == '') throw new RuntimeException("Can't fetch new voorstels id! Last insert id failed.}");
					$this->message(self::SUCCESS , "New raadsstuk id: {$this->raadsstuk_id}");
				break;


				case 'category': //assign categories
					foreach($this->schema->getMap('category')->map($row['name']) as $category) {
						$this->message(self::INFO, "Assigning category '{$category->name}' to raadsstuk id: {$this->raadsstuk_id}");
						self::$category_stm->execute(array(
							':raadsstuk' => $this->raadsstuk_id
						   ,':category' => $category->id
						));
						if(self::$category_stm->rowCount() != 1) throw new RuntimeException("Failed link category '{$category->name}' to raadsstuk id: {$this->raadsstuk_id}");
						$this->message(self::SUCCESS, "Raasstuk {$this->raadsstuk_id} is linked to category {$category->name}");
					}

					break;


				case 'tag': //register tags
					$this->message(self::INFO, "Assignig tag '{$row['name']}' to the raadsstuk id: {$this->raadsstuk_id}");
					self::$tag_stm->execute(array(
						 ':raadsstuk' => $this->raadsstuk_id
						,':tag' => $this->schema->getMap('tag')->map($row['name'])->id
					));
					if(self::$tag_stm->rowCount() != 1) throw new RuntimeException("Failed link tag '{$row['name']}' to raadsstuk id: {$this->raadsstuk_id}");
					$this->message(self::SUCCESS, "Raasstuk {$this->raadsstuk_id} is linked to tag '{$row['name']}");

					break;


				case 'vote': //votes

					$vote = $this->schema->getMap('vote')->map($row['vote']);
					$part = $this->schema->getMap('party')->map($row['party']);
					if($vote->id != -1) {
						$this->message(self::INFO, "Voting '{$vote->name}' from the party '{$part->name}' for the raadsstuk id: {$this->raadsstuk_id}");
						self::$vote_stm->execute(array(
							 ':politician' => $this->schema->getMap('politician')->map($row['party'])->id
						    ,':raadsstuk'  => $this->raadsstuk_id
						    ,':vote' => $vote->id
						));
						if(self::$vote_stm->rowCount() != 1) throw new RuntimeException("Failed to vote '{$vote->name}' from the party '{$part->name}' for the raadsstuk id: {$this->raadsstuk_id}");
						$this->message(self::SUCCESS, "Successfully voted '{$vote->name}' from the party '{$part->name}' for the raadsstuk id: {$this->raadsstuk_id}");
					} else {
						$this->message(self::INFO, "The party '{$part->name}' is not voting for raadsstuk id: {$this->raadsstuk_id}");
					}

					break;

				default:
					throw new RuntimeException("Unknown tag: '{$tagname}' at line: ". xml_get_current_line_number($parser)." and column: ".xml_get_current_column_number($parser));
			}
		} catch (Exception $e) {
			$this->message(self::ERROR, $e->getMessage()."; line: ".$e->getLine());
			if($e instanceof DatabaseException) {
				$this->message(self::ERROR_SQL, $e->getSQL());
				$this->message(self::ERROR_SQL_DETAIL, $e->getError());
			}

			$this->error = "Error: {$e->getMessage()} at line ".xml_get_current_line_number($parser)." and column: ".xml_get_current_column_number($parser);
		}
	}

	/**
	 * End of the tag. All calls are ignored.
	 * @param resource $parser SAX parser
	 * @param string $tagname tag currently being processed
	 * @return void
	 */
	public function _tagEnd($parser, $tagname) { }
}

?>