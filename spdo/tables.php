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

if (defined('DB_PREFIX')) { $DB_PREFIX = constant('DB_PREFIX'); } else { $DB_PREFIX = ''; }

$tables = array(
	#########################################
	# Tables
	#########################################
	'TABLE_COMMENTS'            => $DB_PREFIX.'comments',
	'TABLE_CONFIG'              => $DB_PREFIX.'config',
	'TABLE_PAGES_CONFIG'        => $DB_PREFIX.'config_pages',
	'TABLE_CONFIG_TPL'          => $DB_PREFIX.'config_tpl',
	'TABLE_GROUPS'              => $DB_PREFIX.'groups',
	'TABLE_PAGES_ARTICLES'      => $DB_PREFIX.'page_articles',
	'TABLE_PAGES_ARTICLES_CAT'  => $DB_PREFIX.'page_articles_cat',
	'TABLE_USERS'               => $DB_PREFIX.'users',
	'TABLE_USERS_GROUPS'        => $DB_PREFIX.'users_groups',
	'TABLE_USERS_PROFILS'       => $DB_PREFIX.'users_profils',
	'TABLE_USERS_SOCIAL'        => $DB_PREFIX.'users_social',
);
foreach ($tables as $name => $value) {
	define($name, $value); unset($tables);
}
?>