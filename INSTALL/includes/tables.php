<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if ($_SERVER['SERVER_PORT'] == '80') {
	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
} else {
	$host = 'https://'.$_SERVER['HTTP_HOST'].'/';
}
function randomString($length) {
	$str = random_bytes($length);
	$str = base64_encode($str);
	$str = str_replace(["+", "/", "="], "", $str);
	$str = substr($str, 0, $length);
	return $str;
}
$_SESSION['HTTP_HOST'] = $host;
$current    = new DateTime('now');
$date       = $current->format('Y-m-d H:i:s');
$error      = false;
$class      = null;
$insert     = null;
$sql        = null;

switch ($_POST['table']) {
	case 'articles':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`groups` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'articles_content':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`number` tinyint NOT NULL,
			`name` varchar(128) NOT NULL,
			`pagenumber` int NOT NULL,
			`content` longtext,
			`publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'ban':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`who` varchar(32) DEFAULT NULL,
			`author` varchar(32) DEFAULT NULL,
			`ip` text,
			`email` text NOT NULL,
			`date` datetime DEFAULT NULL,
			`endban` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`timeban` varchar(5) DEFAULT '0',
			`reason` text NOT NULL,
			`number` int NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'capcha':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`IP` varchar(45) NOT NULL,
			`timelast` int NOT NULL,
			`code` varchar(32) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'comment':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`page` varchar(32) NOT NULL,
			`page_sub` varchar(32) NOT NULL,
			`page_id` int NOT NULL,
			`comment` text,
			`hash_key` varchar(32) NOT NULL,
			`date_com` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'config':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
	  		`id` int NOT NULL AUTO_INCREMENT,
	  		`name` varchar(32) NOT NULL,
	  		`value` text,
	  		`editable` tinyint(1) NOT NULL DEFAULT '1',
	  		PRIMARY KEY (`id`),
	  		UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`, `editable`) VALUES
			('', 'API_KEY', '".md5(uniqid(rand(), true))."', 1),
			('', 'CMS_DATE_INSTALL', '".$date."', 1),
			('', 'CMS_DEBUG', '0', 0),
			('', 'CMS_FUSEAU', '2', 0),
			('', 'CMS_LOG', '1', 1),
			('', 'CMS_LOG_MAX', '1 MONTH', 1),
			('', 'CMS_MAIL_WEBSITE', '', 0),
			('', 'CMS_REGISTER_CHARTER', 'En poursuivant votre navigation sur ce site, vous acceptez nos conditions générales d\'utilisation et notamment que des cookies soient utilisés afin de vous connecter automatiquement.', 1),
			('', 'CMS_TPL_FULL', 'calendar,comments,downloads,events,forum,groups,inbox,market,members,newsletter,page,shoutbox,survey,team,user,readmore', 0),
			('', 'CMS_TPL_WEBSITE', NULL, 1),
			('', 'CMS_VERSION', '3.0.5', 1),
			('', 'CMS_WEBSITE_DESCRIPTION', '', 0),
			('', 'CMS_WEBSITE_KEYWORDS', '', 0),
			('', 'CMS_WEBSITE_LANG', 'fr', 1),
			('', 'CMS_WEBSITE_NAME', '', 0),
			('', 'KEY_ADMIN', '".$_SESSION['CONFIG_CMS']['KEY_ADMIN']."', 1),
			('', 'CMS_DEFAULT_PAGE', 'news', 1),
			('', 'HOST', '".$host."', 1),
			('', 'LANDING', '0', 1),
			('', 'COOKIES', '".randomString(6)."', 1),
			('', 'CAPTCHA', '1', 0),
			('', 'TIME_CAPTCHA', '1', 0),
			('','VALIDATION', '0', 0);";
	break;

    case 'config_pages':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(50) NOT NULL,
			`active` tinyint(1) NOT NULL,
			`access_groups` text NOT NULL,
			`access_admin` text NOT NULL,
			`config` text,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `active`, `access_groups`, `access_admin`, `config`) VALUES
			('', 'articles', 1, '1|0', '1|2', 'MAX_ARTICLES==20{||}EMOTE==FALSE'),
			('', 'members', 1, '0', '1', 'MAX_USER==6'),
			('', 'team', 1, '0', '1', 'MAX_USER==10'),
			('', 'shoutbox', 1, '0', '1', 'MAX_MSG==15'),
			('', 'forum', 1, '1|2|0', '1', 'NB_MSG_FORUM==5{||}EMOTE==TRUE'),
			('', 'user', 1, '0', '1', 'MAX_USER==5{||}MAX_USER_ADMIN==20'),
			('', 'page', 1, '0', '1', ''),
			('', 'downloads', 1, '1|2|0', '1|2', 'MAX_DL==6'),
			('', 'inbox', 1, '0', '1', ''),
			('', 'events', 1, '0', '1', ''),
			('', 'gallery', 1, '1|2|0', '1|2', 'MAX_IMG==5{||}MAX_CAT==6'),
			('', 'managements', 1, '1', '1', ''),
			('', 'news', 1, '1|0', '1', 'MAX_NEWS==1'),
			('', 'mails', 1, '2', '1', NULL),
			('', 'games', 1, '1|0', '1', 'MAX_GAMING_PAGE==5'),
			('', 'guestbook', 1, '1|2|0', '1|2', 'MAX_USER==6'),
			('', 'market', 1, '1|0', '1', 'NB_BUY==6{||}NB_BILLING==10'),
			('', 'donations', 1, '1|2|0', '1', NULL),
			('', 'calendar', 1, '0', '1|2', 'MAX_LIST==2'),
			('', 'faq', 1, '1|2|0', '1|2', NULL),
			('', 'links', 1, '1|2|0', '1|2', 'MAX_LINKS==6'),
			('', 'newsletter', 1, '1|2', '1', 'MAX_LINKS==6'),
			('', 'search', 1, '1|2|0', '1', 'MAX_SEARCH==15');";
	break;

    case 'config_tpl':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`value` text,
				 KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'contact':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`subject` varchar(64) NOT NULL,
			`tel` text,
			`datecreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`mail` varchar(64) NOT NULL,
			`message` text,
			`ip` varchar(64) DEFAULT '192.168.1.1',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'contact_send':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` text,
			`last_name` text,
			`adress` text,
			`iban` varchar(32) DEFAULT NULL,
			`bic` varchar(16) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `last_name`, `adress`, `iban`, `bic`) VALUES
		(1, NULL, NULL, NULL, NULL, '');";
	break;

    case 'donations':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` text,
			`last_name` text,
			`adress` text,
			`iban` varchar(32) DEFAULT NULL,
			`bic` varchar(16) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `last_name`, `adress`, `iban`, `bic`) VALUES
		(1, NULL, NULL, NULL, NULL, '');";
	break;

    case 'donations_receive':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` text,
			`surname` text,
			`mail` text,
			`id_purchase` text NOT NULL,
			`sold` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`msg` text,
			`valid` tinyint(1) DEFAULT '0',
			`date_paie` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`type` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'downlaods_stats':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`id_dls` int NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'downloads':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`description` text NOT NULL,
			`idcat` int NOT NULL,
			`size` varchar(64) NOT NULL,
			`uploader` varchar(32) NOT NULL,
			`date` datetime DEFAULT CURRENT_TIMESTAMP,
			`ext` text NOT NULL,
			`view` int NOT NULL,
			`dls` int NOT NULL,
			`screen` text NOT NULL,
			`download` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'downloads_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
		  	`id` int NOT NULL AUTO_INCREMENT,
		  	`name` varchar(128) NOT NULL,
		  	`banner` text,
		  	`ico` text,
		  	`description` text NOT NULL,
		  	`id_groups` text NOT NULL,
		  	PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'emoticones':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
	  		`id` int NOT NULL AUTO_INCREMENT,
	  		`name` varchar(64) NOT NULL,
	  		`dir` text NOT NULL,
	  		`code` varchar(16) NOT NULL,
	  		PRIMARY KEY (`id`),
			UNIQUE KEY `code` (`code`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `dir`, `code`) VALUES
			('', 'happy', '/uploads/emoticones/happy.gif', ':happy:'),
			('', 'rire', '/uploads/emoticones/D.gif', ':D'),
			('', 'embarassed', '/uploads/emoticones/embarassed.gif', ':embarassed:'),
			('', 'frown', '/uploads/emoticones/frown.gif', ':-('),
			('', 'angry', '/uploads/emoticones/angry.gif', ':angry:'),
			('', 'cool', '/uploads/emoticones/cool.gif', ':cool:'),
			('', 'innocent', '/uploads/emoticones/innocent.gif', ':innocent:'),
			('', 'kiss', '/uploads/emoticones/kiss.gif', ':kiss:'),
			('', 'laugh', '/uploads/emoticones/laugh.gif', ':laugh:'),
			('', 'money-mouth', '/uploads/emoticones/money-mouth.gif', ':money-mouth:'),
			('', 'mouth', '/uploads/emoticones/mouth.gif', ':mouth:'),
			('', 'ph34r', '/uploads/emoticones/ph34r.gif', ':ph34r:'),
			('', 'sealed', '/uploads/emoticones/sealed.gif', ':sealed:'),
			('', 'sleep', '/uploads/emoticones/sleep.gif', ':sleep:'),
			('', 'smile', '/uploads/emoticones/smile.gif', ':smile:'),
			('', 'smile 2', '/uploads/emoticones/smile_2.gif', ':smile_2:'),
			('', 'cool_2', '/uploads/emoticones/cool_2.gif', ':cool_2:'),
			('', 'cry', '/uploads/emoticones/cry.gif', ':cry:'),
			('', 'surprised', '/uploads/emoticones/surprised.gif', ':surprised:'),
			('', 'tongue-out', '/uploads/emoticones/tongue-out.gif', ':tongue-out:'),
			('', 'undecided', '/uploads/emoticones/undecided', ':undecided:'),
			('', 'wink', '/uploads/emoticones/wink.gif', ':wink:'),
			('', 'yell', '/uploads/emoticones/yell.gif', ':yell:');";
	break;

    case 'events':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(100) NOT NULL,
			`image` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`start_date` varchar(10) NOT NULL,
			`end_date` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`start_time` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`end_time` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`color` varchar(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`location` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
			`state` tinyint DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'events_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`color` varchar(7) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'faq':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`content` text,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`id_cat` int NOT NULL,
			`publish` varchar(32) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'faq_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'files_admin':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			`sub` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
			`datetime_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`uplaods` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			`file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'gallery':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) DEFAULT NULL,
			`uploader` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`description` text,
			`cat` int DEFAULT NULL,
			`view` int NOT NULL,
			`vote` int NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'gallery_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`banner` text NOT NULL,
			`ico` text NOT NULL,
			`color` varchar(16) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'gallery_cat_valid':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(255) NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`image` varchar(255) NOT NULL,
			`name` varchar(64) NOT NULL,
			`description` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'gallery_sub_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` text,
			`id_gallery` int NOT NULL,
			`color` varchar(64) NOT NULL,
			`bg_color` varchar(32) NOT NULL,
			`groups_access` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'gallery_vote':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
			`id_vote` int NOT NULL,
			`date_vote` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'games':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`banner` text NOT NULL,
			`ico` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'groups':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`id_group` int NOT NULL,
			`image` text,
			`color` varchar(128) NOT NULL DEFAULT '#000000',
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`),
			UNIQUE KEY `id_group` (`id_group`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `id_group`, `image`, `color`) VALUES
			(1, 'ADMINISTRATORS', 1, 'NULL', '#ff6e00'),
			(2, 'MEMBERS', 2, 'NULL', '#052ba0');";
	break;

    case 'guestbook':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` text NOT NULL,
			`message` text,
			`date_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'interaction':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`title` varchar(255) DEFAULT NULL,
			`author` varchar(32) DEFAULT NULL,
			`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`type` text NOT NULL,
			`text` text,
			`page` text,
	PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'links':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) DEFAULT NULL,
			`link` varchar(128) DEFAULT NULL,
			`author` varchar(128) DEFAULT NULL,
			`description` text,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`view` int NOT NULL DEFAULT '0',
			`click` int NOT NULL DEFAULT '0',
			`cat` int DEFAULT '0',
			`valid` tinyint(1) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'links_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) DEFAULT NULL,
			`color` varchar(16) DEFAULT NULL,
			`description` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'mails':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`mail_id` text NOT NULL,
			`author_send` varchar(32) NOT NULL,
			`author_receives` varchar(32) NOT NULL,
			`subject` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`archive_send` tinyint(1) NOT NULL DEFAULT '0',
			`archive_receives` tinyint(1) NOT NULL DEFAULT '0',
			`read_msg_send` tinyint(1) DEFAULT '1',
			`read_msg_receives` tinyint(1) DEFAULT '0',
			`close_send` tinyint(1) NOT NULL DEFAULT '0',
			`close_receives` tinyint(1) DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'mails_blacklist':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`) VALUES
			(1, '0-mail'),
			(2, '10minutemail'),
			(3, 'brefmail'),
			(4, 'dodgeit'),
			(5, 'dontreg'),
			(6, 'e4ward'),
			(7, 'ephemail'),
			(8, 'filzmail'),
			(9, 'gishpuppy'),
			(10, 'guerrillamail'),
			(11, 'haltospam'),
			(12, 'jetable'),
			(13, 'kasmail'),
			(14, 'link2mail'),
			(15, 'mail'),
			(16, 'mail-temporaire'),
			(17, 'maileater'),
			(18, 'mailexpire'),
			(19, 'mailhazard'),
			(20, 'mailinator'),
			(21, 'mailNull'),
			(22, 'mytempemail'),
			(23, 'mytrashmail'),
			(24, 'nobulk'),
			(25, 'nospamfor'),
			(26, 'PookMail'),
			(27, 'saynotospams'),
			(28, 'shortmail'),
			(29, 'sneakemail'),
			(30, 'spam'),
			(31, 'spambob'),
			(32, 'spambox'),
			(33, 'spamDay'),
			(34, 'spamfree24'),
			(35, 'spamgourmet'),
			(36, 'spamh0le'),
			(37, 'spaml'),
			(38, 'tempemail'),
			(39, 'tempInbox'),
			(40, 'tempomail'),
			(41, 'temporaryinbox'),
			(42, 'trashmail'),
			(43, 'willhackforfood'),
			(44, 'willSelfdestruct'),
			(45, 'wuzupmail'),
			(46, 'yopmail');";
	break;

    case 'mails_config':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(255) DEFAULT NULL,
			`config` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `config`) VALUES
			(1, 'host', ''),
			(2, 'Port', '587'),
			(3, 'SMTPAuth', 'true'),
			(4, 'SMTPAutoTLS', '0'),
			(6, 'WordWrap', '70'),
			(7, 'IsHTML', '1'),
			(9, 'setFrom', ''),
			(10, 'fromName', ''),
			(11, 'charset', 'UTF-8'),
			(12, 'username', ''),
			(13, 'Password', '');";
	break;

    case 'mails_msg':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`mail_id` varchar(32) NOT NULL,
			`author_send` varchar(32) NOT NULL,
			`author_receives` varchar(32) NOT NULL,
			`date_send` datetime DEFAULT CURRENT_TIMESTAMP,
			`message` mediumtext,
			`upload` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'mails_unsubscribe':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`active` float NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			UNIQUE KEY `author` (`author`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'maintenance':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`value` varchar(256) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`) VALUES
			(1, 'status', 'open'),
			(2, 'title', 'Le site est temporairement inaccessible'),
			(3, 'description', 'Le site est temporairement inaccessible en raison d’activités de maintenance planifiées...');";
	break;

    case 'market':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`description` text,
			`amount` int NOT NULL DEFAULT '0',
			`remaining` int NOT NULL DEFAULT '0',
			`author` varchar(32) NOT NULL,
			`date_add` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`cat` int DEFAULT NULL,
			`view` int NOT NULL DEFAULT '0',
			`buy` int NOT NULL DEFAULT '0',
			`tva` tinyint NOT NULL DEFAULT '0',
			`delivery_price` int DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_address':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`name` varchar(64) NOT NULL,
			`first_name` varchar(64) NOT NULL,
			`address` text,
			`number` int NOT NULL,
			`postal_code` int DEFAULT NULL,
			`city` text,
			`country` text,
			`phone` text NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`screen` text NOT NULL,
			`user_groups` text,
			`img` varchar(128) DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_img':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_market` int NOT NULL,
			`img` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_link':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`id_purchase` text,
			`link` text,
			`downloads` int DEFAULT NULL,
			`key_dl` varchar(32) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_order':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`id_command` int NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case '_market_sold':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_command` int NOT NULL,
			`date_of_finish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`number` int NOT NULL DEFAULT '0',
			`code` tinytext NOT NULL,
			`comments` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
			`infinite_date` float DEFAULT '0',
			`price` int DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'market_tva':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`country` varchar(2) NOT NULL DEFAULT 'FR',
			`price` tinyint NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `country`, `price`) VALUES
			('', 'BE', '21'),
			('', 'BG', '20'),
			('', 'CZ', '21'),
			('', 'DK', '25'),
			('', 'DE', '19'),
			('', 'EE', '20'),
			('', 'IE', '23'),
			('', 'EL', '24'),
			('', 'ES', '21'),
			('', 'FR', '20'),
			('', 'HR', '25'),
			('', 'IT', '22'),
			('', 'CY', '19'),
			('', 'LV', '21'),
			('', 'LT', '21'),
			('', 'LU', '17'),
			('', 'HU', '27'),
			('', 'MT', '18'),
			('', 'NL', '21'),
			('', 'AT', '20'),
			('', 'PL', '23'),
			('', 'PT', '23'),
			('', 'RO', '19'),
			('', 'SI', '22'),
			('', 'SK', '20'),
			('', 'FI', '24'),
			('', 'SE', '25'),
			('', 'UK', '20'),
			('', 0, '21');";
	break;

    case 'newsletter':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`email` varchar(256) NOT NULL,
			`registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'newsletter_send':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`template` int NOT NULL,
			`receiver` text,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`send` tinyint(1) DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'newsletter_tpl':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`template` varchar(128) NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'notificaton':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`ip` text NOT NULL,
			`message` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_forum':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`title` varchar(64) NOT NULL,
			`subtitle` varchar(128) DEFAULT NULL,
			`access_groups` text NOT NULL,
			`access_admin` text NOT NULL,
			`activate` tinyint(1) DEFAULT '1',
			`orderby` int NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			UNIQUE KEY `title` (`title`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_forum_post':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_threads` int NOT NULL,
			`title` varchar(128) NOT NULL,
			`author` varchar(32) NOT NULL,
			`options` text NOT NULL,
			`date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`attachment` varchar(128) NOT NULL,
			`content` text NOT NULL,
			`lockpost` int NOT NULL,
			`viewpost` int NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_forum_posts':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_post` int NOT NULL,
			`author` varchar(32) NOT NULL,
			`options` text NOT NULL,
			`date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`attachment` varchar(255) NOT NULL,
			`content` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_forum_threads':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_forum` int NOT NULL,
			`title` varchar(128) NOT NULL,
			`subtitle` varchar(256) NOT NULL,
			`orderby` int DEFAULT NULL,
			`options` text NOT NULL,
			`icon` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_news':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`rewrite_name` varchar(128) NOT NULL,
			`name` varchar(128) NOT NULL,
			`date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`author` varchar(32) DEFAULT NULL,
			`authoredit` varchar(32) DEFAULT NULL,
			`content` text NOT NULL,
			`additionalcontent` text,
			`tags` text,
			`cat` varchar(16) DEFAULT NULL,
			`view` int DEFAULT '0',
			`img` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `rewrite_name`, `name`, `date_create`, `author`, `authoredit`, `content`, `additionalcontent`, `tags`, `cat`,`view`, `img`) VALUES
			(1, '1er_news', '1er news', '0000-00-00 00:00:00', '', NULL, '<p style=\"text-align: justify;\">Bonjour et bienvenue sur le CMS (Bel-CMS), aucun compte a &eacute;t&eacute; cr&eacute;&eacute; lors de l\'installation, ne pas l\'oublier parce que c\'est celui qui aura tous les droits.</p>\r\n<p style=\"text-align: justify;\"><br />La version du C.M.S actuel est la <strong>3.0.8</strong> sur <strong>GitHub</strong> et sur le <strong>site</strong> la version <strong>3.0.6</strong>.</p>\r\n<p style=\"text-align: justify;\"><br />Si vous rencontrez le moindre souci, une erreur de frappe, une erreur de toute sorte, essay&eacute; de me pr&eacute;venir svp sur le <strong>Forum</strong>, Merci.</p>', NULL, 'news', '', 12, NULL);";
	break;

    case 'page_news_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_shoutbox':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`avatar` varchar(256) NOT NULL,
			`date_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`msg` text,
			`image` text,
			`file` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'page_stats':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`nb_view` bigint NOT NULL DEFAULT '0',
			`page` varchar(32) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `nb_view`, `page`) VALUES
			(1, 3, 'articles'),
			(2, 1, 'calendar'),
			(3, 0, 'comments'),
			(4, 5, 'contact'),
			(5, 10, 'donations'),
			(6, 6, 'downloads'),
			(7, 1, 'faq'),
			(8, 13, 'forum'),
			(9, 425, 'gallery'),
			(10, 0, 'games'),
			(11, 0, 'groups'),
			(12, 0, 'guestbook'),
			(13, 0, 'links'),
			(14, 0, 'mails'),
			(15, 0, 'market'),
			(16, 5, 'members'),
			(17, 387, 'news'),
			(18, 0, 'newsletter'),
			(19, 2027, 'shoutbox'),
			(20, 0, 'survey'),
			(21, 0, 'team'),
			(22, 0, 'teams'),
			(23, 9, 'user'),
			(24, 38, 'search');";
	break;

    case 'paypal':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`value` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`) VALUES
			(1, 'PAYPAL_SANDBOX', 'false'),
			(2, 'PAYPAL_SANDBOX_CLIENT_ID', ''),
			(3, 'PAYPAL_SANDBOX_CLIENT_SECRET', ''),
			(4, 'PAYPAL_PROD_CLIENT_ID', ''),
			(5, 'PAYPAL_PROD_CLIENT_SECRET', ''),
			(6, 'PAYPAL_CURRENCY', 'EUR'),
			(7, 'PAYPAL_LOGO', ''),
			(8, 'PAYPAL_COUNTRY', ''),
			(9, 'PAYPAL_ADRESS', '');";
	break;

    case 'paypal_purchase':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`date_purchase` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`status` varchar(1) DEFAULT '0',
			`id_purchase` varchar(32) NOT NULL,
			`id_paypal` varchar(64) DEFAULT NULL,
			`total_pay` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
			`sub_total` text,
			`shipping` text,
			`handling` text,
			`taxe` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
			`discount` text,
			`item` text,
			`given_name` text,
			`surname` text,
			`mail_paypal` text NOT NULL,
			`address` text NOT NULL,
			`hash_dls` text,
			PRIMARY KEY (`id`),
			UNIQUE KEY `purchase` (`id_purchase`),
			UNIQUE KEY `id_paypal` (`id_paypal`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'pricing':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`price` tinyint DEFAULT NULL,
			`per` varchar(15) DEFAULT NULL,
			`description` text,
			`listing` text,
			`created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`sort_asc` varchar(1) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'pricing_list':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`cat_1` varchar(32) DEFAULT NULL,
			`cat_2` varchar(32) DEFAULT NULL,
			`cat_3` varchar(32) DEFAULT NULL,
			`cat_4` varchar(32) DEFAULT NULL,
			`cat_5` varchar(32) DEFAULT NULL,
			`actif_1` tinyint(1) DEFAULT '0',
			`actif_2` tinyint(1) DEFAULT '0',
			`actif_3` tinyint(1) DEFAULT '0',
			`actif_4` tinyint(1) DEFAULT '0',
			`actif_5` tinyint(1) DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'pricing_sales':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`date_insert` datetime NOT NULL,
			`plan` int DEFAULT NULL,
			`sales` int DEFAULT '0',
			`type` varchar(32) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'search':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`letter` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
			`title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
			`content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'search_popular':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`search` varchar(64) NOT NULL,
			`type` text,
			`number` int NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'stats':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`name` varchar(32) NOT NULL,
			`value` tinyint(1) DEFAULT '1'
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`) VALUES
			(1, 'yesterday', 1),
			(2, 'today', 1),
			(3, 'now', 1),
			(4, 'page_view', 1),
			(5, 'users', 1),
			(6, 'news', 1),
			(7, 'articles', 1),
			(8, 'comments', 1),
			(9, 'links', 1),
			(10, 'files', 1),
			(11, 'images', 1);";
	break;

    case 'survey':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`question` text,
			`dateclose` varchar(6) DEFAULT '0',
			`timestop` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`vote` int DEFAULT '0',
			`answer_nb` int DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'survey_answer':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_question` int DEFAULT NULL,
			`answer` text,
			`count_vote` int NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'survey_vote':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_vote` int DEFAULT NULL,
			`id_question` int DEFAULT NULL,
			`author` varchar(32) DEFAULT NULL,
			`datetime_vote` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'team':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`game` int NOT NULL,
			`name` varchar(64) NOT NULL,
			`description` text,
			`img` text NOT NULL,
			`orderby` varchar(3) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'team_users':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`teamid` varchar(16) NOT NULL,
			`author` varchar(32) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'uploads_admin':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`category` varchar(64) NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`author` varchar(32) NOT NULL,
			`size` bigint DEFAULT NULL,
			`install` tinyint(1) DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`username` varchar(32) NOT NULL,
			`hash_key` varchar(32) NOT NULL,
			`password` varchar(255) NOT NULL,
			`mail` varchar(128) NOT NULL,
			`ip` varchar(45) NOT NULL,
			`valid` float NOT NULL DEFAULT '1',
			`expire` float NOT NULL DEFAULT '0',
			`token` varchar(50) DEFAULT NULL,
			`gold` int NOT NULL DEFAULT '0',
			`number_valid` varchar(32) DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`username`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_gaming':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`name_game` text NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_groups':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`user_group` int DEFAULT '0',
			`user_groups` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_notification':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`date_notif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`message` text,
			`ip` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_page':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`namepage` text,
			`last_visit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_profils':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`gender` varchar(11) DEFAULT NULL,
			`public_mail` varchar(128) DEFAULT NULL,
			`websites` text,
			`list_ip` text,
			`avatar` text,
			`info_text` text,
			`birthday` date DEFAULT NULL,
			`country` varchar(30) DEFAULT NULL,
			`hight_avatar` varchar(255) DEFAULT NULL,
			`friends` longtext,
			`date_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`visits` int DEFAULT NULL,
			`gravatar` tinyint(1) NOT NULL DEFAULT '0',
			`profils` tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'users_social':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`facebook` text,
			`youtube` text,
			`whatsapp` text,
			`instagram` text,
			`messenger` text,
			`tiktok` text,
			`snapchat` text,
			`telegram` text,
			`pinterest` text,
			`x_twitter` text,
			`reddit` text,
			`linkedIn` text,
			`skype` text,
			`viber` text,
			`teams_ms` text,
			`discord` text,
			`twitch` text,
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'visitors':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`visitor_user` varchar(255) DEFAULT NULL,
			`visitor_ip` text NOT NULL,
			`visitor_browser` varchar(255) DEFAULT NULL,
			`visitor_hour` smallint NOT NULL DEFAULT '0',
			`visitor_minute` smallint NOT NULL DEFAULT '0',
			`visitor_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`visitor_day` varchar(2) NOT NULL,
			`visitor_month` varchar(2) NOT NULL,
			`visitor_year` smallint NOT NULL,
			`visitor_refferer` varchar(255) DEFAULT NULL,
			`visitor_page` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

    case 'widgets':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`title` varchar(64) NOT NULL,
			`groups_access` varchar(255) NOT NULL,
			`groups_admin` varchar(255) NOT NULL,
			`active` tinyint(1) DEFAULT NULL,
			`pos` varchar(6) NOT NULL,
			`orderby` int NOT NULL,
			`pages` text NOT NULL,
			`opttions` text,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `title`, `groups_access`, `groups_admin`, `active`, `pos`, `orderby`, `pages`, `opttions`) VALUES
			('', 'stats', 'Statistique', '1', '1|2', 1, 'right', 1, 'downloads|games|Gallery|news', NULL),
			''(, 'lastconnected', 'Dernier connecté', '1', '1', 1, 'right', 2, '', NULL),
			('', 'newsletter', 'Newsletter', '0', '1', 0, 'right', 2, '', NULL),
			('', 'shoutbox', 'T\'chat', '1|2|0', '1|2', 1, 'bottom', 1, 'news', 'MAX_MSG==20'),
			('', 'survey', 'Sondages', '1|0', '1|2', 0, 'right', 2, 'articles|comments|forum|gallery', NULL),
			('', 'users', 'Utilisateurs', '0', '1', 0, 'left', 1, '', NULL),
			('', 'calendar', 'Calendirier', '0', '1|2', 1, 'right', 1, '', NULL);";
	break;
}
$pdo_options = array();
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';

if (!is_null($drop)) {
	try {
		$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password'], $pdo_options);;
		$cnx->exec($drop);
	} catch(PDOException $Exception) {
		$error = 'ERROR BDD INSERT DATA : '.$table.'<br>';
		$error .= '<pre>'.($Exception->getMessage()).'</pre>';
		echo $error;
	}
	unset($cnx);
}
try { 
	$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password'], $pdo_options);
	$cnx->exec($sql);
	$error = 'Table_'.$_SESSION['prefix'].$table.' créer avec succès';
} catch(PDOException $Exception) {
	$error = 'ERROR BDD INSERT DATA : '.$table.'<br>';
	$error .= '<pre>'.($Exception->getMessage()).'</pre>';
	echo $error;
}
unset($cnx);

if (!is_null($insert) and !empty($error)) {
	try {
		$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password'], $pdo_options);
		$cnx->exec($insert);
		$error = 'Création et Insertion des donnes de la table '.$_SESSION['prefix'].$table.' ajouté avec succès';
	} catch(PDOException $Exception) {
		$error = 'ERROR BDD INSERT DATA : '.$table.'<br>';
		$error .= '<pre>'.($Exception->getMessage()).'</pre>';
		echo $error;
	}
	unset($cnx);
}