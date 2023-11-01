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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

Common::constant(array(
	'MANAGEMENT_TITLE_NAME'     => 'Paramètres Général',
	'ERRORS_AND_API_SETTINGS'   => 'Paramètres des erreurs et de l\'api',
	'INDICATION_SETTING'        => 'Paramètre d\'indication',
	'SAVE_BDD_SUCCESS'          => 'Sauvegarde éffectué avec succès',
	'DATE_INSTALL'              => 'Date d\'installation',
	'ADMIN_WEBSITE_NAME'        => 'Nom de votre site',
	'ADMIN_WEBSITE_LANG'        => 'Langue de votre site',
	'ADMIN_WEBSITE_KEYWORDS'    => 'Mot clés',
	'ADMIN_WEBSITE_DESCRIPTION' => 'Description du site',
	'ADMIN_TPL_WEBSITE'         => 'Template',
	'ADMIN_TPL_FULL'            => 'Page en "full"',
	'ADMIN_REGISTER_CHARTER'    => 'Charte d\'enregistrement',
	'ADMIN_MAIL_WEBSITE'        => 'e-mail administrateur',
	'ADMIN_JQUERY_UI'           => 'Activer : jQuery UI (1.12.1)',
	'ADMIN_JQUERY'              => 'Activer : jQuery (3.3.1)',
	'ADMIN_VERSION_CMS'         => 'Version du C.M.S',
	'ADMIN_BELCMS_DEBUG'        => 'Activer les erreur (PHP/SQL)',
	'ADMIN_API_KEY'             => 'API clé externe',
	'LOG_SETTINGS'              => 'Paramètres Log',
	'CMS_FUSEAU'                => 'Fuseau horaire',
	'CMS_SERIAL'                => 'Serial d\'administration (gold)',
	'CMS_TITLE'                 => '',
	'HOME_PAGE'                 => 'Page d\'accueil',
	'CONTACT_EMAIL'             => 'Email de contact',
	'DEFAULT'                   => 'Défaut',
	'NO_THEME_DEFINED'          => 'Aucun thème définit',
));
