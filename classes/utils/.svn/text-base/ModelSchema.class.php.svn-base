<?php

require_once('RegionModelSchema.class.php');
require_once('CategoryModelSchema.class.php');
require_once('TagModelSchema.class.php');
require_once('SiteModelSchema.class.php');

require_once('PartyModelSchema.class.php');
require_once('PoliticianModelSchema.class.php');

require_once('JLogger.class.php');

/**
* Watstemtmijnraad.nl database schema.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class ModelSchema {

	private $db;

	/** @var RegionModelSchema */
	private $region;

	/** @var CategoryModelSchema */
	private $categories;

	/** @var TagModelSchema */
	private $tags;

	/** @var SiteModelSchema */
	private $sites;

	/** @var PartyModelSchema */
	private $party;

	/** @var PoliticianModelSchema */
	private $politicians;

	/**
	 * Load "watstemtmijnraad.nl" schema.
	 *
	 * @throws RuntimeException on any error
	 * @param PDO $db database access
	 */
	public function __construct($db) {
		$log = JLogger::getLogger('util.import.schema');
		$log->enter("Initializing all schema's");

		$this->db = $db;
		$this->region = new RegionModelSchema($db, $this);
		$this->categories = new CategoryModelSchema($db, $this);
		$this->tags = new TagModelSchema($db, $this);
		$this->sites = new SiteModelSchema($db, $this);

		$this->party = new PartyModelSchema($db, $this);
		$this->politicians = new PoliticianModelSchema($db, $this);

		$log->leave("All schema's are successfully loaded");
	}


	/**
	 * Returns region schema.
	 * @return RegionModelSchema
	 */
	public function getRegionSchema() {
		return $this->region;
	}


	/**
	 * Returns party schema.
	 * @return PartyModelSchema
	 */
	public function getPartySchema() {
		return $this->party;
	}

	/**
	 * Returns category schema.
	 * @return CategoryModelSchema
	 */
	public function getCategorySchema() {
		return $this->categories;
	}

	/**
	 * Returns tag schema.
	 * @return TagModelSchema
	 */
	public function getTagSchema() {
		return $this->tags;
	}

	/**
	 * Returns site schema.
	 * @return SiteModelSchema
	 */
	public function getSiteSchema() {
		return $this->sites;
	}

	/**
	 * Returns
	 * @return PoliticianModelSchema
	 */
	public function getPoliticianSchema() {
		return $this->politicians;
	}

	/**
	 * Serialize this schema to the DOM tree.
	 *
	 * @param DOMDocument $dom the owner document, used to create elements
	 * @param DOMElement $root where to 'schema' element will be added
	 * @param array $options extra options
	 * @return void
	 */
	public function toXml($dom, $root, $options = null) {
		$el = $dom->createElement('schema');
		$root->appendChild($el);

		$this->region->toXml($dom, $el, $options);
		$this->categories->toXml($dom, $el, $options);
		$this->party->toXml($dom, $el, $options);
		$this->politicians->toXml($dom, $el, $options);
	}


	/**
	 * Read & update schema from XML data.
	 *
	 * @throws RuntimeException on any error
	 * @param SimpleXMLElement $node schema node
	 * @return void
	 */
	public function update(SimpleXMLElement $node) {
		$log = JLogger::getLogger('util.import.schema');
		$log->enter("Begin with updating all schema's from XML source.");

		foreach ($node->children() as $chld) {
			switch ($chld->getName()) {
				case 'regions':
					$this->region->update($chld);
					break;

				case 'categories':
					$this->categories->update($chld);
					break;

				case 'parties':
					$this->party->update($chld);
					break;

				case 'politicians':
					$this->politicians->update($chld);
					break;

				default: throw new RuntimeException("Unknown schema container: ".$chld->getName());
			}
		}

		$log->leave("Successfully updated all schema's from XML source.");
	}
}
?>