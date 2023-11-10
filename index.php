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
use BelCMS\Core\BelCMS as BelCMS;
use BelCMS\Core\Dispatcher;
use Belcms\Management\Managements;
#########################################
# TimeZone et charset
#########################################
ini_set('default_charset', 'utf-8');
date_default_timezone_set('Europe/Brussels');
#########################################
# Demarre une $_SESSION
#########################################
if(!isset($_SESSION)) {
	session_start();
}
function getmicrotime(){
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}
$_SESSION['TIME_START']     = getmicrotime();
$_SESSION['CMS_DEBUG']      = true; /* a mettre en false pour un site en ligne */
$_SESSION['CONFIG_CMS']     = array();
$_SESSION['NB_REQUEST_SQL'] = 0;
#########################################
# Définit comme l'index
#########################################
define('CHECK_INDEX', true);
define('VERSION_CMS', '3.0.0');
define('ERROR', true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);
define('SHOW_ALL_REQUEST_SQL', false);
#########################################
# Fichier requis
#########################################
require_once ROOT.DS.'requires'.DS.'constant.php';
require_once ROOT.DS.'requires'.DS.'requires.all.php';
#########################################
# Initialise le C.M.S
#########################################
if (Dispatcher::isManagement() === true) {
	header('Content-Type: text/html');
	require_once constant('DIR_ADMIN').'index.php';
	new Managements ();
} else {
	$belcms = new BelCMS;
	$belcms->typeMime;
	header('Content-Type: <?=$belcms->typeMime;?> charset=utf-8');
	if (isset($_GET['echo'])) {
		echo $belcms->page;
	} else if ($belcms->typeMime == 'text/html') {
		echo $belcms->template;
	} else if ($belcms->typeMime == 'application/json') {
		echo json_encode($belcms->page);
	} else if ($belcms->typeMime == 'text/plain') {
		echo $belcms->page;
	}
}
