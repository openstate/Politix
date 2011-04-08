<?php

/*
	Class: DefaultHandler
	Generic handler for url-to-page mapping.

	This handler is for the 'default' module, a module designed to allow simple (generally project-specific)
	pages to be added, with pageset support. It also serves as an example of how to make a Handler class.

	This module maps urls of the
	form:

	/path/to/page

	to pages found
	in:

	/pages/[pageset]/path/to/pagePage.class.php

	It also maps the url / to /home/indexPage, and /path/to/page can map to both
	/path/to/pagePage and /path/to/page/indexPage (the former is tried first).
*/
class defaultHandler {
	/*
		Property: $urlMap
		Lists the handled URLs.

		This property is an associative array of regular expressions to method names. If the URL of the
		page request matches the regex, the associated method is called.
	*/
	public $urlMap = array(
		'!^(/[a-zA-Z0-9]+)*?(/[0-9]+)?/?$!' => 'handler'
	);

	/*
		Method: handler
		Example of a URL match handler.

		Whenever a <$urlMap> entry is matched, the method from that match is called. Like this
		method, it must have two parameters. Its purpose is to take the regex match result,
		and check whether it can actually serve this request. If so, it returns an appropriate
		page, otherwise it returns *false*, and the dispatcher will continue searching for
		a handler that can serve the URL.

		Parameters:
		$match    - The match result of the regular expression (as the 3rd parameter of preg_match).
		$pageSets - An array of pagesets the current site uses.

		Returns:
		An associative array with the following keys:

		file  - The location of the file that contains the page to execute.
		class - The name of the class to execute.
		get   - An array that is merged with the $_GET array before being given to the page class.

		If no matching page is found, returns *false*.
	*/
	public function handler($match, array $pageSets) {			
		$parts = explode('/', $match[0]);
		$parts = array_slice($parts, 1);
		if ($parts[count($parts)-1] == '')
			$parts = array_slice($parts, 0, -1);

		if (count($parts) > 0 && ctype_alnum($parts[count($parts)-1]) && strlen($parts[count($parts)-1]) == 40) {
			$hash = $parts[count($parts)-1];
			$parts = array_slice($parts, 0, -1);
		}

		if (count($parts) > 0 && ctype_digit($parts[count($parts)-1])) {
			$id = $parts[count($parts)-1];
			$parts = array_slice($parts, 0, -1);
		}
		
		$pageClass = 'class';
		$fileName = '/'.implode('/', array_slice($parts, 0, -1));

		if (count($parts) > 0) {
			$lastPart = $parts[count($parts)-1];
			$lastPart = array($lastPart => '/php/'.$lastPart.'Page.class.php', 'index' => $lastPart.'/php/indexPage.class.php');
		} else {
			$lastPart = array('index' => 'home/php/indexPage.class.php');
		}

		foreach ($pageSets as $set) {
			foreach ($lastPart as $class => $file) {				
				if (file_exists($_SERVER['DOCUMENT_ROOT'].'/../pages/'.$set.$fileName.$file)) {
					$fileName = $_SERVER['DOCUMENT_ROOT'].'/../pages/'.$set.$fileName.$file;
					$className = $class.'Page';
					break 2;
				}
			}
		}		
		if (!isset($className))
			return false;

		$get = array();
		if (isset($id)) $get['id'] = $id;
		if (isset($hash)) $get['hash'] = $hash;

		return array(
			'file'  => $fileName,
			'class' => $className,
			'get'   => $get
		);
	}
}

?>