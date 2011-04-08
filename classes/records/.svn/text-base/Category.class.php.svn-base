<?php
require_once('ObjectList.class.php');

class Category extends Record {

	protected $data = array(
		'name'        => null,
		'description' => null
	);
	protected $tableName = 'sys_categories';
	protected $categoryRegionsTableName = 'sys_category_regions';

	public function loadByRegion($region) {
		return $this->getlist(
			'JOIN '.$this->categoryRegionsTableName.' cr ON t.id = cr.category',
			'WHERE cr.level = (SELECT level FROM sys_regions r WHERE id = '.$region.')'
		);
	}

	public static function getDropDownCategoriesByRegion($region) {
		if(!ctype_digit($region)) return array(); //[XXX: sometimes people pass request parameters as-is]

		$c = new Category();
		$cs = $c->loadByRegion($region);

		$result = array();
		foreach($cs as $c) {
			$result[$c->id] = $c->name;
		}
		return $result;
	}

	public static function getDropDownCategoriesAll() {
		$c = new Category();
		$cs = $c->getList();

		$result = array();
		foreach($cs as $c) {
			$result[$c->id] = $c->name;
		}
		return $result;
	}

	public function toXml($xml) {
		return $xml->getTag('category').
			$xml->fieldToXml('id', $this->id, false).
			$xml->fieldToXml('name', $this->name, true).
			$xml->getTag('category', true);
	}
}

?>