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

namespace Belcms\Pages\Models;

use BelCMS\Core\eMail;
use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Contact
{
	#   TABLE_CONTACT   #
	#   id, author, subject, tel, datecreate, mail, message   #
	public function send ($data = false)
	{
		if (is_array($data) and $data !== false) {

			$insert['author']  = Common::VarSecure($data['name'], null);
			$insert['subject'] = Common::VarSecure($data['subject'], null);
			$insert['message'] = Common::VarSecure($data['message'], 'html');
			$insert['mail']    = Secure::isMail($data['mail']);
			if (isset($data['tel']) and !empty($data['tel'])) {
				$insert['tel'] = Common::VarSecure($data['tel']);
			}

			$sql = new BDD;
			$sql->table('TABLE_CONTACT');
			$sql->insert($insert);

			if ($sql->rowCount == '1') {
				$mail = new eMail();
				$mail->fromName($insert['author']);
				$mail->fromMail($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE']); 
				$mail->subject($insert['subject']);
				$mail->message($insert['message']);
				$mail->output($insert['mail']);
				$mail->html(self::html($insert));
				$mail->send();
				$return['text']  = constant('ADD_NEW_MAIL');
				$return['type']  = 'success';	
			} else {
				$return['text']  = constant('ADD_NEW_MAIL_ERROR');
				$return['type']  = 'error';	
			}
			return $return;
		}
	}

	private function html ($data)
	{
		$return = ' 
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns:v="urn:schemas-microsoft-com:vml">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
			</head>
			<body style="width: 100%;height: 100%;background: #37383a;text-align: center;">
				<table cellpadding="0" cellspacing="0" style="width: 620px; margin:0 auto;">
					<tr>
						<td style="height: 10px; background-color: #5187bd;border-collapse:collapse; text-align:left;"></td>
					</tr>
					<tr style="background: #FFF;">
						<td style="padding: 25px;font-size: 24px;color: #5187bd;font-family: Helvetica, sans-serif;">'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'].'</td>
					</tr>
					<tr>
						<td style="height: 3px; background: #777777;border: 1px dotted #777777;padding: 2px 0; background: #FFF;"></td>
					</tr>
					<tr>
						<td style="background: #5187bd;color:#FFF;padding: 15px 25px;font-size: 24px;">Formulaire de contact</td>
					</tr>
					<tr>
						<td style="height: 3px; background: #777777;border: 1px dotted #777777;padding: 2px 0; background: #FFF;"></td>
					</tr>
					<tr style="background: #FFF;">
						<td style="color:#aaaaaa;padding: 25px 0 0 25px;font-size: 12px;font-family:Arial, Helvetica, sans-serif;">17-04-2024 @ 07h53</td>
					</tr>
					<tr style="background: #FFF;">
						<td style="padding: 0 25px 0px 25px;font-family:Segoe UI, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:36px;font-size: 24px;color: #777777;">'.$data['subject'].'</td>
					</tr>
					<tr style="background: #FFF;">
						<td style="padding: 5px 25px 25px 25px;text-align: justify;font-family: Arial, Helvetica, sans-serif;font-size: 13px;line-height: 15pt;color: #777777;">'.$data['message'].'</td>
					</tr>
					<tr style="width: 100%;">
						<td style="width:100%;">
							<table width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align: left;font-size: 12px;line-height: 15pt;color: #777777;width: 100%;">
								<tr style="background: #f4f4f4;width: 100%;">
									<td style="text-align: center;padding: 15px;color: #777777;font-weight: bold;font-size: 16px;">Information</td>
								</tr>
								<tr style="background: #f4f4f4;width: 100%;">
									<td style="padding: 0 25px;"><strong>Nom</strong> : '.$data['author'].'</td>
								</tr>
								<tr style="background: #f4f4f4;width: 100%;">
									<td style="padding: 0 25px 15px 25px;"><strong>E-mail</strong> : '.$data['mail'].'</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr><td style="height: 10px;background-color: #5187bd;"></td></tr>
				</table>     
			</body>
		</html>';
		return $return;
	}
}