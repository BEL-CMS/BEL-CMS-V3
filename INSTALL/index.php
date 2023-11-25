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
# Initialise ERROR & LOG
#########################################
ini_set('default_charset', 'utf-8');
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
#########################################
# Initialise TimeZone
#########################################
date_default_timezone_set("Europe/Brussels");
setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
define ('ROOT', str_replace('INSTALL/index.php', '', $_SERVER['SCRIPT_FILENAME']));
define ('DS', '/');
require ROOT.DS.'INSTALL'.DS.'includes'.DS.'belcms.class.php';
$install = New BelCMS;
echo $install->HTML();