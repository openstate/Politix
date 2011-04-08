<?php


/**
 * Enter description here...
 *
 */
class TestPage {

	private $correct_result;
	private $filtered_result;
	private $cached_result;
	private $data_diff;
	private $missing_people;


	public function __construct() {

	}

	public function processGet($get) {


$db = DBs::inst(DBs::SYSTEM);


//yes, sequence of JOIN ON ... AND vote = ... is probably beter, but to be sure we count it on php side
$sql = "SELECT r.id, r.title, v.vote FROM rs_raadsstukken r INNER JOIN rs_votes v ON v.raadsstuk = r.id";
$res = $db->query($sql);

$correct_result = array();
while($row = $res->fetchRow()) { //flat -> tree, slow
	if(!isset($correct_result[$row['id']])) $correct_result[$row['id']] = array('title'=>$row['title'], 'vote_0' => 0, 'vote_1' => 0, 'vote_2' => 0, 'vote_3' => 0);
	$correct_result[$row['id']]['vote_'.$row['vote']] += 1;
}


//filter by correct function time range constraint
//politician can be in diferent parties (different functions within the same region)
//WARNING: infinity ranges are true for "between" and "not between"!
$sql = "SELECT r.id, r.title, v.vote, p.id as pid, COUNT(pf.id) as funcs FROM rs_raadsstukken r INNER JOIN rs_votes v ON v.raadsstuk = r.id INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date BETWEEN pf.time_start AND pf.time_end INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id  GROUP BY r.id, r.title, v.vote, pid";
$res = $db->query($sql);

//WHERE pf.time_start <> '-infinity' AND pf.time_start <> 'infinity' AND pf.time_end <> '-infinity' AND pf.time_end <> 'infinity'

$filtered_result = array();
while($row = $res->fetchRow()) { //flat -> tree, slow
	if(!isset($filtered_result[$row['id']])) $filtered_result[$row['id']] = array('title'=>$row['title'], 'vote_0' => 0, 'vote_1' => 0, 'vote_2' => 0, 'vote_3' => 0);
	$filtered_result[$row['id']]['vote_'.$row['vote']] += 1;
}


//cached results
$sql = "SELECT r.id, r.title, vc.vote_0, vc.vote_1, vc.vote_2, vc.vote_3 FROM rs_raadsstukken r INNER JOIN rs_vote_cache vc ON vc.id = r.id";
$res = $db->query($sql);

$cached_result = array();
while($row = $res->fetchRow()) {
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
foreach ($filtered_result as $rid => $dat) {
	if(!isset($cached_result[$rid])) continue;
	else $cdat = $cached_result[$rid];

	$v0_d = $dat['vote_0'] - $cdat['vote_0'];
	$v1_d = $dat['vote_1'] - $cdat['vote_1'];
	$v2_d = $dat['vote_2'] - $cdat['vote_2'];
	$v3_d = $dat['vote_3'] - $cdat['vote_3'];

	if((abs($v0_d) + abs($v1_d) + abs($v2_d) + abs($v3_d)) > 0) $data_diff[$rid] = array(
		'vote_0' => $v0_d,
		'vote_1' => $v1_d,
		'vote_2' => $v2_d,
		'vote_3' => $v3_d
	);
}


//missing people - politician made a vote while not being in function (wrong date range)
//WARNING: politicians that made a vote, but don't have a function record associated with region of the 'raadstuk' will be not fetched by this query
$sql = "SELECT r.id, p.id as pid, p.first_name, p.last_name, rg.name, DATE(r.vote_date) as vote_date, DATE(pf.time_start) as time_start, DATE(pf.time_end) as time_end FROM 	rs_raadsstukken r INNER JOIN rs_votes v ON v.raadsstuk = r.id INNER JOIN pol_politician_functions pf ON pf.region = r.region AND r.vote_date NOT BETWEEN pf.time_start AND pf.time_end INNER JOIN pol_politicians p ON p.id = pf.politician AND v.politician = p.id INNER JOIN sys_regions rg ON rg.id = pf.region";
$res = $db->query($sql);

$missing_people = array();
while($row = $res->fetchRow()) {
	if(!isset($missing_people[$row['id']])) $missing_people[$row['id']] = array();
	$missing_people[$row['id']][] = array(
		'id' => $row['pid'],
		'first_name' => $row['first_name'],
		'last_name' => $row['last_name'],
		'region' => $row['name'],
		'vote_date' => $row['vote_date'],
		'function_start' => $row['time_start'],
		'function_end' => $row['time_end'],
	);
}


		$this->cached_result = $cached_result;
		$this->correct_result = $correct_result;
		$this->data_diff = $data_diff;
		$this->missing_people = $missing_people;
		$this->filtered_result = $filtered_result;
	}

	public function show($smary) {


		$correct_result = $this->correct_result;
		$filtered_result = $this->filtered_result;
		$cached_result = $this->cached_result;
		$data_diff = $this->data_diff;
		$missing_people = $this->missing_people;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Vote cache inconsistency fix</title>

<style type="text/css">

body {
	color: #000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	line-height: 14px;
}


.voor {
	color: #49C100;
	font-weight: bold;
}

.tegen {
	color: #C1001B;
	font-weight: bold;
}

.onthouden {
	color: #FF6600;
	font-weight: bold;
}

.afweizig {
	color: #AAAA00;
	font-weight: bold;
}

.raadstuk {
	padding-bottom: 10px;
}

.raadstuk a {
	text-decoration: none;
	color: #555;
}

.raadstuk a:hover {
	text-decoration: underline;
	color: #49C1EE;
}

.border_line td {
	border-top: 1px solid #ccc;
	padding-top: 5px;
}

.fault {
	font-weight: bold;
	color: red;
}

.correct {
	font-weight: bold;
	color: green;
}

.real {
	color: #888;
}
</style>

</head>
<body>

<div style="width: 800px; margin-left: auto; margin-right: auto;">
	<h1 style="text-align: center;">Cache faults</h1>
			<table cellpadding="0" cellspacing="0" style="width: 100%">
				<thead>
					<tr><td colspan="4"><h3>Cached Voorstellen</h3></td></tr>
					<tr><td class="voor">Voor</td><td class="tegen">Tegen</td><td class="onthouden">Onthouden</td><td class="afweizig">Afwezig</td></tr>
					<tr><td colspan="4" style="height: 20px;"></td></tr>
				</thead>

<?php
				$pshow = 0;
				if(sizeof($data_diff) > 0) {
						$keys = array('vote_0', 'vote_1', 'vote_2', 'vote_3');
						foreach($data_diff as $rid => $ddat) {
							$dat = $filtered_result[$rid];
							$cordat = $correct_result[$rid];
?>
				<tbody>
					<tr class="border_line"><td class="raadstuk" colspan="4"><?php echo $rid?>: <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/raadsstukken/raadsstuk/<?php echo $rid?>" title="Ga naar <?php echo $dat['title']?>"><?php echo $dat['title']?></a></td></tr>
					<tr>
<?php
							//numbers
							foreach ($keys as $k) {
								if($ddat[$k] != 0)
									echo '<td><span class="fault">'.$cached_result[$rid][$k].'</span> ('.$ddat[$k].') <span class="correct">'.$dat[$k].'</span> <span class="real">['.$cordat[$k].']</span></td>';
								else echo '<td>'.$dat[$k].' <span class="real">['.$cordat[$k].']</span></td>';
							}
?>
					<tr>
						<td colspan="4" style="padding-top: 10px; padding-bottom: 20px;">
<?php
							//names
							foreach ($missing_people[$rid] as $po) {
								echo "<div>{$po['id']}: {$po['first_name']} {$po['last_name']} in {$po['region']} - voted: {$po['vote_date']} but [{$po['function_start']} - {$po['function_end']}]";
								$pshow += 1;
							}

?>
						</td>
					</tr>
				</tbody>

<?php
						}
				} else {
?>
				<tbody><tr><td colspan="4"><h3>No cache faults! =)</h3></td></tr></tbody>
<?php
				}

				//cache is correct, but
				if(sizeof($missing_people) - $pshow > 0) {

				}
?>
			</table>
		</td>


</div>

</body>
</html>

<?php
	}
}



?>