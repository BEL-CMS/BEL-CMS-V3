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

namespace BELCMS\CONFIG;
use BELCMS\PDO\BDD as BDD;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Principale du CMS
################################################
final class Config
{
	var $config;

	public function __construct()
	{
		foreach (self::getConfigBDD() as $v) {
			$return[mb_strtoupper($v->name)] = (string) $v->value;
		}
		$this->config = $return;
	}

	private function getConfigBDD (): array
	{
		$return = (object) array();
		$sql = new BDD;
		$sql->table('TABLE_CONFIG');
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
$config = new Config;
foreach ($config->config as $name => $value) {
	if (!defined(strtoupper($name))) {
		define($name, $value);
	}
}