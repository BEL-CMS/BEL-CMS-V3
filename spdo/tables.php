<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
*/

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (defined('DB_PREFIX')) { $DB_PREFIX = constant('DB_PREFIX'); } else { $DB_PREFIX = ''; }

$tables = array(
	##########################
	# Tables
	##########################
	'TABLE_ARTICLES'            => $DB_PREFIX.'articles',
	'TABLE_ARTICLES_CONTENT'    => $DB_PREFIX.'articles_content',
	'TABLE_BADGES'              => $DB_PREFIX.'badge',
	'TABLE_BADGES_USERS'        => $DB_PREFIX.'badge_users',
	'TABLE_BAN'                 => $DB_PREFIX.'ban',
	'TABLE_CAPTCHA'             => $DB_PREFIX.'capcha',
	'TABLE_COMMENTS'            => $DB_PREFIX.'comments',
	'TABLE_CONFIG'              => $DB_PREFIX.'config',
	'TABLE_PAGES_CONFIG'        => $DB_PREFIX.'config_pages',
	'TABLE_CONFIG_TPL'          => $DB_PREFIX.'config_tpl',
	'TABLE_CONTACT'             => $DB_PREFIX.'contact',
	'TABLE_CONTACT_REPLY'       => $DB_PREFIX.'contact_send',
	'TABLE_DONATIONS'           => $DB_PREFIX.'donations',
	'TABLE_DONATIONS_REVEIVE'   => $DB_PREFIX.'donations_receive',
	'TABLE_DOWNLOADS_STATS'     => $DB_PREFIX.'downlaods_stats',
  	'TABLE_DOWNLOADS'           => $DB_PREFIX.'downloads',
	'TABLE_DOWNLOADS_CAT'       => $DB_PREFIX.'downloads_cat',
	'TABLE_EMOTICONES'          => $DB_PREFIX.'emoticones',
	'TABLE_EVENTS'              => $DB_PREFIX.'events',
	'TABLE_EVENTS_CAT'          => $DB_PREFIX.'events_cat',
	'TABLE_FAQ'                 => $DB_PREFIX.'faq',
	'TABLE_FAQ_CAT'             => $DB_PREFIX.'faq_cat',
	'TABLE_GALLERY'             => $DB_PREFIX.'gallery',
	'TABLE_GALLERY_CAT'         => $DB_PREFIX.'gallery_cat',
	'TABLE_PAGES_GAMES'         => $DB_PREFIX.'games',
	'TABLE_GROUPS'              => $DB_PREFIX.'groups',
	'TABLE_GUESTBOOK'           => $DB_PREFIX.'guestbook',
	'TABLE_INTERACTION'         => $DB_PREFIX.'interaction',
	'TABLE_LINKS'               => $DB_PREFIX.'links',
	'TABLE_LINKS_CAT'           => $DB_PREFIX.'links_cat',
	'TABLE_MAILS'               => $DB_PREFIX.'mails',
	'TABLE_MAIL_BLACKLIST'      => $DB_PREFIX.'mails_blacklist',
	'TABLE_MAILS_MSG'           => $DB_PREFIX.'mails_msg',
	'TABLE_MAIL_UNSUBCRIBE'     => $DB_PREFIX.'mails_unsubscribe',
	'TABLE_MAINTENANCE'         => $DB_PREFIX.'maintenance',
	'TABLE_MARKET'              => $DB_PREFIX.'market',
	'TABLE_MARKET_ADRESS'       => $DB_PREFIX.'market_address',
	'TABLE_MARKET_CAT'          => $DB_PREFIX.'market_cat',
	'TABLE_MARKET_IMG'          => $DB_PREFIX.'market_img',
	'TABLE_MARKET_LINKS'        => $DB_PREFIX.'market_link',
	'TABLE_MARKET_ORDER'        => $DB_PREFIX.'market_order',
	'TABLE_MARKET_SOLD'         => $DB_PREFIX.'market_sold',
	'TABLE_MARKET_TRANSACTION'  => $DB_PREFIX.'market_transaction',
	'TABLE_MARKET_TVA'          => $DB_PREFIX.'market_tva',
	'TABLE_NEWSLETTER'          => $DB_PREFIX.'newsletter',
	'TABLE_NEWSLETTER_SEND'     => $DB_PREFIX.'newsletter_send',
	'TABLE_NEWSLETTER_TPL'      => $DB_PREFIX.'newsletter_tpl',
	'TABLE_NOTIFICATION'        => $DB_PREFIX.'notificaton',
	'TABLE_FORUM'               => $DB_PREFIX.'page_forum',
	'TABLE_FORUM_POST'          => $DB_PREFIX.'page_forum_post',
	'TABLE_FORUM_POSTS'         => $DB_PREFIX.'page_forum_posts',
	'TABLE_FORUM_THREADS'       => $DB_PREFIX.'page_forum_threads',
	'TABLE_PAGES_NEWS'          => $DB_PREFIX.'page_news',
	'TABLE_PAGES_NEWS_CAT'      => $DB_PREFIX.'page_news_cat',
	'TABLE_SHOUTBOX'            => $DB_PREFIX.'page_shoutbox',
	'TABLE_PAGE_STATS'          => $DB_PREFIX.'page_stats',
	'TABLE_STATS'               => $DB_PREFIX.'stats', 
	'TABLE_SURVEY'              => $DB_PREFIX.'survey',
	'TABLE_SURVEY_QUEST'        => $DB_PREFIX.'survey_answer',
	'TABLE_SURVEY_VOTE'         => $DB_PREFIX.'survey_vote',
	'TABLE_PAYPAL'              => $DB_PREFIX.'paypal',
	'TABLE_PURCHASE'            => $DB_PREFIX.'paypal_purchase',
	'TABLE_TEAM'                => $DB_PREFIX.'team',
	'TABLE_TEAM_USERS'          => $DB_PREFIX.'team_users',
	'TABLE_UPLOADS'             => $DB_PREFIX.'uploads_admin',
	'TABLE_USERS'               => $DB_PREFIX.'users',
	'TABLE_USERS_GAMING'        => $DB_PREFIX.'users_gaming',
	'TABLE_USERS_GROUPS'        => $DB_PREFIX.'users_groups',
	'TABLE_USERS_NOTIFICATION'  => $DB_PREFIX.'users_notification',
	'TABLE_USERS_PAGE'          => $DB_PREFIX.'users_page',
	'TABLE_USERS_PROFILS'       => $DB_PREFIX.'users_profils',
	'TABLE_USERS_SOCIAL'        => $DB_PREFIX.'users_social',
	'TABLE_VISITORS'            => $DB_PREFIX.'visitors',
	'TABLE_WIDGETS'             => $DB_PREFIX.'widgets',
	#####################################################
);
foreach ($tables as $name => $value) {
	define($name, $value); unset($tables);
}
$custom = Common::ScanFiles(constant('DIR_TABLE_CUSTOM'), '.php', true);
foreach ($custom as $v) {
	include $v;
}
?>