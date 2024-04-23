<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;

use DateTime;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class eMail
{
	public	$fromName,
			$fromMail,
			$subject,
			$content,
			$sendMail,
			$msg;
	private $date;

	public function __construct()
	{
		$this->date = new DateTime('now');
		$this->date->format('d/m/Y à H:i:s');
	}

    public function fromName ($data = false)
	{
		$this->fromName = !empty($data) ? $data : $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
	}

	public function fromMail ($data = false)
	{
		$this->fromMail = !empty($data) ? $data : $_SERVER['SERVER_ADMIN'];
	}

	public function subject ($data = false)
	{
		$this->subject = !empty($data) ? $data : '';
	}

	public function message ($data = false)
	{
		$this->msg = !empty($data) ? $data : false;
	}

	public function output ($data)
	{
		$this->sendMail = !empty($data) ? $data : false;
	}

	public function html ($data = false)
	{
		$this->content  = !empty($data) ? $data : false;
		if ($this->content === false) {
			$this->content = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns:v="urn:schemas-microsoft-com:vml">
				<head>
					<meta http-equiv="content-type" content="text/html; charset=utf-8">
					<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
				</head>
				<body style="width: 100%;height: 100%;background: #37383a;">
					<table cellpadding="0" cellspacing="0" style="width: 620px; margin:0 auto;">
						<tr><td style="height: 10px; background-color: #5187bd;border-collapse:collapse; text-align:left;"></td></tr>
						<tr style="background: #FFF;">
							<td style="padding: 25px;font-size: 24px;color: #5187bd;font-family: Helvetica, sans-serif;">'.$this->fromName.'</td>
						</tr>
						<tr><td style="height: 3px; background: #777777;border: 1px dotted #777777;padding: 2px 0; background: #FFF;"></td></tr>
						<tr>
							<td style="background: #5187bd;color:#FFF;line-height: 90px;padding: 5px 25px;font-size: 24px;">Formulaire de contact</td>
						</tr>
						<tr><td style="height: 3px; background: #777777;border: 1px dotted #777777;padding: 2px 0; background: #FFF;"></td></tr>
						<tr style="background: #FFF;">
							<td style="color:#aaaaaa;padding: 25px 0 0 25px;font-size: 12px;font-family:Arial, Helvetica, sans-serif;">'.$this->date.'</td>
						</tr>
						<tr style="background: #FFF;">
							<td style="padding: 0 25px 0px 25px;font-family:"Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif; font-size:36px;font-size: 24px;color: #777777;">'.$this->subject.'</td>
						</tr>
						<tr style="background: #FFF;">
							<td style="padding: 5px 25px 25px 25px;text-align: justify;font-family: Arial, Helvetica, sans-serif;font-size: 13px;line-height: 15pt;color: #777777;">
								'.$this->msg.'
							</td>
						</tr>
						<tr><td style="height: 10px;background-color: #5187bd;border-collapse:collapse; text-align:left;"></td></tr>
					</table>     
				</body>
			</html>';
		}
	}

	public function send ()
	{
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = 'Content-Type: text/html; charset=iso-8859-1';
		$headers[] = "From: {$this->fromName} <{$this->fromMail}>";
		$headers[] = "Reply-To: NoReply <{$this->fromMail}>";
		$headers[] = "X-Mailer: PHP/".phpversion();
		$return = mail($this->sendMail, $this->subject, $this->content, implode("\n", $headers));
		return $return;
	}
}