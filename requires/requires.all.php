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
################################################
# files$filess principaux en inclusion
################################################
$directory = constant('DIR_LANGS');
if(is_dir($directory)){
	$dir = opendir($directory);
	while($files = readdir($dir)){
		if (is_file($directory.$files) && $files !='/' && $files !='.' && $files != '..' && strtolower(substr($files,-4))==".php" && $files != 'index.html' && $files != 'list.contry.php'){
			require_once($directory.'/'.$files);
		}
	}
	closedir($dir); unset($files);
}
################################################
# Principaux fichier a inclure
################################################
$files = array(
	ROOT.DS.'config'.DS.'config.pdo.php',
	ROOT.DS.'spdo'.DS.'tables.php',
	ROOT.DS.'spdo'.DS.'connect.php',
	ROOT.DS.'spdo'.DS.'spdo.class.php',
	ROOT.DS.'core'.DS.'class.error.php',
	ROOT.DS.'core'.DS.'class.debug.php',
	ROOT.DS.'core'.DS.'class.notification.php',
	ROOT.DS.'config'.DS.'class.config.php',
	ROOT.DS.'requires'.DS.'common.php',
	ROOT.DS.'core'.DS.'class.dispatcher.php',
	ROOT.DS.'core'.DS.'class.secure.php',
	ROOT.DS.'core'.DS.'class.secures.php',
	ROOT.DS.'users'.DS.'index.php',
	ROOT.DS.'core'.DS.'class.belcms.php',
);
foreach ($files as $include) {
	require $include;
}