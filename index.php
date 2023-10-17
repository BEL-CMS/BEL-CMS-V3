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
#########################################
# Demarre une $_SESSION
#########################################
if(!isset($_SESSION)) {
	session_start();
}
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
use BelCMS\Core\BelCMS as BelCMS;
#########################################
# Initialise le C.M.S
#########################################
$belcms = new BelCMS;
$belcms->typeMime;
$belcms->render();
header('Content-Type: <?=$belcms->typeMime;?>');
echo $belcms->render;
return;