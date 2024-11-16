<?php
/**
* Bel-CMS [Content management system]
* @version 3.0.5 [PHP8.3]
* @link https://bel-cms.dev
* @link https://determe.be
* @license http://opensource.org/licenses/GPL-3.0.-copyleft
* @copyright 2015-2024 Bel-CMS
* @author as Stive - stive@determe.be
*/
$BDD = 'server';
$databases["server"] = array(
#####################################
# Réglages MySQL - SERVEUR
#####################################
'DB_DRIVER'   => 'mysql',
'DB_NAME'     => 'ver3.1.0',
'DB_USER'     => 'root',
'DB_PASSWORD' => '',
'DB_HOST'     => 'localhost',
'DB_PREFIX'   => 'belcms_',
'DB_PORT'     => '3306'
);
foreach ($databases[$BDD] as $constant => $value) {
	define($constant, $value); unset($databases);
}
