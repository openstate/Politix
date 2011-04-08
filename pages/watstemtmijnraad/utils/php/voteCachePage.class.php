<?php

require_once('Message.class.php');


/**
* Checkt vote cache inconsistencies.
*
* @author Sardar Yumatov <ja.doma@gmail.com>
*/
class VoteCachePage {

	private $db;
	private $diagnostic_data = null;
	private $affected_rows = array();
	private $benchmark_time;
	private $operation_time = -1;


	/** Init this object (DB connection etc) */
	public function __construct() {
		$this->db = DBs::inst(DBs::SYSTEM);
	}


	/** Prepare data */
	public function processGet($get) {
		$time_start = microtime(true);

		if(isset($get['correct_id']) && $get['correct_id'] != '') $this->correctRaadstuk(intval($get['correct_id']));
		elseif(isset($get['correct_all'])) $this->correctAll();

		$this->fetchDiagnosticData();

		//measure time
		$time_end = microtime(true);
		$this->benchmark_time = $time_end - $time_start;
	}

	/** Render page */
	public function show($smarty) {

		//really missing XSLT =((

		$result_data = array();
		foreach ($this->diagnostic_data['filtered_to_cached_diff'] as $id => $row) {
			$dat = array(
				'title' => $row['title'],
				'raadsstuk_id' => $id,
			);

			$votes = array();
			foreach (array('vote_0', 'vote_1', 'vote_2', 'vote_3') as $k) {
				$votes[$k] = array(
								'incorrect' => ($row[$k] != 0),
								'difference' => $row[$k],
								'in_cache_count' => $this->diagnostic_data['cached_result'][$id][$k],
								'filtered_count' => $this->diagnostic_data['filtered_result'][$id][$k],
								'actual_count' => $this->diagnostic_data['correct_result'][$id][$k],
							);
			}
			$dat['votes'] = $votes;

			$missing_people = array();
			foreach($this->diagnostic_data['missing_people'][$id] as $po) {
				$po['completely_missing'] = !isset($this->diagnostic_data['correct_people_ids'][$po['id']]);
				$missing_people[] = $po;
			}
			$dat['missing_people'] = $missing_people;

			$result_data[] = $dat;
		}

		$not_in_cache_data = array();
		foreach ($this->diagnostic_data['not_in_cache'] as $id => $row) {
			$dat = array(
				'title' => $row['title'],
				'raadsstuk_id' => $id,
			);

			$votes = array();
			foreach (array('vote_0', 'vote_1', 'vote_2', 'vote_3') as $k) {
				$votes[$k] = array(
								'filtered_count' => $row[$k],
								'actual_count' => $this->diagnostic_data['correct_result'][$id][$k],
							);
			}
			$dat['votes'] = $votes;

			$missing_people = array();
			foreach($this->diagnostic_data['missing_people'][$id] as $po) {
				$po['completely_missing'] = !isset($this->diagnostic_data['correct_people_ids'][$po['id']]);
				$missing_people[] = $po;
			}
			$dat['missing_people'] = $missing_people;

			$not_in_cache_data[] = $dat;
		}


		$undo_sql = array();
		foreach ($this->affected_rows as $row) $undo_sql[] = $row['undo_SQL'];

		$smarty->assign('result_data', $result_data);
		$smarty->assign('not_in_cache', $not_in_cache_data);
		$smarty->assign('undo_SQL', $undo_sql);
		$smarty->assign('benchmark_time', $this->benchmark_time);
		$smarty->assign('operation_time', $this->operation_time);
		$smarty->display(lcfirst(get_class($this)).'.html');
	}


