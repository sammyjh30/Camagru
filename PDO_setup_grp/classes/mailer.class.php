<?php

//Check if PHP version is valid
if (version_compare(PHP_VERSION, '5.0.0', '<')) {
	die("ERROR: PHPMailer only runs on version 5 or greater.\n");
}

//PHP class - create and transport?
class PHPMailer {

	//(int)Email priority (1 = High, 3 = Normal, 5 = Low)
	public $priority = 3;

	//(string)Set charset of the message (graphic character sets)
	public $charSet = 'iso-8859-1';

	//(string)Content-Type
	public $contentType = 'text/plain';

	//(string)Encoding of message.("8bit", "7bit", "binary", "base64", and "quoted-printable")
	public $encoding = '8bit';

	//(string)Will hold the most recent mailer error message.
	public $errorInfo = '';

	//(string)From email address for the message
	public $from = 'noreply@localhost.co.za';
	// public $from = 'root@localhost';

	//(string)From name of the message
	public $fromName = 'noreply';
	// public $fromName = 'Root User';

	//(string)Sender email (Return-Path) of the message
	//If empty, be sent via -f to sendmail or as 'MAIL FROM' in smtp mode
	public $sender = '';

	//(string)Return-Path of the message
	//If empty, it will be set to either From or Sender.
	public $returnPath = '';

	//(string)Subject of message
	public $subject = '';

	//(string)Body of message
	public $body = '';

	//(string)Plain-text message body. Can be read by clients that don't have HTML email
	//Clients that can read html will view the normal Body
	public $altBody = '';

	//Constructor
	public function __construct($exceptions = false) {
		$this->exceptions = ($exceptions == true);
	}

	//Destructor
	public function __destruct() {
		if ($this->mailer == 'smtp') {
			//Close any open SMTP connection nicely
			$this->smtpClose();
		}
	}

	//Set Mailer to send message using SMTP
	public function isSMTP() {
		$this->mailer = 'smtp';
	}

	//Close the active SMTP session if it exists
	public function smtpClose() {
		if ($this->smtp !== null) {
			if ($this->smtp->connected()) {
				$this->stmp->quit();
				$this->stmp->close();
			}
		}
	}
}
?>