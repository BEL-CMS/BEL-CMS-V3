<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
*/
#########################################
use BelCMS\Core\BelCMS;
use BelCMS\Core\Dispatcher;
use Belcms\Management\Managements;
use BelCMS\Ban\_Ban as Ban;
use BelCMS\Core\Landing;
use BelCMS\Core\Validation;
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
#########################################
# MicroTime loading
#########################################
$_SESSION['SESSION_START'] = microtime(true); // Timestamp actuel avec microsecondes
#########################################
# Microtime pour le chargement de la page
#########################################
#########################################
# Enregistre des éléments dans la $_SESSION
#########################################
$_SESSION['CMS_DEBUG']      = true; /* a mettre en false pour un site en ligne */
$_SESSION['CONFIG_CMS']     = array();
$_SESSION['NB_REQUEST_SQL'] = 0;
#########################################
# Définit comme l'index
#########################################
define('CHECK_INDEX', true);
define('VERSION_CMS', '3.0.9');
define('ERROR', true);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__);
define('SHOW_ALL_REQUEST_SQL', false);
#########################################
# Install
#########################################
if (is_file(ROOT.DS.'INSTALL'.DS.'index.php')) {
	header('Location: INSTALL/index.php');
	die();
}
#########################################
# Fichier requis
#########################################
require_once ROOT.DS.'requires'.DS.'constant.php';
require_once ROOT.DS.'requires'.DS.'requires.all.php';
#########################################
# Bannissement
#########################################
new Ban();
#########################################
# Compte Validation par mail ou auto
#########################################
new Validation();
#########################################
# Landing page
#########################################
new Landing();
#########################################
# Initialise le C.M.S
#########################################
if (Dispatcher::isManagement() === true) {
	header('Content-Type: text/html');
	require_once constant('DIR_ADMIN').'index.php';
	new Managements ();
} else {
	$belcms = new BelCMS;
	$typeMime = $belcms->typeMime;
	if (isset($_GET['echo'])) {
		header('Content-Type: text/html; charset=UTF-8');
		echo $belcms->page;
	} else if (isset($_GET['img'])) {
		header('Content-Type: image/png');
		echo $belcms->page;
	} else if ($typeMime == 'text/html') {
		header('Content-Type: text/html; charset=UTF-8');
		echo $belcms->template;
	} else if ($typeMime == 'application/json') {
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($belcms->page);
	} else if ($typeMime == 'text/plain') {
		echo $belcms->page;
	}
}