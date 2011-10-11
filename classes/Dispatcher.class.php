<?php

require_once('Style.class.php');
require_once('Region.class.php');
require_once('Page.class.php');
require_once('Category.class.php');
require_once('CustomSmarty.class.php');
require_once('BlockHandler.class.php');
require_once('Query.class.php');
require_once('SearchQuery.class.php');

class DataException extends Exception {
	protected $data;

	public function __construct($message, $data) {
		parent::__construct($message);
		$this->data = $data;
	}

	public function getData() { return $this->data; }

	public function __toString() {
		return parent::__toString().'<br />Data: <pre>'.$this->getData().'</pre>';
	}
}

/*
	Class: Dispatcher
	This class finds the right page to call for a given page request.

	Unlike previous incarnations of the framework, it is no longer a singleton. This makes
	it possible (or at least a lot easier) to subclass it for project-specific functionality.
	This is the preferred method of customizing the dispatcher since upgrading the dispatcher
	is simpler when it isn't a blend of basic and custom features.
*/
class Dispatcher {
	// Group: Global properties
	// Since the dispatcher is globally available (via <inst>), any public properties are
	// available everywhere.

	// Property: $user
	// Holds the active user for this page request.
	public $user;

	// Property: $subdomain
	// The subdomain of the active site.
	public $subdomain = '';

	// Property: $domain
	// The domain of the active site.
	public $domain = '';

	// Property: $tld
	// The tld of the active site.
	public $tld = '';

	// Group: Protected properties

	// Property: $smarty
	// A Smarty instance.
	protected $smarty;

	// Property: $pageInfo
	// Contains information on the page to execute for the current request.
	// This is the returned information from a url handler, see <DefaultHandler::handler> for
	// more information.
	protected $pageInfo;

	// Property: $activeSite
	// The <Site> that was determined as the active one for this request.
	public $activeSite;

	// Property: $locale
	// The locale code that was determined as the active one for this request.
	public $locale = false;

	public $region = false;

	// Property $style
	// The style associated with the request, fo only.
	public $style;

	// Property: $blocks
	// ????
	protected $blocks;

	// Group: global access

	// Property: $inst
	// The main Dispatcher instance.
	// Initialized when the dispatcher is constructed.
	protected static $inst = null;

	// Method: inst
	// Returns the main instance of this dispatcher.
	public static function inst() {
		if (!self::$inst)
			throw new Exception('Dispatcher is not initialized yet.');
		return self::$inst;
	}

	// Group: Utility functions

	/*
		Method: header
		Outputs a Location: header along with HTTP status 302 Moved temporarily.

		Parameters:
		$location - The URL to header to. May be relative or absolute.

		This method will construct an absolute URL if necessary, which is required
		for Location headers according to the HTTP specifications.
	*/
	public static function header($location) {
		if (substr($location, 0, 4) != 'http') {
			// Make an absolute path
			if ($location[0]=='/')
				$location = 'http://'.$_SERVER['HTTP_HOST'].$location;
			else {
				$location = str_replace('/./', '/', rtrim($_SERVER['PHP_SELF'], '\\/').'/'.$location);  // Current directory
				// Resolve parent directories
				do {
					$location = preg_replace('|/[^.][^/]*/\.\./|', '/', $location, -1, $count);
				} while ($count>0);
				$location = str_replace('/..', '', $location);  // Unresolved parent dirs
				$location = 'http://'.$_SERVER['HTTP_HOST'].$location;
			}
		}
		self::$inst->finalize();
		header('HTTP/1.1 302 found');
		header('Location: '.$location);

		die;
	}