	/** Collect all diagnostic info. */
	private function fetchDiagnosticData() {
		//execution time
		$time_start = microtime(true);

		//select all raadsstukken that have at least one associated vote, do not discard votes
		//yes, sequence of JOIN ON ... AND vote = ... is probably beter, but to be sure we count it on php side
		$sql = "SELECT r.id, r.title, v.vote
				FROM rs_raadsstukken r
					 INNER JOIN rs_votes v ON v.raadsstuk = r.id
				ORDER BY r.id";

		$res = $this->db->query($sql);

		$correct_result = array();
		while(($row = $res->fetchRow())) { //flat -> tree, slow
			if(!isset($correct_result[$row['id']]))
				$correct_result[$row['id']] = array(
					'title'=>$row['title'],
					'vote_0' => 0,
					'vote_1' => 0,
					'vote_2' => 0,
					'vote_3' => 0
				);

			$correct_result[$row['id']]['vote_'.$row['vote']] += 1;
		}


		//select all raadsstukken that are being voted by politicians that have at
		//least one function with [start-end] time range containing vote date fot the raadsstuk
		//update: ensure party where politician belongs to is in region of the raasstuk (Molina problem)
		$sql = "SELECT r.id, r.title, v.vote, p.id as pid
				FROM rs_raadsstukken r
					 INNER JOIN rs_votes v ON v.raadsstuk = r.id
					 INNER JOIN pol_party_regions pr ON r.region = pr.region AND r.vote_date BETWEEN pr.time_start AND pr.time_end
					 INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date BETWEEN pf.time_start AND pf.time_end AND pf.party = pr.party
					 INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id
				GROUP BY r.id, r.title, v.vote, pid
				ORDER BY r.id"; //politician can have multiple functions, so selelct all correct and limit to 1

		$res = $this->db->query($sql);

		$filtered_result = array();
		while(($row = $res->fetchRow())) { //flat -> tree, slow
			if(!isset($filtered_result[$row['id']]))
				$filtered_result[$row['id']] = array(
					'title'=>$row['title'],
					'vote_0' => 0,
					'vote_1' => 0,
					'vote_2' => 0,
					'vote_3' => 0
				);

			$filtered_result[$row['id']]['vote_'.$row['vote']] += 1;
		}


		//cached results
		$sql = "SELECT r.id, r.title, vc.vote_0, vc.vote_1, vc.vote_2, vc.vote_3
				FROM rs_raadsstukken r
					 INNER JOIN rs_vote_cache vc ON vc.id = r.id";

		$res = $this->db->query($sql);

		$cached_result = array();
		while(($row = $res->fetchRow())) {
			$cached_result[$row['id']] = array(
				'title' => $row['title'],
				'vote_0' => $row['vote_0'],
				'vote_1' => $row['vote_1'],
				'vote_2' => $row['vote_2'],
				'vote_3' => $row['vote_3']
			);
		}


		//differences
		$data_diff = array();
		$not_cached_data = array();
		$problem_raadsstukken = array();
		foreach ($filtered_result as $rid => $dat) {
			if(!isset($cached_result[$rid])) {
				$not_cached_data[$rid] = $dat;
				$problem_raadsstukken[] = $rid;
				continue;
			} else $cdat = $cached_result[$rid];

			$v0_d = $dat['vote_0'] - $cdat['vote_0'];
			$v1_d = $dat['vote_1'] - $cdat['vote_1'];
			$v2_d = $dat['vote_2'] - $cdat['vote_2'];
			$v3_d = $dat['vote_3'] - $cdat['vote_3'];

			if((abs($v0_d) + abs($v1_d) + abs($v2_d) + abs($v3_d)) > 0) {
				$data_diff[$rid] = array(
					'title' => $dat['title'],
					'vote_0' => $v0_d,
					'vote_1' => $v1_d,
					'vote_2' => $v2_d,
					'vote_3' => $v3_d
				);

				$problem_raadsstukken[] = $rid;
			}
		}


		if(sizeof($problem_raadsstukken) > 0) {
			//politician can have both a correct and incorrect function in the same region
			//while making a vote. We should show only the politicians that will be not shown
			//on vote detail menu (tree), so only politicians that made vote, but don't have any
			//correct function
			//correct function - a function with the time range containing vote date of the raadsstuk
			//WARNING: politician can made a vote while not having any functions in that region, these people will be skipped!
			$prids = implode(', ', $problem_raadsstukken);

			$sql = "SELECT DISTINCT p.id as pid

					FROM rs_raadsstukken r
						 INNER JOIN rs_votes v ON v.raadsstuk = r.id
						 INNER JOIN pol_party_regions pr ON r.region = pr.region AND r.vote_date BETWEEN pr.time_start AND pr.time_end
					 	 INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date BETWEEN pf.time_start AND pf.time_end AND pf.party = pr.party
					 	 INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id

					WHERE r.id IN ({$prids})"; //all politicians that have correct function at vote date

			$res = $this->db->query($sql);
			//$exclude_correct = implode(', ', $res->fetchAllCells(0));
			$exclude_correct = array_map('is_int', array_map('intval', array_flip($res->fetchAllCells(0))));

			//select all politicians that don't have correct function (filter out that have both, correct and incorrect)
			$sql = "SELECT r.id as rid, p.id as pid, p.first_name, p.last_name, rg.name, v.vote,
						   DATE(r.vote_date) as vote_date,
						   DATE(pf.time_start) as time_start,
						   DATE(pf.time_end) as time_end

					FROM rs_raadsstukken r
						 INNER JOIN rs_votes v ON v.raadsstuk = r.id

					 	INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date NOT BETWEEN pf.time_start AND pf.time_end
					 	INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id
					 	INNER JOIN sys_regions rg ON rg.id = pf.region

					WHERE r.id IN ({$prids})"; //AND p.id NOT IN ({$exclude_correct})

			$res = $this->db->query($sql);

			//INNER JOIN pol_party_regions pr ON r.region = pr.region AND r.vote_date BETWEEN pr.time_start AND pr.time_end
			//AND pf.party = pr.party

			$missing_people = array();
			while(($row = $res->fetchRow())) {
				if(!isset($missing_people[$row['rid']])) $missing_people[$row['rid']] = array();

				$missing_people[$row['rid']][] = array(
					'id' => $row['pid'],
					'first_name' => $row['first_name'],
					'last_name' => $row['last_name'],
					'region' => $row['name'],
					'vote' => $row['vote'],
					'vote_date' => $row['vote_date'],
					'function_start' => $row['time_start'],
					'function_end' => $row['time_end'],
				);
			}
		}

		//measure time
		$time_end = microtime(true);
		$time = $time_end - $time_start;

		//combine the results
		$this->diagnostic_data = array(
			'execution_time' => $time,
			'correct_result' => $correct_result,
			'filtered_result' => $filtered_result,
			'cached_result' => $cached_result,
			'filtered_to_cached_diff' => $data_diff,
			'not_in_cache' => $not_cached_data,
			'missing_people' => isset($missing_people)? $missing_people: null,
			'correct_people_ids' => isset($exclude_correct)? $exclude_correct: null,
			'problematic_raadsstukken' => $problem_raadsstukken,
		);

		return $this->diagnostic_data;
	}


