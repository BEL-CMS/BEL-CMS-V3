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

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\eMail;

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
				require_once ROOT.DS.'core'.DS.'class.mail.php';

				$email = new eMail;
				$email->subject('Sujets');
				$email->addAdress($insert['mail'], $insert['author']);
				$email->body($insert['message']);
				$email->submit();
				$return['msg']  = constant('ADD_NEW_MAIL');
				$return['type'] = 'success';
			} else {
				$return['msg']  = constant('ADD_NEW_MAIL_ERROR');
				$return['type'] = 'error';
			}
			return $return;
		}
	}

	private function sendHtmlBody ($data)
	{
		setLocale(LC_TIME, 'fr_FR.utf8');

		$date = new \DateTime();
		$date = $date->format('d/m/Y à H:i:s');

		if ($_SERVER['SERVER_PORT'] == '80') {
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
		} else {
			$host = 'https://'.$_SERVER['HTTP_HOST'].'/';
		}

		return '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body style="background:#717c87;">
		<table style="border-collapse:collapse;width:100%;">
			<table style="width:90%;max-width:800px;margin: auto;border-collapse:collapse;">
				<tr style="background:#d05d68;color:#FFF;height:60px;">
					<td><h1 style="margin:0;padding:0 25px;font-size:24px;line-height:60px;">Bel-CMS</h1></td>
				</tr>
			</table>
			<table style="width:90%;max-width:800px;margin:auto;border-collapse:collapse;">
				<tr style="background:#ecebeb;">
					<td style="padding: 25px;">
						<p style="text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at ligula feugiat, fringilla elit mollis, ultrices lectus. Nunc pellentesque diam eu diam blandit, sed lacinia mauris efficitur. Nullam id lectus id felis fringilla euismod nec at ex. In sed ante augue. Sed consequat mauris a rhoncus dictum.</p>
					</td>
				</tr>
			</table>
			<table style="width:90%;max-width:800px;margin:auto;border-collapse:collapse;background:#FFF;">
				<tr style="color:rgba(0,0,0,.45);">
					<td colspan="2">
						<span style="text-align:center;display: block;"><h2 style="margin:10px 0;">Information</h2></span>
					</td>
					<tr style="border-bottom: 1px solid rgba(0,0,0,.45);">
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;">Nom :</td>
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;text-align: right;">Stive</td>
					</tr>
					<tr style="border-bottom: 1px solid rgba(0,0,0,.45);">
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;">E-mail :</td>
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;text-align: right;">stivedeterme@msn.com</td>
					</tr>
					<tr style="border-bottom: 1px solid rgba(0,0,0,.45);">
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;">Date :</td>
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;text-align: right;">Stive</td>
					</tr>
					<tr style="border-bottom: 1px solid rgba(0,0,0,.45);">
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;">IP :</td>
						<td style="border-bottom: 1px solid rgba(0,0,0,.45);line-height:25px;padding: 5px 20px;text-align: right;">192.168.1.1</td>
					</tr>
				</tr>
			</table>
    	</table>
		</body></html>';		
	}
}