	/*
		Method: forbidden
		Outputs a page indicating the user may not access this page.
		Also outputs a 403 Forbidden header.

		This method generally should be called when a user does not have the required rights to
		see a page.

		See also:
		<badRequest>
	*/
	public static function forbidden() {
		ob_clean();
		header('HTTP/1.1 403 Forbidden');
		self::$inst->initSmarty();
		self::$inst->smarty->setCurrDir($_SERVER['DOCUMENT_ROOT'].'/../templates/');
		self::$inst->smarty->setContentDir('header', '');
		self::$inst->smarty->setContentDir('content', '');

		$data = array('url' => $_SERVER['REQUEST_URI']);
		self::$inst->smarty->assign('data', $data);
		self::$inst->smarty->display('forbidden.html');

		self::$inst->finalize();
		die;
	}

	/*
		Method: badRequest
		Outputs a page indicating the page parameters (or other parts of the request) were malformed.
		Also outputs a 400 Bad Request header.

		This method should be called when a request fails to specify required data,
		which should be impossible when using the interface normally (e.g. failing to give
		an id to edit for an edit page, or failing to specify GET parameters which are
		always supplied via the interface).

		See also:
		<forbidden>
	*/
	public static function badRequest() {
		ob_clean();
		header('HTTP/1.1 400 Bad Request');
		echo '<h1>400 Bad Request</h1>';
		echo 'Your browser (or proxy) sent a request that this server could not understand.';

		self::$inst->finalize();
		die;
	}

	// Group: General

	/*
		Constructor: __construct
		Constructs a new Dispatcher.
		Also makes this instance available via the <inst> method.
	*/
	public function __construct() {
		self::$inst = $this;
	}

	public function getModule() {
		preg_match('!^/([A-Za-z]+)!', $_SERVER['REQUEST_URI'], $matches);
		return isset($matches[1]) ? $matches[1] : 'root';
	}

	public function isFrontoffice() {
		return in_array('watstemtmijnraad', @$this->activeSite['sets']);
	}

	private function catSort($p, $q) {
		return strcmp($p['name'], $q['name']);
	}

	/*
		Method: init
		Initializes the dispatcher.

		As part of the initialization, a new <User> is created, and an attempt is made to log in
		this user from a login cookie (See <User::cookieLogin>).

		Also, a check is performed to see if the request headers contain 'Cache-Control: no-cache'
		or 'Pragma: no-cache'. These are normally included only if a forced page refresh was requested
		in the browser. If this is the case, <refresh> is called.
	*/
	protected function init() {
		$user = UserFactory::create();
		if (!isset($_SESSION['user']) ||
		    get_class($user) != get_class($_SESSION['user'])) {
			$user->cookieLogin();
			$this->user = $user;
		} else {
			$this->user = $_SESSION['user'];
		}

		MessageQueue::unserialize();

		$headers = apache_request_headers();
		if ((isset($headers['Cache-Control']) && $headers['Cache-Control'] == 'no-cache') ||
		    (isset($headers['Pragma']) && $headers['Pragma'] == 'no-cache')) {
			$this->refresh();
		}
	}

	public static function sessionUser() {
		return @$_SESSION['user'];
	}

	/*
		Method: refresh
		Reloads data from the database.

		This method reloads data from the database that is normally serialized and stored in the
		session.
	*/
	protected function refresh() {
		$this->user->refresh();
	}

	/*
		Method: initSmarty
		Initializes a Smarty instance for this page request.

		The current Dispatcher instance is assigned to the smarty variable 'global' for
		access to the <Global properties> from within templates.
	*/
	protected function initSmarty() {
		if (!$this->smarty) {
			$this->smarty = new CustomSmarty($this->locale);

			if (isset($_GET['extern'])) {
				$this->smarty->setBaseTemplate($_SERVER['DOCUMENT_ROOT'].'/../templates/search.html');
				$this->smarty->assign('extern', true);
				output_add_rewrite_var('extern', 'true');
			} else {
				$this->smarty->setBaseTemplate($_SERVER['DOCUMENT_ROOT'].'/../templates/'.$this->activeSite['template']);
			}
			$this->smarty->setCurrDir(dirname($this->pageInfo['file']).'/');
			$this->smarty->assign_by_ref('global', $this);

			$this->smarty->assign('dayNames', $GLOBALS['fullDayNames']);
			$this->smarty->assign('monthNames', $GLOBALS['fullMonthNames']);
			$this->smarty->assign_by_ref('blocks', $this->blocks);
		}
	}

