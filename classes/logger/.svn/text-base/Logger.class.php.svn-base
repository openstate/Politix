<?php

/*
	File: Logger
	Contains classes to facilitate logging.
*/

/*
	Interface: LogListener
	Defines the interface for a 'Log listener'.

	Listeners can be registered with the <Logger> class. When this is done, they will receive
	log entries and can then determine which ones they want to write and to where. This
	makes sure the Logger class is not responsible for determining what to log and where.
*/
interface LogListener {
	/*
		Method: LogEntries
		Request to log entries. Called when the <Logger> class has entries to log.

		Parameters:
		$entries - An array of associative arrays containing the log entries.

		The indices in the array are:
		level     - An integer with the severity of the log message. See <Logger::Severities>.
		time      - The time the message was added. Currently it's a string formatted with date with the string 'Y-m-d H:i:s'.
		message   - The log message.
		system    - The major system that created the entry.
		subsystem - The minor system that created the entry.
		session   - The session tracing id
		file      - The file for which the message is relevant.
		line      - The line for which the message is relevant.
	*/
	public function LogEntries(array $entries);
}

/*
	Class: Logger
	The logging manager.

	This class is a central point to log messages to. On destruction of the class, the entries
	are passed to registered <LogListeners> to actually write the entries.
*/
class Logger {
	/*
		Group: Severities
		These constants are used to indicate how important a log entry is.
	*/
	// Constant: Debug
	// Indicates information purely for debugging.
	const Debug   = 0;
	// Constant: Notice
	// Indicates normal information.
	const Notice  = 1;
	// Constant: Warning
	// Indicates a (possible) problem in the system.
	const Warning = 2;
	// Constant: Error
	// Indicates a major problem in the system.
	const Error   = 3;

	protected $listeners;
	protected $system;
	protected $session;

	protected $entries;

	// Property: $rootLength
	// Holds the string length of the repository root directory name. Used to cut down the 'file' entry length.
	private $rootLength = 0;

	/*
		Group: Functions
	*/
	/*
		Constructor: __construct
		Constructs the logger.

		Parameters:
		$system  - The name of the major system that is doing the logging. Examples are frontoffice, backoffice, etc.
		$session - The session tracking id.
	*/
	public function __construct($system, $session) {
		$this->system    = $system;
		$this->session   = $session;
		$this->entries   = array();
		$this->listeners = array();
		$this->rootLength = strlen(realpath($_SERVER['DOCUMENT_ROOT'].'/../'));
	}

	private function removeOpt($prev, $curr) {
		return $prev && ($curr['level'] < self::Warning);
	}

	private function filterOpt($curr) {
		return !$curr['optional'];
	}

	/*
		Destructor: __destruct
		Destructs the logger and writes any log entries.
	*/
	public function __destruct() {
		$entries = $this->entries;
		if (array_reduce($entries, array($this, 'removeOpt'), true))
			$entries = array_filter($entries, array($this, 'filterOpt'));
		foreach ($this->listeners as $l) {
			$l->LogEntries($entries);
		}
	}

	/*
		Method: registerListener
		Registers a <LogListener> that will write log entries.

		Parameters:
		$l - The LogListener to register.
	*/
	public function registerListener(LogListener $l) {
		$this->listeners[]= $l;
	}

	/*
		Method: log
		Adds a log entry.

		Parameters:
		$level                     - The severity of the entry. It is suggested that the <Severities> constants are used.
		$message                   - The actual log message.
		$subsystem                 - The subsystem that made this message. This is normally the class name or package.
		$optional (Default: false) - Whether the message should be removed from the entries list if no severe problems
		                             occur. Currently, these entries are removed if no entries with severity <Warning> or
		                             higher are present.
		$tracedepth (Default: 0)   - How deep in the debug backtrace should be looked to determine the file and line
		                             values. The default will cause the caller file and line to be logged.
	*/
	public function log($level, $message, $subsystem, $optional = false, $tracedepth = 0) {
		$trace = debug_backtrace();
		$this->entries[]= array(
			'level' => $level,
			'time' => date('Y-m-d H:i:s'),
			'message' => $message,
			'subsystem' => $subsystem,
			'system' => $this->system,
			'session' => $this->session,
			'file' => substr($trace[$tracedepth]['file'], $this->rootLength),
			'line' => $trace[$tracedepth]['line'],
			'optional' => $optional
		);
	}
}

class Logs {
	protected static $instance = null;
	public static $system, $session;

	public static function inst() {
		if (self::$instance === null)
			self::$instance = new Logger(self::$system, self::$session);
		return self::$instance;
	}

	public static function log($level, $message, $subsystem, $optional = false, $tracedepth = 0) {
		self::inst()->log($level, $message, $subsystem, $optional, $tracedepth);
	}
}

/*
	Class: QuickLogger
	A simple <Logger> wrapper to shorten the <Logger::log> calls.

	Since subsystems that continually use the same value for the subsystem parameter of the
	log method are normally in the same class, this class shortens the entries of the log
	and centralises the definition of the subsystem string.
*/
class QuickLogger {
	private $logger, $subsystem;

	/*
		Constructor: __construct
		Creates a new instance.

		Parameter:
		$logger    - An instance of <Logger> to wrap.
		$subsystem - The subsystem string to pass to <Logger::log>
	*/
	public function __construct(Logger $logger, $subsystem) {
		$this->logger = $logger;
		$this->subsystem = $subsystem;
	}

	/*
		Method: log
		Adds a log entry to the wrapped Logger.

		For the parameters, see <Logger::log>. They are the same except that the subsystem
		parameter is missing.
	*/
	public function log($level, $message, $optional = false, $tracedepth = 0) {
		$this->logger->log($level, $message, $this->subsystem, $optional, $tracedepth+1);
	}
}

?>