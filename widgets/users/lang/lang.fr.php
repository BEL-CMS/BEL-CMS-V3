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
Common::constant(array(	
	#####################################
	# Fichier lang en français - Page
	#####################################
	'GREAT_HAVE_BACK'              => 'Ravi de vous revoir',
	'NEW_HERE'                     => 'Nouveau ici ?',
	'CREATE_USER_TO_WEB'           => 'Créée un compte sur '.CMS_WEBSITE_NAME,
	'REMEMBER_ME_ON_THIS_COMPUTER' => 'Se souvenir de moi sur cet ordinateur',
));
