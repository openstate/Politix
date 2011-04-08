<?php

/*
	Class: Message
	Allows passing around of messages across page requests.
*/
class MessageQueue {
	// Group: Queue

	// Property: $messages
	// Contains the list of messages that have been added.
	protected static $messages = array();

	// Method: addMessage
	// Adds a message to the queue. Only used internally.
	public static function addMessage(Message $msg) {
		self::$messages[$msg->group][]= $msg;
	}

	// Method: serialize
	// Saves the message queue to the session. This method must be called before the session
	// is written.
	public static function serialize() {
		if (count(self::$messages)>0)
			$_SESSION['messages'] = self::$messages;
	}

	// Method: serialize
	// Restores the message queue from the session. This method should be called before <getMessages>
	// is called, or a new message is added.
	public static function unserialize() {
		if (isset($_SESSION['messages'])) {
			self::$messages = $_SESSION['messages'];
			unset($_SESSION['messages']);
		}
	}

  /*
  	Method: getMessages
		Retrieves part or all of the queued messages.

		Note that it is not required to retrieve all message groups in one page request. Those messages
		that have not been processed will remain in the session until they are processed.

		Parameters:
		$group - The name of the group of messages to retrieve. If this is *false*, all messages are
		         returned.

		Returns:
		An array of <Message> objects.
  */
	public static function getMessages($group = false) {
		if (!$group) {
			$result = array();
			foreach (self::$messages as $grp)
				$result = array_merge($result, $grp);
			self::$messages = array();
			return $result;
		} else if (isset(self::$messages[$group])) {
			$grp = self::$messages[$group];
			unset(self::$messages[$group]);
			return $grp;
		} else
			return array();
	}
}

class Message {
	const SUCCESS = 0;
	const DEBUG   = 1;
	const NOTICE  = 2;
	const WARNING = 3;
	const ERROR   = 4;

	private static $def_titles = null;

	// Property: $type
	// One of the <Message types> for the message.
	protected $type;
	// Property: $title
	// The title of the message.
	protected $title;
	// Property: $message
	// The actual message content of the message.
	protected $message;
	// Property: $group
	// The group of the message.
	protected $group;

	// Group: Message methods
	/*
		Constructor: __construct
		Creates a new Message.

		When creating a message, they are automatically added to the message queue, so generally
		it is not needed to actually store the result of the constructor call.

		Parameters:
		$type    - The <Message type> of the message.
		$message - The actual message content of the message.
		$title   - The title of the message.
		$group   - The group of the message. Use this to group messages by where they should appear in the
		           page.
	*/
	public function __construct($type, $message, $title = false, $group = false) {
		$this->type = $type;
		$this->title = ($title === false) ? $this->getDefaultTitle() : $title;
		$this->message = $message;
		$this->group = ($group === false) ? Dispatcher::inst()->getModule() : $group;
	}

	private function getDefaultTitle() {
		if (!isset(self::$def_titles)) {
			require_once('GettextPO.class.php');
			self::$def_titles = new GettextPO('../locale/'.(Dispatcher::inst()->locale ? Dispatcher::inst()->locale : 'nl').'/message.po');
		}
		return self::$def_titles->getMsgStr('message_'.strtolower($this->getTypeName()).'_title');
	}

	/*
		Method: __get
		Allows read-only access to the <Message properties>
	*/
	public function __get($name) {
		if (isset($this->$name))
			return $this->$name;
		else
			throw new Exception('Reading non-existent property '.get_class($this).'::$'.$name);
	}

	public function getTypeName() {
		switch ($this->type) {
		case self::NOTICE: return 'Notice';
		case self::WARNING: return 'Warning';
		case self::ERROR: return 'Error';
		case self::DEBUG: return 'Debug';
		case self::SUCCESS: return 'Success';
		default: return '';
		}
	}
}

?>