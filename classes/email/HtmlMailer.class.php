<?php

require_once('PHPMailer.class.php');

class MailerException extends Exception {}

/*
	Class: HtmlMailer
	Sends Smarty templated emails.

	The current implementation uses PHPMailer to actually send the emails.
*/
class HtmlMailer {
	private $smarty;
	private $template;
	private $mailer;

	/*
		Constructor: __construct
		Creates a new HtmlMailer

		Parameters:
		$smarty - An instance of a Smarty object to use to parse the HTML emails.
	*/
	public function __construct($smarty) {
		$this->smarty = $smarty;
		$this->mailer = new PHPMailer();
		$this->mailer->CharSet = 'utf-8';
	}

	// Group: Mail configuration

	/*
		Method: addAddress
		Adds a new To: address.

		Parameters:
		$email - The email to send the message to
		$name  - The displayed name for this email address
	*/
	public function addAddress($email, $name = '') {
		$this->mailer->AddAddress($email, $name);
	}

	/*
		Method: addCC
		Adds a new CC: address.

		Parameters:
		$email - The email to send the message to
		$name  - The displayed name for this email address
	*/
	public function addCC($email, $name = '') {
		$this->mailer->AddCC($email, $name);
	}

	/*
		Method: addBCC
		Adds a new BCC: address.

		Parameters:
		$email - The email to send the message to
		$name  - The displayed name for this email address
	*/
	public function addBCC($email, $name = '') {
		$this->mailer->AddBCC($email, $name);
	}

	/*
		Method: addReplyTo
		Adds a new reply-to address.

		Parameters:
		$email - The email to reply to
		$name  - The displayed name for this email address
	*/
	public function addReplyTo($email, $name = '') {
		$this->mailer->AddReplyTo($email, $name);
	}

	/*
		Method: clearAddresses
		Clears all To: addresses
	*/
	public function clearAddresses() {
		$this->mailer->ClearAddresses();
	}

	/*
		Method: setFrom
		Sets the From email

		Parameters:
		$email - The email the message is sent from
		$name  - The displayed name for this email address
	*/
	public function setFrom($email, $name = '') {
		$this->mailer->From = $email;
		$this->mailer->FromName = $name;
	}

	// Group: Mail content

	/*
		Method: setSubject
		Sets the subject of the email.

		Parameters:
		$subject - The subject of the email.
	*/
	public function setSubject($subject) {
		$this->mailer->Subject = $subject;
	}

	/*
		Method: setTemplate
		Sets the master template for the HTML part of the email.

		Parameters:
		$file - The filename of the template.
	*/
	public function setTemplate($file) {
		$this->template = $file;
	}

	/*
		Method: setContent
		Sets the content template for the HTML part of the email.

		Parameters:
		$file - The filename of the template.
	*/
	public function setContent($file) {
		$this->assign('smartyData', array('contentFile' => $file));
	}

	/*
		Method: setMessagePlain
		Sets the plain-text version of the email.
		If no plain-text version is specified, it will be generated from the HTML version.

		Parameters:
		$content - The plain text content string.
	*/
	public function setMessagePlain($content) {
		$this->mailer->AltBody = $content;
	}

	/*
		Method: assign
		Assigns a value to a smarty variable.
	*/
	public function assign($name, $value) {
		$this->smarty->assign($name, $value);
	}

	/*
		Method: assignByRef
		Assigns a value to a smarty variable, by reference.
	*/
	public function assignByRef($name, &$value) {
		$this->smarty->assign_by_ref($name, $value);
	}

	/*
		Group: Mail attachments
		Valid encoding types for the functions in
		this group are:

		base64           - base64 encoding, generally used for binary attachments.
		7bit, 8bit       - Plain text, line endings will be corrected.
		binary           - Given data is included literally.
		quoted-printable - Quoted-printable encoding, generally used for the HTML part.
	*/

	/*
		Method: addAttachment
		Adds a file on disk to the email.

		Parameters:
		$path     - The path to the file to attach.
		$name     - The name of the file as which it will be visible in the email. Defaults to the attached file's name.
		$encoding - The encoding method to use for this attachment.
		$type     - The MIME type of the attachment.
	*/
	public function addAttachment($path, $name = false, $encoding = 'base64', $type = 'application/octet-stream') {
		if (!$name)
			$name = basename($path);
		if (!$this->mailer->addAttachment($path, $name, $encoding, $type))
			throw new MailerException('Could not attach file: '.$this->mailer->ErrorInfo);
	}

	/*
		Method: addStringAttachment
		Adds a given string to the email as an attachment.

		Parameters:
		$string   - The attachment data.
		$name     - The name of the file as which it will be visible in the email.
		$encoding - The encoding method to use for this attachment.
		$type     - The MIME type of the attachment.
	*/
  public function addStringAttachment($string, $name, $encoding = 'base64', $type = 'application/octet-stream') {
		if (!$this->mailer->addStringAttachment($string, $name, $encoding, $type))
			throw new MailerException('Could not attach string: '.$this->mailer->ErrorInfo);
	}

  /*
		Method: addEmbeddedImage
		Adds an image to the email and makes it referrable with a cid: link.

		Parameters:
		$path     - The path to the file to attach.
		$cid      - The cid under which the image should be accessible.
		$name     - The name of the file as which it will be visible in the email. Defaults to the attached file's name.
		$encoding - The encoding method to use for this attachment.
		$type     - The MIME type of the attachment. Make sure this is an image/ type.
  */
  public function addEmbeddedImage($path, $cid, $name = false, $encoding = 'base64', $type = 'application/octet-stream') {
		if (!$name)
			$name = basename($path);
		if (!$this->mailer->addEmbeddedImage($path, $cid, $name, $encoding, $type))
			throw new MailerException('Could not attach image: '.$this->mailer->ErrorInfo);
	}



	// Group: Mail sending

	/*
		Method: preview
		Gives a preview of the email to be sent

		Returns:
		The HTML version of the email as it would be sent out.
	*/
	public function preview() {
		return $this->smarty->fetch($this->template);
	}

	/*
		Method: send
		Sends out the email to the addresses given via the <Mail configuration> functions.
	*/
	public function send() {
		$this->mailer->Body = $html = $this->smarty->fetch($this->template);

		$this->mailer->WordWrap = 70;
		$this->mailer->IsHTML(true);


		if (!$this->mailer->AltBody)
			$this->mailer->AltBody = preg_replace(array('/^[ \t]+/m', '/(\r\n){2,}/'), array('', "\r\n\r\n"), strip_tags($html));

		if (!$this->mailer->Send())
			throw new MailerException('Email sending failed: '.$this->mailer->ErrorInfo);
	}
}
?>