	/** Correct specifi raadsstuk */
	private function correctRaadstuk($id) {
		$time_start = microtime(true);
		$id = intval($id);

		//select all raadsstukken that are being voted by politicians that have at
		//least one function with [start-end] time range containing vote date fot the raadsstuk
		$sql = "SELECT v.vote, p.id as pid
				FROM rs_raadsstukken r
					 INNER JOIN rs_votes v ON v.raadsstuk = r.id
					 INNER JOIN pol_party_regions pr ON r.region = pr.region AND r.vote_date BETWEEN pr.time_start AND pr.time_end
					 INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date BETWEEN pf.time_start AND pf.time_end AND pf.party = pr.party
					 INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id
				WHERE r.id = {$id}
				GROUP BY r.id, v.vote, pid"; //politician can have multiple functions, so selelct all correct and limit to 1

		$res = $this->db->query($sql);

		$filtered_result = array(
			'vote_0' => 0,
			'vote_1' => 0,
			'vote_2' => 0,
			'vote_3' => 0
		);

		while(($row = $res->fetchRow())) $filtered_result['vote_'.$row['vote']] += 1;

		//backup cache
		$sql = "SELECT vc.vote_0, vc.vote_1, vc.vote_2, vc.vote_3
				FROM rs_vote_cache vc
				WHERE vc.id = {$id}";

		$res = $this->db->query($sql);
		$old_data = $res->fetchRow();


		$this->db->query("START TRANSACTION");
		try {
			if(!$old_data) { //this can't happen, we have a stored procedure on insert trigger
				MessageQueue::addMessage(new Message(Message::WARNING, "Vote cache record for raadsstuk '{$id}' doesn't exist! Creating new one."));

				$sql = "INSERT INTO rs_vote_cache (id, vote_0, vote_1, vote_2, vote_3) VALUES ({$id}, 0, 0, 0, 0)";
				$rows = $this->db->query($sql)->affectedRows();
				if($rows != 1) throw new RuntimeException("Can not create vote cache record for raadsstuk '{$id}'! Database failure.");
			}


			$sql = "UPDATE rs_vote_cache SET vote_0 = {$filtered_result['vote_0']},
											 vote_1 = {$filtered_result['vote_1']},
											 vote_2 = {$filtered_result['vote_2']},
											 vote_3 = {$filtered_result['vote_3']}
					WHERE id = {$id}";

			$rows = $this->db->query($sql)->affectedRows();
			if($rows != 1) throw new RuntimeException("Can not update cache for raadsstuk '{$id}'! Database failure.");
			else {
				$this->db->query("COMMIT;");

				if($old_data) {
					//build undo SQL statement
					$sql = "UPDATE rs_vote_cache SET vote_0 = {$old_data['vote_0']},
													 vote_1 = {$old_data['vote_1']},
													 vote_2 = {$old_data['vote_2']},
													 vote_3 = {$old_data['vote_3']}
							WHERE id = {$id};";
				} else $sql = "DELETE FROM rs_vote_cache WHERE id = {$id}";

				$this->affected_rows[] = array(
					'id' => $id,
					'old_data' => $old_data,
					'new_data' => $filtered_result,
					'undo_SQL' => $sql
				);

				MessageQueue::addMessage(new Message(Message::SUCCESS, "Vote cache for raadsstuk '{$id}' is successfully updated!"));
			}
		} catch (Exception $e) {
			MessageQueue::addMessage(new Message(Message::ERROR, $e->getMessage()));
			$this->db->query("ROLLBACK;");
		}

		//measure time
		$time_end = microtime(true);
		$this->operation_time = $time_end - $time_start;
	}


