<?php

/*
	File: LogListeners
	Contains a number of <LogListener> implementations for common logging outputs.
*/

require_once('Logger.class.php');
require_once('Database.class.php');

/*
	Class: EchoListener
	A LogListener that logs to the output of PHP.

	Log entries are output in a HTML table at the end of the page. The session id is not printed.
*/
class EchoListener implements LogListener {
	public function LogEntries(array $entries) {
		echo '<hr>';
		if (count($entries)==0)
			echo '<b>There are no log entries.</b>';
		else {
			echo '<b>Log entries:</b><br><table><tr><td>Level</td><td>Time</td><td>System</td><td>File</td><td>Message</td></tr>';
			foreach ($entries as $e) {
				echo "<tr><td>{$e['level']}</td><td>{$e['time']}</td><td>{$e['system']}/{$e['subsystem']}</td><td>{$e['file']}:{$e['line']}</td><td>{$e['message']}</td></tr>";
			}
			echo '</table>';
		}
	}
}

/*
	Class: DatabaseListener
	A LogListener that logs to a Postgres database.

	Log entries are written to a logging table on the specified database.
*/
class DatabaseListener implements LogListener {
	private $db, $tableName;

	/*
		Constructor: __construct
		Creates a new DatabaseListener.

		Parameters:
		$db - A <Database> instance to write the entries to.
	*/
	public function __construct(Database $db, $tableName) {
		$this->db = $db;
		$this->tableName = $tableName;
	}

	public function LogEntries(array $entries) {
		$this->db->query('begin');
		foreach ($entries as $e) {
			$this->db->query('insert into '.$this->tableName.' (level, time, system, subsystem, file, line, session, message) values (%,%,%,%,%,%,%,%);',
				$e['level'], $e['time'], $e['system'], $e['subsystem'], $e['file'], $e['line'], $e['session'], $e['message']);
		}
		$this->db->query('commit');
	}
}

?>