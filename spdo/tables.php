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
	'TABLE_ARTICLES'            => $DB_PREFIX.'articles',
	'TABLE_ARTICLES_CONTENT'    => $DB_PREFIX.'articles_content',
	'TABLE_BAN'                 => $DB_PREFIX.'ban',
	'TABLE_COMMENTS'            => $DB_PREFIX.'comments',
	'TABLE_CONFIG'              => $DB_PREFIX.'config',
	'TABLE_PAGES_CONFIG'        => $DB_PREFIX.'config_pages',
	'TABLE_CONFIG_TPL'          => $DB_PREFIX.'config_tpl',
	'TABLE_DOWNLOADS'           => $DB_PREFIX.'downloads',
	'TABLE_DOWNLOADS_CAT'       => $DB_PREFIX.'downloads_cat',
	'TABLE_EMOTICONES'          => $DB_PREFIX.'emoticones',
	'TABLE_GROUPS'              => $DB_PREFIX.'groups',
	'TABLE_INTERACTION'         => $DB_PREFIX.'interaction',
	'TABLE_MAILS'               => $DB_PREFIX.'mails',
	'TABLE_MAILS_MSG'           => $DB_PREFIX.'mails_msg',
	'TABLE_MAIL_UNSUBCRIBE'     => $DB_PREFIX.'mails_unsubscribe',
	'TABLE_MAINTENANCE'         => $DB_PREFIX.'maintenance',
	'TABLE_NEWSLETTER'          => $DB_PREFIX.'newsletter',
	'TABLE_NEWSLETTE_SEND'      => $DB_PREFIX.'newsletter_send',
	'TABLE_NEWSLETTER_TPL'      => $DB_PREFIX.'newsletter_tpl',
	'TABLE_FORUM'               => $DB_PREFIX.'page_forum',
	'TABLE_FORUM_POST'          => $DB_PREFIX.'page_forum_post',
	'TABLE_FORUM_POSTS'         => $DB_PREFIX.'page_forum_posts',
	'TABLE_FORUM_THREADS'       => $DB_PREFIX.'page_forum_threads',
	'TABLE_PAGES_NEWS'          => $DB_PREFIX.'page_news',
	'TABLE_PAGES_NEWS_CAT'      => $DB_PREFIX.'page_news_cat',
	'TABLE_SHOUTBOX'            => $DB_PREFIX.'page_shoutbox',
	'TABLE_PAGE_STATS'          => $DB_PREFIX.'page_stats',
	'TABLE_SURVEY'              => $DB_PREFIX.'page_survey',
	'TABLE_SURVEY_QUEST'        => $DB_PREFIX.'page_survey_quest',
	'TABLE_SURVEY_AUTHOR'       => $DB_PREFIX.'page_survey_author',
	'TABLE_USERS'               => $DB_PREFIX.'users',
	'TABLE_USERS_GROUPS'        => $DB_PREFIX.'users_groups',
	'TABLE_USERS_PAGE'          => $DB_PREFIX.'users_page',
	'TABLE_USERS_PROFILS'       => $DB_PREFIX.'users_profils',
	'TABLE_USERS_SOCIAL'        => $DB_PREFIX.'users_social',
	'TABLE_VISITORS'            => $DB_PREFIX.'visitors',
	'TABLE_WIDGETS'             => $DB_PREFIX.'widgets',
);
foreach ($tables as $name => $value) {
	define($name, $value); unset($tables);
}
?>