	/** Correct all raadsstuks */
	private function correctAll() {
		$time_start = microtime(true);

		//select all raadsstukken that are being voted by politicians that have at
		//least one function with [start-end] time range containing vote date fot the raadsstuk
		$sql = "SELECT r.id, r.title, v.vote, p.id as pid
				FROM rs_raadsstukken r
					 INNER JOIN rs_votes v ON v.raadsstuk = r.id
					 INNER JOIN pol_party_regions pr ON r.region = pr.region AND r.vote_date BETWEEN pr.time_start AND pr.time_end
					 INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date BETWEEN pf.time_start AND pf.time_end AND pf.party = pr.party
					 INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id
				GROUP BY r.id, r.title, v.vote, pid
				ORDER BY r.id"; //politician can have multiple functions, so selelct all correct and limit to 1

		$res = $this->db->query($sql);

		$filtered_result = array();
		while(($row = $res->fetchRow())) { //flat -> tree, slow
			if(!isset($filtered_result[$row['id']]))
				$filtered_result[$row['id']] = array(
					'title'=>$row['title'],
					'vote_0' => 0,
					'vote_1' => 0,
					'vote_2' => 0,
					'vote_3' => 0
				);

			$filtered_result[$row['id']]['vote_'.$row['vote']] += 1;
		}


		$ids = implode(', ', array_keys($filtered_result));

		//backup cache
		$sql = "SELECT vc.id, vc.vote_0, vc.vote_1, vc.vote_2, vc.vote_3
				FROM rs_vote_cache vc
				WHERE vc.id IN ({$ids})";

		$res = $this->db->query($sql);

		$old_data = array();
		while(($row = $res->fetchRow())) $old_data[$row['id']] = $row;


		//differences
		$not_cached_data = array();
		$problem_raadsstukken = array();
		foreach ($filtered_result as $rid => $dat) {
			if(!isset($old_data[$rid])) {
				$not_cached_data[] = $rid;
				$problem_raadsstukken[] = $rid;
				continue;
			} else $cdat = $old_data[$rid];

			$v0_d = $dat['vote_0'] - $cdat['vote_0'];
			$v1_d = $dat['vote_1'] - $cdat['vote_1'];
			$v2_d = $dat['vote_2'] - $cdat['vote_2'];
			$v3_d = $dat['vote_3'] - $cdat['vote_3'];

			if((abs($v0_d) + abs($v1_d) + abs($v2_d) + abs($v3_d)) > 0) $problem_raadsstukken[] = $rid;
		}

		if(sizeof($problem_raadsstukken) > 0) {
			$this->db->query("START TRANSACTION;");

			try {
				if(sizeof($not_cached_data) > 0) { //this should not happen
					MessageQueue::addMessage(new Message(Message::WARNING, "Not all vote cache records exist! Re-creating missing records."));

					foreach ($not_cached_data as $id) {
						$sql = "INSERT INTO rs_vote_cache (id, vote_0, vote_1, vote_2, vote_3) VALUES ({$id}, 0, 0, 0, 0)";
						$rows = $this->db->query($sql)->affectedRows();
						if($rows != 1) throw new RuntimeException("Can not create vote cache record for raadsstuk '{$id}'! Database failure.");
					}
				}


				foreach ($problem_raadsstukken as $id) {
					$res = $filtered_result[$id];
					$sql = "UPDATE rs_vote_cache SET vote_0 = {$res['vote_0']},
												 vote_1 = {$res['vote_1']},
												 vote_2 = {$res['vote_2']},
												 vote_3 = {$res['vote_3']}
							WHERE id = {$id}";

					$rows = $this->db->query($sql)->affectedRows();
					if($rows != 1) throw new RuntimeException("Can not update cache for raadsstuk '{$id}'! Database failure.");
					else {
						if(isset($old_data[$id])) {
							//build undo SQL statement
							$sql = "UPDATE rs_vote_cache SET vote_0 = {$old_data[$id]['vote_0']},
															 vote_1 = {$old_data[$id]['vote_1']},
															 vote_2 = {$old_data[$id]['vote_2']},
															 vote_3 = {$old_data[$id]['vote_3']}
									WHERE id = {$id};";
							} else $sql = "DELETE FROM rs_vote_cache WHERE id = {$id}";

						$this->affected_rows[] = array(
							'id' => $id,
							'old_data' => $old_data[$id],
							'new_data' => $res,
							'undo_SQL' => $sql
						);
					}
				}

				$this->db->query("COMMIT");
				MessageQueue::addMessage(new Message(Message::SUCCESS, "Vote cache for raadsstukken '{$ids}' is successfully updated!"));
			} catch (Exception $e) {
				MessageQueue::addMessage(new Message(Message::ERROR, $e->getMessage()));
				$this->db->query("ROLLBACK;");
			}
		} else {
			MessageQueue::addMessage(new Message(Message::SUCCESS, "The vote cache is correct, nothing to do!"));
		}

		//measure time
		$time_end = microtime(true);
		$this->operation_time = $time_end - $time_start;
	}
}

//this is the worst database design I've ever seen... =/

?>