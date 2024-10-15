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
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Captcha
{
	public function insertBDDCaptcha ($code)
	{
		self::removeAllCaptcha();
		$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEF123456789+-=&@";
		$insert['IP'] = Common::GetIp();
		$insert['code'] = $code;
		$insert['false_1'] = substr(str_shuffle($caracteres), 0, 5);
		$insert['false_2'] = substr(str_shuffle($caracteres), 0, 5);
		$insert['timelast'] = time();
		$sql = new BDD;
		$sql->table('TABLE_CAPTCHA');
		$sql->insert($insert);
	}

	public function removeAllCaptcha ()
	{
		$where = array('name' => 'IP', 'value' => Common::GetIp()); 
		$sql = new BDD;
		$sql->table('TABLE_CAPTCHA');
		$sql->where($where);
		$sql->delete();
	}
}