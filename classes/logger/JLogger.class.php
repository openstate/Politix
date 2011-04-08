<?php

/**
* Currently there is no config dir defined by policy, so we
* will put it in 'privates' directory.
*
* [FIXME: probably this define should be replaced by some calculated path]
*/
define('LOG_CONFIG_PATH', '../privates/log.config.xml');


/**
* Simple java.util.logging like logger.
*
* This logger forms an unbounded in depth tree of loggers,
* where each node represents a subsystem, which is independently
* cofigurable. This allows you to fine-tune your logging depending
* on system currently being tested.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class JLogger {

//=================- Log levels -=====================
	/** Disable any messages. */
	const LEVEL_NONE = 999;
	/** Severe errors */
	const LEVEL_ERROR = 4;
	/** Include warnings too */
	const LEVEL_WARNING = 3;
	/** Include notice messages */
	const LEVEL_NOTICE = 2;
	/** Include debug mesages. */
	const LEVEL_DEBUG = 1;
	/** Report everything */
	const LEVEL_ALL = 0;


//=============- Message types/classes -==============
	/** Severe error */
	const ERROR = 0x1;
	/** A warning, recoverable error. */
	const WARNING = 0x2;
	/** Something is missing, some dirty situation. */
	const NOTICE = 0x4;
	/** General info .*/
	const INFO = 0x8;
	/** General debug message. */
	const DEBUG = 0x10;
	/** Before SQL query, SQL query will be reported here */
	const PRE_SELECT = 0x20;
	/** Before update SQL query or any 'update' operation to any subsystem */
	const PRE_UPDATE = 0x40;
	/** After successful executing update query */
	const POST_UPDATE = 0x80;
	/** Entering a block or function */
	const ENTER = 0x100;
	/** Leaving the block or function */
	const LEAVE = 0x200;

	/** Bitmask that contains all message types. */
	const ALL_MASK = 0xFFFF;

	/**
	 * Default message mask.
	 * Enables everything in the levels other than LEVEL_DEBUG.
	 * In LEVEL_DEBUG enables everything except ENTER and LEAVE.
	 */
	const DEFAULT_MASK = 0xFF;

	/** Default log level */
	const DEFAULT_LEVEL = self::LEVEL_WARNING;


	/** Maps each message type to corresponding level.
	 * @var array (type => level) */
	protected static $TYPE_TO_LEVEL = array(
		self::ERROR => self::LEVEL_ERROR,
		self::WARNING => self::LEVEL_WARNING,
		self::NOTICE => self::LEVEL_NOTICE,
		self::INFO => self::LEVEL_NOTICE,
		self::DEBUG => self::LEVEL_DEBUG,
		self::PRE_SELECT => self::LEVEL_DEBUG,
		self::PRE_UPDATE => self::LEVEL_DEBUG,
		self::POST_UPDATE => self::LEVEL_DEBUG,
		self::ENTER => self::LEVEL_DEBUG,
		self::LEAVE => self::LEVEL_DEBUG
	);


	/** Current log level.
	 * @var integer */
	protected $loglevel = self::DEFAULT_LEVEL;

	/** Current message type mask. */
	protected $typemask = self::DEFAULT_MASK;

	/** @var string */
	protected $name;
	/** @var string */
	protected $node_name;
	/** @var JLogger */
	protected $parent;


	/** @var array  (name => Logger) */
	protected $loggers = array();
	/** @var array of JLoggerHandler */
	protected $handlers = array();

	/** @var Logger */
	protected static $top_logger = null;
	protected static $cache = array();
	protected static $config = null;


	/**
	 * Construct new logger.
	 *
	 * @param string $node_name last token of the $name
	 * @param string $name name path
	 * @param JLogger $parent parent logger
	 */
	protected function __construct($node_name, $name, $parent) {
		$this->node_name = $node_name;
		$this->name = $name;
		$this->parent = $parent;
	}

	/**
	 * Obtain logger of specific level.
	 *
	 * @param string $name logger path
	 * @return JLogger
	 */
	public static function getLogger($name = null) {
		if(isset(self::$cache[$name])) return self::$cache[$name];
		if(self::$top_logger == null) {
			self::$top_logger = new JLogger('.', '.', null);
			self::configureLogger(self::$top_logger);
		}
		if($name == '' || $name == '.') return self::$top_logger;

		$path = array_filter(explode('.', $name));
		$top = self::$top_logger;
		foreach ($path as $el) {
			$top = $top->getChildLogger($el);
			if(!isset(self::$cache[$top->getName()])) self::$cache[$top->getName()] = $top;
		}
		return $top;
	}

	/**
	 * Returns direct child of this logger.
	 * @param string $name logger name
	 * @return Logger
	 */
	protected function getChildLogger($name) {
		if(!isset($this->loggers[$name])) {
			$this->loggers[$name] = new JLogger($name, ltrim($this->name.'.'.$name, '.'), $this);
			self::configureLogger($this->loggers[$name]);
		}

		return $this->loggers[$name];
	}

	/**
	 * Configure new logger from the config file.
	 * @param JLogger $logger
	 */
	protected static function configureLogger(JLogger $logger) {
		if(self::$config === null) {
			//read config, setup root
			$node = simplexml_load_file(LOG_CONFIG_PATH);
			if($node) {
				foreach ($node->loggers->logger as $log) {
					$nm = (string)$log['name'];
					if($nm == '') trigger_error("Expecting logger name! Ignoring logger definition!", E_USER_WARNING);
					else {
						self::$config[$nm] = array();

						static $level_map = array(
							'none'	=> self::LEVEL_NONE,
							'error' => self::LEVEL_ERROR,
							'warning' => self::LEVEL_WARNING,
						 	'notice' => self::LEVEL_NOTICE,
							'debug' => self::LEVEL_DEBUG,
							'all'	=> self::LEVEL_ALL
						);

						$lv = strtolower(trim((string)$log['level']));
						if($lv != '' && isset($level_map[$lv])) {
							self::$config[$nm]['level'] = $level_map[$lv];
						} else trigger_error("Level attribute for logger '{$nm}' is empty or is not recognized ({$lv}), ignoring the attribute.", E_USER_WARNING);


						static $type_map = array(
							'error' => self::ERROR,
            				'warning' => self::WARNING,
							'notice' => self::NOTICE,
							'info' => self::INFO,
							'debug' => self::DEBUG,
							'pre-select' => self::PRE_SELECT,
							'pre-update' => self::PRE_UPDATE,
							'post-update' => self::POST_UPDATE,
							'enter' => self::ENTER,
							'leave' => self::LEAVE
						);


						$enable = 0;
						$disable = 0;
						foreach ($log->xpath('enable|disable') as $enbl) {
							$tp = strtolower(trim((string)$enbl['type']));
							if($tp == '' || !isset($type_map[$tp])) {
								trigger_error("The type attribute is missing or is not recognized ({$tp}) for element: ".$enbl->getName(), E_USER_WARNING);
								continue;
							}

							switch ($enbl->getName()) {
								case 'enable': $enable |= $type_map[$tp]; break;
								case 'disable': $disable |= $type_map[$tp]; break;

								default: trigger_error("Unknown element: {$enbl->getName()}, ignoring.", E_USER_WARNING);
							}
						}

						self::$config[$nm]['enable'] = $enable;
						self::$config[$nm]['disable'] = $disable;

						self::$config[$nm]['handlers'] = array();
						foreach ($log->handler as $hndl) {
							$cl = trim((string)$hndl['class']);
							if($cl != '') {
								if(!class_exists($cl)) {
									if(strspn($cl, ".\\/")) trigger_error("Strange class name '{$cl}', contains unsafe characters! Ignoring handler for logger '{$nm}'.", E_USER_WARNING);
									else {
										@include_once($cl.".class.php");
										if(!class_exists($cl)) trigger_error("Can't find handler class '{$cl}', this handler will be ignored for logger '{$nm}'!", E_USER_WARNING);
										else {
											$params = array();
											foreach ($hndl->param as $p) {
												$nm = trim((string)$p['name']);
												if($nm != '') $params[$p['name']] = (string)$p['value'];
												else trigger_error("Unnamed parameter for handler '{$cl}', ignoring.", E_USER_WARNING);
											}

											try {
												self::$config[$nm]['handlers'][] = new $cl($params);
											} catch (Exception $e) {
												trigger_error("Unexpected exception while initializing logger handler: ".$e->getMessage(), E_USER_WARNING);
											}
										}
									}
								}
							} else trigger_error("Handler class for logger '{$nm}' is not defined! Ignoring handler.", E_USER_WARNING);
						}
					}
				}
			} else trigger_error("Can't locate log config file: ".LOG_CONFIG_PATH, E_USER_WARNING);
		}

		$nm = $logger->getName();

		if(isset(self::$config['$'])) { //default config
			$cf = self::$config['$'];
			if(isset($cf['level'])) $logger->setLogLevel($cf['level']);
			$logger->enableMessage($cf['enable'], true, true);
			$logger->enableMessage($cf['disable'], false);
		}

		if(isset(self::$config[$nm])) {
			$cf = self::$config[$nm];
			if(isset($cf['level'])) $logger->setLogLevel($cf['level']);
			$logger->enableMessage($cf['enable'], true, true);
			$logger->enableMessage($cf['disable'], false);
		}
	}

	/**
	 * Set logging level.
	 *
	 * Higher the level means less info reported, with other words disabling messages
	 * by level is like explicitly disabling all messages in that and lower levels by
	 * <tt>enableMessage()</tt> calls.
	 *
	 * @param integer one of LEVEL_* constants
	 * @return void
	 */
	public function setLogLevel($level) {
		$this->loglevel = $level;
	}

	/**
	 * Returns current level.
	 * @return integer
	 */
	public function getLogLevel() {
		return $this->loglevel;
	}

	/**
	 * Enable/disable messages of specific type.
	 *
	 * Each log level is a collection of message types that
	 * will be reported on that level, however each message
	 * type can be enabled/disabled separately for ever more
	 * fine-tuning your logging. Messages of disabled type
	 * will not be reported even if current log level allows them.
	 *
	 * Note: $type is a bitmask, you may combine multiple message types
	 * by bitwise '|' operator.
	 *
	 * Note: enabling a message type will not automatically permit messages
	 * of that type, you will also need to set the logging level to include
	 * that message type. If $force is set, then this method will automatically
	 * lower the level.
	 *
	 * @param integer $type combination of message types defined as constants
	 * @param boolean $enable true (default) - enable message type, false - disable the message
	 * @param boolean $force lower the level if needed to actually enable the message
	 * @return void
	 */
	public function enableMessage($type, $enable = true, $force = true) {
		if($enable) $this->typemask |= $type;
		else $this->typemask &= ~$type;

		if($enable && $force) $this->loglevel = min($this->loglevel, $this->getLevel($type));
	}


	/**
	 * Returns true if message of requested type is enabled.
	 *
	 * The message will be reported if an only if:
	 *	- current level allows message of specified type
	 *  - current message mask explicitly enables this message type
	 *
	 * Note: the $type is not a bitmask of multiple types, it allows one one type!
	 *
	 * @param integer $type one of message type constants
	 * @return boolean true if message of specified $type will be reported
	 */
	public function isEnabled($type) {
		return (($this->typemask & $type) == $type) && (self::$TYPE_TO_LEVEL[$type] >= $this->loglevel);
	}

	/**
	 * Returns the lowest (most including) level that will enable all of the
	 * messages specified in $type.
	 *
	 * @param integer $type combination of message types defined as constants
	 * @return integer the lowest (most including) level
	 */
	public function getLevel($type) {
		$level = self::LEVEL_NONE;

		foreach (self::$TYPE_TO_LEVEL as $tp => $lv) {
			if(($type & $tp) != 0) $level = min($level, $lv);
		}

		return $level;
	}

	/**
	 * Returns non localized (english) name of the message type.
	 * @throws InvalidArgumentException if $type is not of the message type constantss
	 * @param integer $type one of the type constants
	 * @return string name of the type
	 */
	public static function getTypeName($type) {
		static $type_names = array(
			self::ERROR => 'Error',
			self::WARNING => 'Warning',
			self::NOTICE => 'Notice',
			self::INFO => 'Info',
			self::DEBUG => 'Debug',
			self::PRE_SELECT => 'Pre-select',
			self::PRE_UPDATE => 'Pre-update',
			self::POST_UPDATE => 'Post-update',
			self::ENTER => 'Enter',
			self::LEAVE => 'Leave',
		);

		if(isset($type_names[$type])) return $type_names[$type];
		throw new InvalidArgumentException("Unknown message type: {$type}");
	}

	/**
	 * Returns last name in the logger name path.
	 * @return string possibly represents the subsystem name
	 */
	public function getNodeName() {
		return $this->node_name;
	}

	/**
	 * Returns name path of this logger.
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Add handler to this loggers receivers list.
	 * Note: it is better to define handlers in the the config file.
	 *
	 * @param JLoggerHandler $handler will receive logger messages
	 * @return void
	 */
	public function addLogHandler(JLoggerHandler $handler) {
		$this->handlers[] = $handler;
	}

	/**
	 * Remove handler from the receivers list.
	 * @param JLoggerHandler $handler
	 * @return void
	 */
	public function removeLogHandler(JLoggerHandler $handler) {
		foreach ($this->handlers as $k => $h) {
			if($h === $handler) {
				unset($this->handlers[$k]);
				break;
			}
		}
	}

	/**
	 * List registered handlers.
	 * @return JLoggerHandler
	 */
	public function listLogHandlers() {
		return $this->handlers;
	}



