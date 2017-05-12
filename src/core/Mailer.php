<?php
namespace core;

use \PHPMailer;
use \app\Config;
use \core\Utilities;
/**
 * Mailer class
 */
class Mailer
{
	/**
	 * The PHPMAILER object
	 *
	 * @var object
	 */
	private $mailer = null;

	/**
	 * This is the constructor for the mailer
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * This will setup the mailer object
	 *
	 * @param boolean $force Should we force a new setup for the mailer
	 *
	 * @return boolean True on success false otherwise
	 */
	public function init($force = false)
	{
		if ($force || $this->mailer === null)
		{
			try
			{
				// Force empty the mailer object
				$this->mailer = null;

				// Initialize the base mailer with PHPMAILER
				$this->mailer = new PHPMailer;

				// Define that all mail will by default be using HTML
				$this->mailer->isHTML(true);

				// Define that all mail will be done through SMTP
				$this->mailer->isSMTP();

				// Setup the SMTP login information
				$this->mailer->SMTPAuth = true;
				$this->mailer->SMTPSecure = 'ssl';
				$this->mailer->Host = Config::$MAILER_DATA['send']['host'];
				$this->mailer->Port = Config::$MAILER_DATA['send']['port'];
				$this->mailer->Username = Config::$MAILER_DATA['send']['user'];
				$this->mailer->Password = Config::$MAILER_DATA['send']['pass'];

				// Set the default headers
				$this->mailer->setFrom(Config::$MAILER_DATA['send']['user'], Config::$MAILER_DATA['send']['title']);
				$this->mailer->addReplyTo(Config::$MAILER_DATA['reply']['user'], Config::$MAILER_DATA['reply']['title']);

				// If all is well
				return true;
			}
			catch (Exception $e)
			{
				throw new \Exception($e, 500);
				return false;
			}
		}
		return true;
	}

	/**
	 * Add another recipient to the new email
	 *
	 * @param string $email The email to send the email to
	 * @param string $name The email user's name
	 *
	 * @return void
	 */
	public function addRecipient($email, $name = null)
	{
		if ($name === null)
			$name = $email;

		$this->mailer->addAddress($email, $name);
	}

	/**
	 * Add a CC recipient to the new email
	 *
	 * @param string $email The email to send the email to
	 *
	 * @return void
	 */
	public function addCC($email)
	{
		$this->mailer->addCC($email);
	}

	/**
	 * Add a BCC recipient to the new email
	 *
	 * @param string $email The email to send the email to
	 *
	 * @return void
	 */
	public function addBCC($email)
	{
		$this->mailer->addBCC($email);
	}

	/**
	 * Add an attachment to the new email
	 *
	 * @param string $path The file path
	 * @param string $name The file name
	 *
	 * @return void
	 */
	public function addAttachment($path, $name = null)
	{
		if ($name !== null)
			$this->mailer->addAttachment($path, $name);
		else
			$this->mailer->addAttachment($path);
	}

	/**
	 * Set if the email will be HTML or not
	 *
	 * @param boolean $value Is it HTML or not
	 *
	 * @return void
	 */
	public function html($value = true)
	{
		$this->mailer->isHTML($value);
	}

	/**
	 * Set the email subject
	 *
	 * @param string $value Set the email subject
	 *
	 * @return void
	 */
	public function subject($value)
	{
		$this->mailer->Subject = $value;
	}

	/**
	 * Set the email body
	 *
	 * @param string $value Set the email body
	 *
	 * @return void
	 */
	public function body($value)
	{
		$this->mailer->Body = $value;
	}

	/**
	 * Set the email alt body
	 *
	 * @param string $value Set the email alt body
	 *
	 * @return void
	 */
	public function altBody($value)
	{
		$this->mailer->AltBody = $value;
	}

	/**
	 * This will fill out an email template's variables
	 *
	 * @param string $path The email template's path
	 * @param array $vars The vars that you would like to fill out
	 *
	 * @return string Filled message or false on failure
	 */
	public function fillTemplate($path, $vars = [])
	{
		if (file_exists($path))
			$message = file_get_contents($path);
		else
			return false;

		if (is_array($vars) && !empty($vars))
		{
			foreach ($vars as $key => $value)
				$message = str_replace('{{' . $key . '}}', $value, $message);
		}

		return $message;
	}

	/**
	 * Send the email
	 *
	 * @return boolean true if the message was sent and an error if it was not
	 */
	public function send()
	{
		if (!Config::$PRODUCTION)
			return $this->saveEmailToFile();

		if ($this->mailer->send())
		{
			$this->mailer = null;
			return true;
		}
		else
			return $this->mailer->ErrorInfo;
	}

	/**
	 * This will save the email to a file
	 *
	 * @return boolean
	 */
	public function saveEmailToFile()
	{
		$this->addRecipient('the@local.host', 'Local Host');
		$this->mailer->preSend();

		$email = $this->mailer->getSentMIMEMessage();
		$dir = '../emails/';

		$path = $dir . Utilities::getNow(true) . '.eml';

		if (!is_dir($dir))
			mkdir($dir);

		$file = fopen($path, 'w');

		$rtn = fwrite($file, $email);

		fclose($file);

		return $rtn;
	}
}