	/*
		Method: finalize
		Finalizes the page request.

		This includes saving all necessary variables to the session.
	*/
	public function finalize() {
		$_SESSION['user'] = $this->user;
		MessageQueue::serialize();
		Session::write_close(); // Write session before headering.
	}

	// Group: Dispatching

	/*
		Method: findSite
		Determines which <Site> is active based on a host name.

		Parameters:
		$host - The host name used to determine the current site.

		Returns:
		An array with two elements. The element on index 'site' is the <Site configuration> for the
		current site. The element on index 'host' contains a breakdown of the host into subdomain,
		domain and tld. If no matching host is found both elements will be *null*.
		found.
	*/
	protected function findSite($host) {
		$sitesConf = require('sites.include.php');
		foreach ($sitesConf as $hostPreg => $site) {
			if (preg_match($hostPreg, $host, $matches)) {
				return array('site' => $site, 'host' => $matches);
			}
		}
		return array('site' => null, 'host' => null);
	}

	/*
		Method setHost

		Parameters:
		$hostInfo - contains all the info about the host

	*/
	protected function setHost($hostInfo) {
		if (isset($hostInfo['subdomain'])) $this->subdomain = $hostInfo['subdomain'];
		if (isset($hostInfo['domain']))    $this->domain    = $hostInfo['domain'];
		if (isset($hostInfo['tld']))       $this->tld       = $hostInfo['tld'];
	}

	/*
		Method: findBrowserLanguage
		Determines which of a set of languages should be chosen based on browser preferences.
		This function parses the Accept-Language HTTP header, and determines which of a set
		of specified languages best matches the languages given in this header.

		Parameters:
		$langs - An array of HTTP language tags.

		Returns:
		The best matching code from the $langs array, or *false* if no match could be found.

		Notes:
		The format and contents of the language tags can be found in RFC 2616, section 3.10 and
		RFC 1766. Generally, ISO 639 two-letter codes should work.
	*/

	public function findBrowserLanguage(array $langs) {
		$langStr = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
		$qualities = array_fill_keys($langs, 0);

		if($langStr) {
			foreach (explode(',', $langStr) as $lang) {
				preg_match('/^([^;]+)(;\s*q\s*=\s*([0-9.]+))?/i', $lang, $parts);
				if (count($parts) <= 2)
					$quality = 1.0;
				else
					$quality = (float)$parts[3];
				$range = trim($parts[1]);

				if (isset($qualities[$range])) {
					// Language is available exactly
					$qualities[$range] = $quality;
				} else {
					// Try to find a prefix match:
					// The range should match the prefix of the tag, with the tag prefix
					// followed directly by '-'
					foreach ($qualities as $tag => $q)
						if ($q == 0 && substr($tag, 0, strlen($range)+1) == $range.'-') {
							$qualities[$tag] = 0.9 * $quality;  // Prefix matches are valued slightly lower than exact matches.
						}
				}
			}
		}

		arsort($qualities);

		if (reset($qualities) == 0)
			return false;
		else
			return key($qualities);
	}

