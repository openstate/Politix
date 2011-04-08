<?php

require_once('DBs.class.php');
require_once('Region.class.php');

class GemeentePage {
	public function processGet($get) {
		try {
			$r = new Region(@$get['id']);
		} catch (Exception $e) {
			echo '';
			die;
		}

		$result = array();
		$db = DBs::inst(DBs::SYSTEM);

		$ids = array_keys(isset($_SESSION['user'])? $_SESSION['user']->listSiteIds(): User::listDefaultSiteIds());

		$regions = $db->query('
			SELECT DISTINCT t.name, t.id
			FROM sys_regions t JOIN rs_raadsstukken r ON t.id = r.region AND r.site_id IN ('.implode(', ', $ids).')
			WHERE t.parent = % ORDER BY name', $r->id)->fetchAllCells('id');

		if (!$regions) $regions = array(-1 => 'Geen');
		echo(implode("\n", array_map(create_function('$a,$b', 'return $a."||".trim($b);'), array_keys($regions), $regions)));
		die;
	}
}