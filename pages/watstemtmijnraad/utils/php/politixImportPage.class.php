<?php
//test

require_once('utils/PolitixImport.package.php');

class PolitixImportPage {

	private $messages;
	private $config;

	public function __construct() {

	}


	public function processGet($get) {
		if(!isset($get['table'])) {
			echo "<a href='/utils/politixImport?table=voorstellentwee'>voorstellentwee</a><br>";
			echo "<a href='/utils/politixImport?table=voorstellen2006'>voorstellen2006</a>";
			return;
		}

		$inf = require('database.private.php');
		$inf = $inf[DBs::SYSTEM];

		if(empty($inf)) throw new RuntimeException("No DB info!");

		$config = $this->config = array(
			'source' => $get['table'],
			'port' => 5432,
			'host' => $inf['host'],
			'user' => $inf['user'],
			'password' => $inf['pass'],
			'database' => $inf['database']
		);



		$path = "{$config['source']}.schema.xml";
		if(!is_file($path) || !is_readable($path)) trigger_error("Can not read source table schema '{$path}'", E_USER_ERROR);

		$schema = simplexml_load_file($path);
		$schema = PolitixTableSchema::fromXml($schema);

		//==================- Data import -===========================

		$pdo = new PDO("pgsql:host={$config['host']} port={$config['port']} dbname={$config['database']}", $config['user'], $config['password']);

		$import = new PolitixTableImport($pdo, $schema);
		$import->setMessageFilter(PolitixTableImport::INFO, false);
		$import->setMessageFilter(PolitixTableImport::SUCCESS, false);


		try {
			$import->import("{$config['source']}.data.xml");
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		$this->messages = $import->getMessages();
	}


	public function show() {
		if($this->messages == null) return ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Inserting data from politix database <?php echo $this->config['source']; ?></title>
</head>

<body>
<h1>Importing data from politix database: <?php echo $this->config['source']; ?></h1>
<?php
		foreach ($this->messages as $rec) {
			$type = $rec[0];
			$msg = $rec[1];

			switch ($type) {
				case 'begin': echo "<h3 style='color: #555'>{$msg}</h3>\n"; break;
				case 'end': echo "<div style='color: #555; font-weight: bold'>{$msg}</div>\n"; break;
				case 'pre-sql': echo "<div style='font-family: monospace; color: #333; background-color: #efefef; margin-top: 3px;'><span style='color: orange;'>Executing:</span> {$msg}</div>\n"; break;
				case 'success': echo "<div style='color: darkgreen; background-color: #efefef; margin-bottom: 3px;'>{$msg}</div>\n"; break;
				case 'info': echo "<div style='font-family: Verdana, sans-serif; font-size: 14px; margin-top: 10px;'>{$msg}</div>\n"; break;
				case 'all-success': echo "<h1 style='width: 300px; margin-left: auto; margin-right: auto; color: green;'>{$msg}</h1>\n"; break;
				case 'error': echo "<div><span style='color: red; font-weight: bold;'>Rollback on error: </span> {$msg}</div>\n"; break;
				case 'error-sql': echo "<div style='fond-family: monospace;'>{$msg}</div>\n"; break;
				case 'error-sql-detail': echo "<div style='font-family: font-family: Verdana, sans-serif; font-size: 16px; border: 1px solid red;'>{$msg}</div>\n"; break;
				case 'warning': echo "<div style='font-family: font-family: Verdana, sans-serif; font-size: 16px; color: red;'>{$msg}</div>\n"; break;

				default: echo "<div>{$msg}</div>";
			}
		}
?>
</body>
</html>
<?php

	}

}


?>
