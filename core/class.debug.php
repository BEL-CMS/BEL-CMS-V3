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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Debug
{
	public function __construct($data, $exitAfter = true)
	{
		$var  = '<pre>'.PHP_EOL;
		$var .= var_dump($data).PHP_EOL;
		$var .= str_pad('', 100, '#',STR_PAD_RIGHT).PHP_EOL;
		$var .= '</pre>'.PHP_EOL;
		echo $var;
		if ($exitAfter === true) {
			exit();
		}
	}
	public static function _backtrace ()
	{	echo '<pre>';
			debug_print_backtrace();
		echo '</pre>';
	}
}
function debug ($data, $exitAfter = true) {
	return new Debug($data, $exitAfter);
}