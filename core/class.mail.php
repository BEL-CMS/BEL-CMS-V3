<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.3 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;

use DateTime;
use BelCMS\Requires\Common;
use BelCMS\Core\Secure;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class eMail
{
	public	$fromName,
			$fromMail,
			$toMail,
			$senderName,
			$subject,
			$header,
			$body,
			$footer,
			$content,
			$sendMail,
			$html;
	private $date;

	public function __construct()
	{
		$this->date = new DateTime('now');
		$this->date->format('d/m/Y à H:i:s');

		if (!defined("PHP_EOL_MAIL")) define("PHP_EOL_MAIL", "\r\n");

		$this->fromName   = self::fromName();
		$this->fromMail   = self::fromMail();
		$this->toMail     = self::toMail();
		$this->senderName = self::senderName();
		$this->subject    = self::subject();
		$this->header     = self::header();
		$this->body       = self::body();
		$this->footer     = self::footer();
	}

    public function fromName ($data = null)
	{
		$this->fromName = !empty($data) ? Common::VarSecure($data, null) : $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
	}

	public function fromMail ($data = null)
	{
		$this->fromMail = !empty($data) ? Secure::isMail($data) : $_SERVER['SERVER_ADMIN'];
	}

	public function toMail ($data = null)
	{
		$this->toMail = !empty($data) ? Secure::isMail($data) : '';
	}

	public function senderName ($data = null)
	{
		$this->senderName = !empty($data) ? Common::VarSecure($data, 'null') : '';
	}

	public function subject ($data = null)
	{
		$this->subject = !empty($data) ? Common::VarSecure($data, 'null') : '';
	}

	public function header ($data = null)
	{
		$this->header = Common::VarSecure($data, 'html');
	}

	public function body ($data = null)
	{
		$this->body = Common::VarSecure($data, 'html');
	}

	public function footer ($data = null)
	{
		$this->footer = Common::VarSecure($data, 'html');
	}

	public function send ()
	{
		$name     = $this->fromName;
		$email    = $this->fromMail;
		$address  = $this->toMail;
		
		$e_body    = stripslashes($this->header);
		$e_content = stripslashes($this->body);
		$e_reply   = stripslashes($this->footer);
		
		$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

		$headers  = "From: $name" . PHP_EOL_MAIL;
		$headers .= "Reply-To: $email" . PHP_EOL_MAIL;
		$headers .= "MIME-Version: 1.0" . PHP_EOL_MAIL;
		$headers .= "Content-Type: text/html; charset=utf-8" . PHP_EOL_MAIL;
		$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL_MAIL;
		return (mail($address, $this->subject, $msg, $headers));
	}
}