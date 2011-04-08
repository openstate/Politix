<?php

require_once('utils/XmlTableDump.php');

/**
 * Enter description here...
 *
 */
class ImportPage {


	public function processGet($get) {
		//missing tags
		$tags = array();
		$source = new XmlTableDump('id', 'tags.to_add.dump.xml');
		foreach ($source->getData() as $row) {
			$row = $row->getCells();
			$tags[] = array('name' => $row['name'], 'old-id' => $row['id']);
		}

		//missing pol_politician_functions
		$pol_functions = array();
		$source = new XmlTableDump('id', 'pol_politician_functions.diff.xml');
		foreach ($source->getData() as $row) {
			$row = $row->getCells();
			$row['old-id'] = $row['id']; unset($row['id']);
			$pol_functions[] = $row;
		}

		//new raadsstukken
		$raadsstukken = array();
		$source = new XmlTableDump('id', 'rs_raadsstukken.diff.xml');
		$idx = $source->defineIndex('parent', null);
		$nms = array_filter($idx->listIndexKeys()); //skip ''
		array_unshift($nms, '');

		foreach ($nms as $idname) {
			foreach ($idx->selectRows($idname) as $row) {
				$row = $row->getCells();
				if("{$row['parent']}" != '') $row['dependent'] = true;
				else $row['dependent'] = false;

				$row['old-id'] = $row['id']; unset($row['id']);
				$raadsstukken[] = $row;
			}
		}


		//votes
		$votes_data = array();
		$source = new XmlTableDump('id', 'rs_votes.accepte.xml');
		foreach ($source->getData() as $row) {
			$row = $row->getCells();
			$row['old-id'] = $row['id']; unset($row['id']);
			$votes_data[] = $row;
		}


		//tag links
		$tags_raadsstuk = array();
		$source = new XmlTableDump('id', 'rs_raadsstukken_tags.accepte.dump.xml');
		foreach ($source->getData() as $row) $tags_raadsstuk[] = $row->getCells();


		//tag submitters links
		$submitters_raadsstuk = array();
		$source = new XmlTableDump('id', 'rs_raadsstuk_submitters.accepte.dump.xml');
		foreach ($source->getData() as $row) $submitters_raadsstuk[] = $row->getCells();


		//tag submitters links
		$categories_raadsstuk = array();
		$source = new XmlTableDump('id', 'rs_raadsstukken_categories.accepte.dump.xml');
		foreach ($source->getData() as $row) $categories_raadsstuk[] = $row->getCells();

		echo "<?php\n";
?>


/** Patch set page */
class RaadsstukkenPatchPage {

	public function processGet($get) {
		$db = DBs::inst(DBs::SYSTEM);


		$tags = <?php var_export($tags); ?>; //[sys_tags]

		$pol_functions = <?php var_export($pol_functions); ?>; //[pol_politician_functions]

		$raadsstukken = <?php var_export($raadsstukken); ?>; //[rs_raadsstukken]

		$votes_data = <?php var_export($votes_data); ?>; //[rs_votes]

		$tags_raadsstuk = <?php var_export($tags_raadsstuk); ?>;

		$submitters_raadsstuk = <?php var_export($submitters_raadsstuk); ?>;

		$categories_raadsstuk = <?php var_export($categories_raadsstuk); ?>;



		$tagids = array();
		$polids = array();
		$raadids = array();

		try {
			$db->query('START TRANSACTION;');

			if(sizeof($tags) > 0) {
				echo "<h3>Inserting tags</h3>";

				foreach ($tags as $tg) {
					$sql = "INSERT INTO sys_tags(name) VALUES(%s);";
					$sql = $db->formatQuery($sql, $tg['name']);


					echo "<span style='color: orange;'>Executing(insert tag):</span> ".htmlentities($sql)."<br>\n";
					$res = $db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					echo "<b style='color: green'>Success!</b>\n<br>";

					$sql = "SELECT currval('sys_tags_id_seq'::regclass)";
					$val = $db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new tag id: {$sql}");
					$tagids[$tg['old-id']] = $val;
					echo "<span style='color: darkgreen'>Mapping:</span> {$tg['old-id']} to {$val}\n<br>";
				}
			}

			if(sizeof($pol_functions) > 0) {
				echo "<h3>Inserting politician functions</h3>";

				foreach ($pol_functions as $pol) {
					$sql = "INSERT INTO pol_politician_functions(politician, party, region, category, time_start, time_end, description) VALUES(%i, %i, %i, %i, %s, %s, %)";
					$sql = $db->formatQuery($sql, $pol['politician'], $tg['party'], $tg['region'], $tg['category'], $tg['time_start'], $tg['time_end'], $tg['description']);

					echo "<span style='color: orange;'>Executing(insert pol.func):</span> ".htmlentities($sql)."<br>\n";
					$res = $db->query($sql);
					if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
					echo "<b style='color: green'>Success!</b>\n<br>";

					$sql = "SELECT currval('pol_politician_functions_id_seq'::regclass)";
					$val = $db->query($sql)->fetchCell();
					if("{$val}" == '') throw new RuntimeException("Can't fetch new pol.func id: {$sql}");
					$polids[$pol['old-id']] = $val;
					echo "<span style='color: darkgreen'>Mapping:</span> {$pol['old-id']} to {$val}\n<br>";
				}
			}


			echo "<h3>Inserting raadsstukken</h3>";
			foreach($raadsstukken as $row) {
				if($row['dependent'] && !isset($raadids[$row['parent']])) throw new RuntimeException("Wrong order, parent raadsstuk is not yet inserted! Title: {$row['title']}");

				$sql = "INSERT INTO rs_raadsstukken(region, title, vote_date, summary, code, type, result, submitter, parent, show) VALUES(%i, %s, %s, %s, %s, %i, %i, %i, %, %i);";
				$sql = $db->formatQuery($sql, $row['region'], $row['title'], $row['vote_date'],
							 				  $row['summary'], $row['code'], $row['type'],
									   		  $row['result'], $row['submitter'], ($row['dependent']? $raadids[$row['parent']]: null), $row['show']
								   		);

				echo "<span style='color: orange;'>Executing(insert raadsstuk):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";

				//store ID for deps
				$sql = "SELECT currval('rs_raadsstukken_id_seq'::regclass)";
				$val = $db->query($sql)->fetchCell();
				if("{$val}" == '') throw new RuntimeException("Can't fetch new raaddsstuk id: {$sql}");
				$raadids[$row['old-id']] = $val;
				echo "<span style='color: darkgreen'>Mapping:</span> {$row['old-id']} to {$val}\n<br>";
			}


			//inserting votes
			echo "<h3>Inserting votes</h3>";
			foreach ($votes_data as $vote) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_votes(politician, raadsstuk, vote) VALUES(%i, %i, %i);";
				$sql = $db->formatQuery($sql, $vote['politician'], $raadids[$vote['raadsstuk']], $vote['vote']);

				echo "<span style='color: orange;'>Executing(insert vote):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}


			//inserting tags
			echo "<h3>Inserting Tag links</h3>";
			foreach ($tags_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_tags(raadsstuk, tag) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], isset($tagids[$row['tag']])? $tagids[$row['tag']]: $row['tag']);

				echo "<span style='color: orange;'>Executing(insert tag link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}


			echo "<h3>Inserting Submitters links</h3>";
			foreach ($submitters_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_submitters(raadsstuk, politician) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], $row['politician']);

				echo "<span style='color: orange;'>Executing(insert sub.link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}

			echo "<h3>Inserting Categories links</h3>";
			foreach ($categories_raadsstuk as $row) {
				//parties, party in regions are checked manualy
				$sql = "INSERT INTO rs_raadsstukken_categories(raadsstuk, category) VALUES(%i, %i);";
				$sql = $db->formatQuery($sql, $raadids[$row['raadsstuk']], $row['category']);

				echo "<span style='color: orange;'>Executing(insert sub.link):</span> ".htmlentities($sql)."<br>\n";
				$res = $db->query($sql);
				if($res->affectedRows() != 1) throw new RuntimeException("Query failed: {$sql}");
				echo "<b style='color: green'>Success!</b>\n<br>";
			}


			$db->query('ROLLBACK;');
			echo "<h1 style='width: 300px; margin-left: auto; margin-right: auto; color: green;'>Success</h1>";

		} catch(Exception $e) {
			echo "<b style='color: red'>Rollback on error:</b> ".$e->getMessage();
			$db->query("ROLLBACK;");
		}
	}
}



<?php

		echo "\n?>";
	}
}

?>