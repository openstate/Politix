<?php

require_once('HtmlMailer.class.php');
require_once('CustomSmarty.class.php');
require_once('GettextPO.class.php');

/*
	Class: Emails
	Convenient wrapper for quickly creating <HtmlMailer> objects.

	In the /emails/ directory, for each site in their publicdir subdirectory, and for each module
	in an /emails/ directory, there should be present:
	- A master email template, named after the 'template' entry in the <Site configuration>.
	- A PO file named 'subjects.<lang>.po', with (for that language) the available email subjects.
	  The message ids are taken as identifiers of the emails themselves.
	- For each email, a .html file with a filename equal to one of the po file's message ids, containing
	  the content of that email.

	This class has to be instanced for a specific combination of site configuration and locale.
*/
class Emails {
	// Property: $siteConfig
	// The site configuration for which this class was instanced
	protected $siteConfig;
	// Property: $locale
	// The locale for which this class was instanced.
	protected $locale;

	// Property: $mails
	// An array of email ids to subjects and file locations for the current site config and locale.
	protected $mails = array();

	/*
		Constructor: __construct
		Creates a new Emails instance.

		Parameters:
		$siteConfig - The <Site configuration> to select emails for
		$locale     - The locale to use in sending emails
	*/
	public function __construct(array $siteConfig, $locale) {
		$this->siteConfig = $siteConfig;
		$this->locale = $locale;

		$this->loadSubjects();
	}

	/*
		Method: loadSubjects
		Loads all email subjects for this instance.
		This also determines which email ids are valid.
	*/
	protected function loadSubjects() {
		if (count($this->mails)>0)
			return;

		// Site-specific emails
		$subjPO = new GettextPO($_SERVER['DOCUMENT_ROOT'].'/../emails/'.$this->siteConfig['publicdir'].'/subjects.'.$this->locale.'.po');
		foreach ($subjPO->getEntryIDs() as $id) {
			$this->mails[$id] = array(
				'subject' => $subjPO->getMsgStr($id),
				'file' => $_SERVER['DOCUMENT_ROOT'].'/../emails/'.$this->siteConfig['publicdir'].'/'.$id.'.html'
			);
		}

		// Module-specific emails
		foreach ($this->siteConfig['modules'] as $mod) {
			$file = $_SERVER['DOCUMENT_ROOT'].'/../modules/'.$mod.'/emails/subjects.'.$this->locale.'.po';
			if (file_exists($file)) {
				$subjPO = new GettextPO($file);
				foreach ($subjPO->getEntryIDs() as $id) {
					$this->mails[$id] = array(
						'subject' => $subjPO->getMsgStr($id),
						'file' => $_SERVER['DOCUMENT_ROOT'].'/../modules/'.$mod.'/emails/'.$id.'.html'
					);
				}
			}
		}
	}

	/*
		Method: get
		Creates a <HtmlMailer> instance for a given email id.

		The email's master template, content template and subject are set based on the id given, and
		the from address is set to the site's system email as given in the <Site configuration>.

		Parameters:
		$name - The email id to retrieve a mailer for.

		Returns:
		A <HtmlMailer> instance
	*/
	public function get($name) {
		if (!isset($this->mails[$name]))
			throw new Exception('Attempt to create non-existing email: '.$name);

		$email = new HtmlMailer(new CustomSmarty($this->locale));
		$email->setTemplate($_SERVER['DOCUMENT_ROOT'].'/../emails/'.$this->siteConfig['publicdir'].'/'.$this->siteConfig['template']);
		$email->setSubject($this->mails[$name]['subject']);
		if (!file_exists($this->mails[$name]['file']))
			throw new Exception('Could not load email content file: '.$name);
		$email->setContent($this->mails[$name]['file']);
		$email->setFrom($this->siteConfig['systemMail'], $this->siteConfig['title']);

		$email->assign('global', Dispatcher::inst());

		return $email;
	}

	/*
		Method: getSubject
		Returns the subject string for a given email

		Parameters:
		$mailId - The email id to return the subject for.
	*/
	public function getSubject($mailId) {
		return $this->mails[$mailId]['subject'];
	}

	/*
		Method: validId
		Checks whether an email id is valid.

		Parameters:
		$id - The id to check
	*/
	public static function validId($id) {
		return isset($this->mails[$id]);
	}
}

?>