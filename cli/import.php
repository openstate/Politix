<?php
/**
* Import data from xml source.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/

//setup environment
require_once(dirname(__FILE__).'/../includes/prequel.cli.php');

require_once('ModelSchema.class.php');
require_once('Import.class.php');
require_once('JLogger.class.php');


$dry = true;
$file = null;

for($i = 1; $i < sizeof($argv); $i++) {
	if($argv[$i][0] == '-') {
		switch ($argv[$i]) {
			case '-c':
			case '--commit': $dry = false;
		}
	} else $file = $argv[$i];
}

//check arguments
if($file == null) {
	echo "Usage: php import.php [-c] <filename>\n";
	echo "	         -c -- commit mode (default dry-run)\n";
	exit(0);
}

if(!is_file($file) || !is_readable($file)) {
	echo "Can't read import file: {$file}\n";
	exit(1);
}

echo "Importing: {$file}. ".($dry? 'ROLLBACK mode.': 'COMMIT mode.')."\n";


$root = JLogger::getLogger();
$root->addLogHandler(new EchoJLoggerHandler());
$root->setLogLevel(JLogger::LEVEL_NOTICE);

//============================- Import procedure -============================
$pdo = getPDOConnection();
$pdo->beginTransaction();


try {
	$import = new Import($pdo);
	$import->setURISource($file);
	$import->process();

	if($dry) {
		//$log->info("Dry run mode. Rolling back any changes.");
		echo "\nDry run mode. Rolling back any changes.";
		$pdo->rollBack();
	} else {
		//$log->info("Commiting all changes.");
		echo "\nCommiting all changes.";
		$pdo->commit();
	}
} catch (Exception $e) {
	$pdo->rollBack();
	//if($e instanceof DatabaseException) $root->error("Database failure: ".$e->getMessage(), $e);
	echo "\nError: ".$e;

}

unset($import);
unset($pdo);
echo "\nDone.";
?>