<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require ROOT.DS.'core'.DS.'PHPMailer'.DS.'phpmailer.lang-fr.php';
require ROOT.DS.'core'.DS.'PHPMailer'.DS.'Exception.php';
require ROOT.DS.'core'.DS.'PHPMailer'.DS.'PHPMailer.php';
require ROOT.DS.'core'.DS.'PHPMailer'.DS.'SMTP.php';

# TABLE_MAIL_CONFIG

final class eMail 
{
	private $phpMailer,
			$setFrom;

	function __construct() {
		$this->phpMailer = new PHPMailer(true);
		$data = self::getConfigSql();
		$this->setFrom = $data->setFrom;
		self::configPhpMailer($data);
		self::setFrom($data);
	}

	private function getConfigSql ()
	{
		$return = (object) array();
		$sql = new BDD();
		$sql->table('TABLE_MAIL_CONFIG');
		$sql->queryAll();
		$data = $sql->data;
		foreach ($data as $a) {
			$return->{$a->name} = $a->config;
		}
		return $return;
	}

	private function configPhpMailer($data)
	{
		$this->phpMailer->SetLanguage("fr", ROOT.DS.'core'.DS.'PHPMailer'.DS.'phpmailer.lang-fr.php');
		$this->phpMailer->SMTPDebug  = 0;
		$this->phpMailer->CharSet    = $data->charset;
		$this->phpMailer->isSMTP();
		$this->phpMailer->Host       = $data->host;
		$this->phpMailer->SMTPAuth   = $data->SMTPAuth == 'true' ? true : false;
		$this->phpMailer->Username   = $data->username;
		$this->phpMailer->Password   = $data->Password;
		$this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$this->phpMailer->Port       = $data->Port;
		$this->phpMailer->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$this->phpMailer->IsHTML($data->IsHTML);
		$this->phpMailer->WordWrap = $data->WordWrap;
	}

	public function setFrom($data = null)
	{
		if (Secure::isMail($data)) {
			$explode = explode('@', $data);
			$name    = explode('.', $explode[1]);
			$this->phpMailer->setFrom($data, $name[0]);
		} else if ($data == 'null') {
			$this->phpMailer->setFrom($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME']);
		} else {
			return;
		}
	}

	public function subject($subject = null)
	{
		if (Secure::isString($subject)) {
			$this->phpMailer->Subject = $subject;
		} else {
			$this->phpMailer->Subject = 'NONE';
		}
	}

	public function body($body = null)
	{
		if (Secure::isString($body)) {
			$this->phpMailer->Body    = Common::VarSecure($body, 'html');
			$this->phpMailer->AltBody = Common::VarSecure($body, null);
		}
	}

	public function addAdress ($email = null, $name = null)
	{
		if (Secure::isMail($email)) {
			if (empty($name)) {
				$explode = explode('@', $email);
				$name    = explode('.', $explode[1]);
				$this->phpMailer->addAddress($email, $name[2]);
			} else {
				$this->phpMailer->addAddress($email, $name);
			}
		} else if ($email == null) {
			$this->phpMailer->addAddress($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'], $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME']);
		}
	}

	public function submit ()
	{
		try {
			return $this->phpMailer->send();
		} catch (Exception $e) {
			debug($this->phpMailer->ErrorInfo);
		}
	}
}