	/*
		Method: findLocale
		Finds the locale to use for this page request.
		Uses the <$activeSite> to determine where to get the locale from. Currently, locale can be
		determined from:
		- A cookie
		- The browser's Accept-Language header
		- The hostname used in this request.

		Parameters:
		$host - The host name used to determine the locale, in case this is needed (note that this is used as a
		        last fallback, so it should always be given).

		Returns:
		A locale code string, or *false* if no locale could be found.
	*/
	public function findLocale($host) {
		foreach ($this->activeSite['locale']['source'] as $src) {
			if ($src == 'cookie' && isset($_COOKIE['language']) && in_array($_COOKIE['language'], $this->activeSite['locale']['locales']))
				// Locale cookie was set and valid, so use this one
				return $_COOKIE['locale'];

			if ($src == 'browser') {
				$locale = $this->findBrowserLanguage($this->activeSite['locale']['locales']);
				if ($locale)
					return $locale;
			}
		}

		// If no locale was found yet, use the default for the site
		if (!$this->locale) {
			foreach ($this->activeSite['locale']['defaults'] as $preg => $locale) {
				if (preg_match($preg, $host))
					return $locale;
			}
		}

		return $this->activeSite['locale']['locales'][0];

		//		return false;
	}

	/*
		Method: dispatch
		Performs dispatching for the current page request.

		Dispatching takes the following steps:
		- Find the current <Site>
		- Find the current locale
		- Calls <init>
		- Match the URL against configured <Modules> to determine the active module
		- Execute the initialization of the page returned for the active module
		- If POST data is available, execute the post process of the returned page
		- Initialize Smarty and execute the show method of the returned page

		- If any exceptions occur along the way, an exception page is displayed.
		- If no module or page could be matched against the current URL, a 404 page is displayed.
	*/
	public function dispatch() {
		$siteInfo = $this->findSite($_SERVER['HTTP_HOST']);
		$this->activeSite = $siteInfo['site'];

		if ($siteInfo['host'])
			$this->setHost($siteInfo['host']);

		if (!$this->activeSite)
			throw new Exception('No site specified for '.$_SERVER['HTTP_HOST']);

		// Find current locale to use
		$this->locale = $this->findLocale($_SERVER['HTTP_HOST']);
		if (!$this->locale)
			throw new Exception('No locale found for '.$_SERVER['HTTP_HOST']);

		// Init
		$this->init();

		$r = new Region();
        $r->load(2);
		$this->region = $r; //->loadByName($this->subdomain, 4);

		$this->pageInfo = false;
		$handler = null;

		foreach ($this->activeSite['modules'] as $module) {
			require_once($_SERVER['DOCUMENT_ROOT'].'/../modules/'.$module.'/'.$module.'Handler.class.php');

			$handlerClass = $module.'Handler';
			$handler = new $handlerClass();
			$scriptUrl = $_SERVER['SCRIPT_URL'] ? $_SERVER['SCRIPT_URL'] : $_SERVER['REQUEST_URI'];
			foreach ($handler->urlMap as $preg => $call) {
				if (preg_match($preg, $scriptUrl, $match)) {
					$this->pageInfo = $handler->$call($match, $this->activeSite['sets']);
					if ($this->pageInfo) {
						set_include_path(get_include_path().PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/../modules/'.$module.'/classes/');
						break 2;
					}
				}
			}
		}

		$this->blocks = new BlockHandler($this->activeSite['modules'], $handler);

		$this->initSmarty();

		if ($this->isFrontoffice()) {
			$this->smarty->assign('region_page', $this->region);
			try {
				$this->style = new Style(@$this->region->id);
			} catch (Exception $e) {
				$this->style = Style::getDefault();
			}
			$this->smarty->assign('style', $this->style);
		}

		if ($this->pageInfo && file_exists($this->pageInfo['file'])) {
			try {
				require_once($this->pageInfo['file']);
				$page = new $this->pageInfo['class']();

				if (is_callable(array($page, 'processGet')))
					$page->processGet(array_merge($_GET, $this->pageInfo['get']));

				if (!empty($_POST) && is_callable(array($page, 'processPost')))
					$page->processPost($_POST);

				if ($this->isFrontoffice()) {
					$ra = new Raadsstuk();
					$scriptUrl = $_SERVER['SCRIPT_URL'] ? $_SERVER['SCRIPT_URL'] : $_SERVER['REQUEST_URI'];
					if (null == $search = &$_SESSION['search'] || $search['fts'] || !preg_match('!/search!', $scriptUrl)) {
						if (null == $cache = &$_SESSION['categoryCount'] || CACHE_LIFETIME < (time() - @$cache['time'])) {
							$cache = array('time' => time(), 'results' => $ra->getCountByCategory((int) @$this->region->id));
						}
						$this->smarty->assign('cat_count', $cache['results']);
					} else {
						$result = array();
						$q = Query::fromString(http_build_query($_GET));
						foreach ($search['results'] as $sr) {
							if (is_array($sr->categories))
								foreach ($sr->categories as $cat) {
									if (null == $current = &$result[$cat['id']]) {
										$current['id'] = $cat['id'];
										$current['name'] = $cat['name'];
										$current['url'] = $q->insert('category', $cat['id'])->toString();
										$current['count'] = 0;
									}
									$current['count']++;
								}
						}
						usort($result, array($this, 'catSort'));
						$this->smarty->assign('cat_count', $result);
					}

					$p = new Page();
					$this->smarty->assign('menu_pages', $p->getVisiblePages($this->region));
				}

				if (is_callable(array($page, 'show'))) {
					header('Content-Language: '.$this->locale);
					$this->smarty->assign('messages', MessageQueue::getMessages($this->getModule()));
					$page->show($this->smarty);
				}
			}	catch (Exception $e) {
				$data = array(
					'message' =>   $e->getMessage(),
					'file' =>      $e->getFile(),
					'line' =>      $e->getLine(),
					'trace' =>     $e->getTrace(),
					'data' =>      $e instanceof DataException ? $e->getData() : false,
					'exception' => get_class($e),
					'developer' => DEVELOPER
				);

				if ($e instanceof DatabaseQueryException) {
					// Colorize SQL
					$data['sql'] =
						preg_replace('/\b(AS|LEFT|RIGHT|INNER|OUTER|JOIN|ON|TO|AND|OR|ASC|DESC)\b/i', '<span style="color:#00F">$1</span>',
						preg_replace('/\b(SELECT|INSERT|IGNORE|INTO|VALUES|UPDATE|SET|DELETE|REPLACE|RENAME|ALTER|TABLE|TRUNCATE|USE|USING|FROM|WHERE|GROUP|ORDER|BY|LIMIT|UNION)\b/i', '<span style="color:#008000">$1</span>',
						$e->getSQL()));
					$data['error'] = $e->getError();
				}

				if (!DEVELOPER) {
					require_once('HtmlMailer.class.php');
					$mail = new HtmlMailer(new CustomSmarty($this->locale));
					$mail->setTemplate($_SERVER['DOCUMENT_ROOT'].'/../emails/'.$this->activeSite['publicdir'].'/'.$this->activeSite['template']);
					$mail->setSubject('Exception for '.$this->activeSite['title']);
					$mail->setContent($_SERVER['DOCUMENT_ROOT'].'/../emails/exception.html');
					$mail->setFrom($this->activeSite['systemMail'], $this->activeSite['title']);

					$mail->assignByRef('data', $data);
					$mail->addAddress('exceptions@accepte.nl');
					$mail->send();
				}

				ob_clean();
				$this->smarty->setCurrDir($_SERVER['DOCUMENT_ROOT'].'/../templates/');
				$this->smarty->setContentDir('header', '');
				$this->smarty->setContentDir('content', '');
				$this->smarty->assign('data', $data);
				$this->smarty->display('exception.html');
			}
		} else {
			header('HTTP/1.1 404 Not Found');
			$this->smarty->setCurrDir($_SERVER['DOCUMENT_ROOT'].'/../templates/');
			$this->smarty->setContentDir('header', '');
			$this->smarty->setContentDir('content', '');

			$data = array('url' => $_SERVER['REQUEST_URI']);
			$this->smarty->assign('data', $data);
			$this->smarty->display('404.html');
		}

		$this->finalize();
	}
}

?>