//========================- Reporting messages -=================================
	/**
	 * Generic report message method.
	 * This method sends the message to all handlers and the parent logger if
	 * message is enabled.
	 *
	 * The optional $data argument allows providing more environment info assuming
	 * the target handler knows how to handle that data. Any unknown data will be
	 * ignored by the log handlers.
	 *
	 * @param integer $type one of the message type constants
	 * @param string $message the message body
	 * @param Exception $cause original exception if any
	 * @param mixed $data additional data provided with the message
	 * @return void
	 */
	public function log($type, $message, $cause = null, $data = null) {
		if($this->isEnabled($type)) {
			foreach ($this->handlers as $hndl) $hndl->receiveMessage($type, $message, $cause, $data);
			if($this->parent) $this->parent->log($type, $message, $cause, $data);
		}
	}

	/**
	 * Report 'ERROR' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function error($msg, $cause = null, $data = null) {
		$this->log(self::ERROR, $msg, $cause, $data);
	}

	/**
	 * Report 'WARNING' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function warning($msg, $cause = null, $data = null) {
		$this->log(self::WARNING, $msg, $cause, $data);
	}

	/**
	 * Report 'NOTICE' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function notice($msg, $cause = null, $data = null) {
		$this->log(self::NOTICE, $msg, $cause, $data);
	}

	/**
	 * Report 'INFO' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function info($msg, $cause = null, $data = null) {
		$this->log(self::INFO, $msg, $cause, $data);
	}

	/**
	 * Report 'DEBUG' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function debug($msg, $cause = null, $data = null) {
		$this->log(self::DEBUG, $msg, $cause, $data);
	}

	/**
	 * Report 'PRE-SELECT' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function preSelect($msg, $cause = null, $data = null) {
		$this->log(self::PRE_SELECT, $msg, $cause, $data);
	}

	/**
	 * Report 'PRE-UPDATE' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function preUpdate($msg, $cause = null, $data = null) {
		$this->log(self::PRE_UPDATE, $msg, $cause, $data);
	}

	/**
	 * Report 'POST-UPDATE' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function postUpdate($msg, $cause = null, $data = null) {
		$this->log(self::POST_UPDATE, $msg, $cause, $data);
	}

	/**
	 * Report 'ENTER' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function enter($msg, $cause = null, $data = null) {
		$this->log(self::ENTER, $msg, $cause, $data);
	}

	/**
	 * Report 'LEAVE' message.
	 * @param string $msg the messgae
	 * @param Exception $cause original exception
	 * @param mixed $data optional data
	 * @return void
	 */
	public function leave($msg, $cause = null, $data = null) {
		$this->log(self::LEAVE, $msg, $cause, $data);
	}
}


