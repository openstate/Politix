<?php

require_once('Emails.class.php');

class AppointmentMailer {
	private $mail;
	private $appointment;

	public function __construct(PendingAppointment $appointment) {
		$emails = new Emails(Dispatcher::inst()->activeSite, Dispatcher::inst()->locale);
		$this->mail = $emails->get('appointmentmail');
		$this->appointment = $appointment;
	}

	public function send() {
		$politician = new Politician();
		$politician->load($this->appointment->politician);

		list($to, $cc) = $politician->getEmailAddresses();

		foreach ($to as $name => $email) $this->mail->addAddress($email, $name);
		foreach ($cc as $name => $email) $this->mail->addCc($email, $name);

		if (count($to) > 0) {
			$this->mail->assign('appointment',$this->appointment);
			$this->mail->assign('politician', $politician);
			$this->mail->send();
		}
	}
}

?>