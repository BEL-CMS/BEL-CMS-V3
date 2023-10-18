<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
*/

namespace BelCMS\Config;
use BelCMS\PDO\BDD as BDD;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Principale du CMS
################################################
final class Config
{
	public function __construct()
	{
		foreach (self::getConfigBDD() as $v) {
			if (!defined(mb_strtoupper($v->name))) {
				define($v->name, $v->value);
			}
		}
	}

	private function getConfigBDD (): array
	{
		$return = (object) array();
		$sql = new BDD;
		$sql->table(constant('TABLE_CONFIG'));
		$sql->fields(array('name', 'value'));
		$sql->queryAll();
		$return = $sql->data;
		unset($sql);
		return $return;
	}

	public static function langs (): array
	{
		return constant('LANGS');
	}
}
new Config;