/**
* Generic log handler interface.
*
* @author Sardar Yumatov (ja.domga@gmail.com)
*/
interface JLoggerHandler {

	/**
	 * Receive log message.
	 * @param string $type message type
	 * @param string $message the message
	 * @param Exception $cause original exception
	 * @param mixed $data optional data, may be safely ignored
	 * @return void
	 */
	public function receiveMessage($type, $message, $cause = null, $data = null);
}



//=============================- Specific loggers -===================================

/**
* Collects all the messages.
* This handler simply collects all passed messages, but doesn't print them in any way.
*
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class CollectorJLoggerHandler implements JLoggerHandler {

	/** @var array collected messages */
	protected $messages = array();

	/**
	 * Construct the handler.
	 * @param array $params associative array with parameters
	 */
	public function __construct($params = null) { }

	/**
	 * Receive log message.
	 * @param string $type message type
	 * @param string $message the message
	 * @param Exception $cause original exception
	 * @param mixed $data optional data, may be safely ignored
	 * @return void
	 */
	public function receiveMessage($type, $message, $cause = null, $data = null) {
		$this->messages[] = array(
			'type' => $type,
			'message' => $message,
			'cause' => $cause,
			'data' => $data
		);
	}

	/**
	 * List all collected messages.
	 * @return array of ['type', 'messsage', 'cause', 'data']
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * Echo all collected messages.
	 * @return void
	 */
	public function printMessages() {
		foreach ($this->messages as $msg) {
			$tpnm = JLogger::getTypeName($msg['type']);
			if(isset($msg['cause'])) $err = "\nError trace:\n".$msg['cause']->__toString()."\n";
			else $err = "\n";

echo <<<PHPEOF
{$tpnm}: {$msg['message']} {$err}
PHPEOF;
		}
	}
}



/**
* Simply echo everything.
* @author Sardar Yumatov (ja.doma@gmail.com)
*/
class EchoJLoggerHandler implements JLoggerHandler {

	/**
	 * Construct the handler.
	 * @param array $params associative array with parameters
	 */
	public function __construct($params = null) { }

	/**
	 * Receive log message.
	 * @param string $type message type
	 * @param string $message the message
	 * @param Exception $cause original exception
	 * @param mixed $data optional data, may be safely ignored
	 * @return void
	 */
	public function receiveMessage($type, $message, $cause = null, $data = null) {
		$tpnm = JLogger::getTypeName($type);
		if($cause) $err = "\nError trace:\n".$cause->__toString()."\n";
		else $err = "\n";

echo <<<PHPEOF
{$tpnm}: {$message} {$err}
PHPEOF;
	}
}
?>