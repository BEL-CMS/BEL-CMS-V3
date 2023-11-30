<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if ($_SERVER['SERVER_PORT'] == '80') {
	$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
} else {
	$host = 'https://'.$_SERVER['HTTP_HOST'].'/';
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
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`groups` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'articles_content':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`number` tinyint(128) NOT NULL,
			`name` varchar(128) NOT NULL,
			`pagenumber` int NOT NULL,
			`content` longtext,
			`publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case "ban":
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
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'comments':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`page` varchar(32) NOT NULL,
			`page_sub` varchar(32) NOT NULL,
			`page_id` int NOT NULL,
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
			('', 'CMS_REGISTER_CHARTER', 'En poursuivant votre navigation sur ce site, vous acceptez nos conditions générales d\'utilisation et notamment que des cookies soient utilisés afin de vous connecter automatiquement', 1),
			('', 'CMS_TPL_FULL', 'calendar,comments,downloads,events,forum,groups,inbox,market,members,newsletter,page,shoutbox,survey,team,user,readmore', 0),
			('', 'CMS_TPL_WEBSITE', NULL, 1),
			('', 'CMS_VERSION', '3.0.0', 1),
			('', 'CMS_WEBSITE_DESCRIPTION', '', 0),
			('', 'CMS_WEBSITE_KEYWORDS', '', 0),
			('', 'CMS_WEBSITE_LANG', 'fr', 1),
			('', 'CMS_WEBSITE_NAME', '', 0),
			('', 'KEY_ADMIN', '".md5(uniqid(rand(), true))."', 1),
			('', 'CMS_DEFAULT_PAGE', 'news', 1),
			('', 'HOST', '".$host."', 1);";
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `active`, `access_groups`, `access_admin`, `config`) VALUES
			('', 'articles', 1, '1|0', '1|2', 'MAX_ARTICLES==20'),
			('', 'members', 1, '0', '1', 'MAX_USER==6'),
			('', 'team', 1, '0', '1', 'MAX_USER==10'),
			('', 'shoutbox', 1, '0', '1', 'MAX_MSG==15'),
			('', 'forum', 1, '1|2|0', '1', 'NB_MSG_FORUM==5'),
			('', 'user', 1, '0', '1', 'MAX_USER==5{||}MAX_USER_ADMIN==20'),
			('', 'page', 1, '0', '1', ''),
			('', 'downloads', 1, '1|2', '1|2', 'MAX_DL==1'),
			('', 'inbox', 1, '0', '1', ''),
			('', 'events', 1, '0', '1', ''),
			('', 'gallery', 1, '0', '1', ''),
			('', 'managements', 1, '1', '1', ''),
			('', 'news', 1, '1|0', '1', 'MAX_NEWS==2'),
			('', 'mails', 1, '2', '1', NULL);
			('', 'games', 1, '1|0', '1', 'MAX_GAMING_PAGE==5');";
	break;

	case 'config_tpl':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`value` text,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'downloads':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
	  		`id` int NOT NULL AUTO_INCREMENT,
	  		`name` varchar(128) NOT NULL,
	  		`description` text,
	  		`idcat` int NOT NULL,
	  		`size` varchar(8) NOT NULL,
	  		`uploader` varchar(32) NOT NULL,
			`date` datetime DEFAULT CURRENT_TIMESTAMP,
	  		`ext` text NOT NULL,
	  		`view` int NOT NULL,
	 		`dls` int NOT NULL,
	  		`screen` text NOT NULL,
	  		`download` text NOT NULL,
	  		PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'downloads_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
		  	`id` int NOT NULL AUTO_INCREMENT,
		  	`name` varchar(128) NOT NULL,
		  	`banner` text,
		  	`ico` text,
		  	`description` text NOT NULL,
		  	`groups` text NOT NULL,
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
	  		PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "games":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
	  		`id` int NOT NULL AUTO_INCREMENT,
	  		`name` varchar(128) NOT NULL,
	  		`banner` text NOT NULL,
	  		`ico` text NOT NULL,
	  		PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `id_group`, `image`, `color`) VALUES
			(1, 'ADMINISTRATORS', 1, 'NULL', '#ff6e00'),
			(2, 'MEMBERS', 2, 'NULL', '#052ba0');";
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
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'mails_blacklist':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`) VALUES
			('', '0-mail'),
			('', '10minutemail'),
			('', 'brefmail'),
			('', 'dodgeit'),
			('', 'dontreg'),
			('', 'e4ward'),
			('', 'ephemail'),
			('', 'filzmail'),
			('', 'gishpuppy'),
			('', 'guerrillamail'),
			('', 'haltospam'),
			('', 'jetable'),
			('', 'kasmail'),
			('', 'link2mail'),
			('', 'mail'),
			('', 'mail-temporaire'),
			('', 'maileater'),
			('', 'mailexpire'),
			('', 'mailhazard'),
			('', 'mailinator'),
			('', 'mailNull'),
			('', 'mytempemail'),
			('', 'mytrashmail'),
			('', 'nobulk'),
			('', 'nospamfor'),
			('', 'PookMail'),
			('', 'saynotospams'),
			('', 'shortmail'),
			('', 'sneakemail'),
			('', 'spam'),
			('', 'spambob'),
			('', 'spambox'),
			('', 'spamDay'),
			('', 'spamfree24'),
			('', 'spamgourmet'),
			('', 'spamh0le'),
			('', 'spaml'),
			('', 'tempemail'),
			('', 'tempInbox'),
			('', 'tempomail'),
			('', 'temporaryinbox'),
			('', 'trashmail'),
			('', 'willhackforfood'),
			('', 'willSelfdestruct'),
			('', 'wuzupmail'),
			('', 'yopmail');";
	break;

	case "mails_msg":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";	
	break;

	case "mails_unsubscribe":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`active` float NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`),
			UNIQUE KEY `author` (`author`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "maintenance":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`value` varchar(256) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`) VALUES
		(1, 'status', 'open'),
		(2, 'title', 'Le site est temporairement inaccessible'),
		(3, 'description', 'Le site est temporairement inaccessible en raison d’activités de maintenance planifiées...');";
	break;

	case "newsletter":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`email` varchar(256) NOT NULL,
			`sendmail` int NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "newsletter_send":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`template` int NOT NULL,
			`author` varchar(32) NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "newsletter_tpl":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`template` varchar(128) NOT NULL,
			`author` varchar(32) NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_forum":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_forum_post":
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
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_forum_posts":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_forum_threads":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_news":
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
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_news_cat":
			$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
			$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
				`id` int NOT NULL AUTO_INCREMENT,
				`name` varchar(64) NOT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_shoutbox":
			$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
			$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
				`id` int NOT NULL AUTO_INCREMENT,
				`hash_key` varchar(32) NOT NULL,
				`avatar` varchar(256) NOT NULL,
				`date_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`msg` text,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_stats":
			$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
			$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
				`id` int NOT NULL AUTO_INCREMENT,
				`nb_view` bigint NOT NULL DEFAULT '0',
				`page` varchar(32) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `nb_view`, `page`) VALUES
			('', 0, 'calendar'),
			('', 0, 'comments'),
			('', 0, 'downloads'),
			('', 0, 'articles'),
			('', 0, 'events'),
			('', 0, 'forum'),
			('', 0, 'groups'),
			('', 0, 'inbox'),
			('', 0, 'market'),
			('', 0, 'members'),
			('', 0, 'newsletter'),
			('', 0, 'page'),
			('', 0, 'shoutbox'),
			('', 0, 'survey'),
			('', 0, 'team'),
			('', 0, 'user'),
			('', 0, 'news'),
			('', 0, 'mails'),
			('', 0, 'games');";
	break;

	case "page_survey":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`idvote` int NOT NULL,
			`number` varchar(256) NOT NULL,
			`content` text NOT NULL,
			`vote` int DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_survey_author":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`idvote` int NOT NULL,
			`author` varchar(32) NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "page_survey_quest":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`name` text NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users":
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
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`username`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	break;

	case "users_gaming":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`name_game` text NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users_groups":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`user_group` int DEFAULT '0',
			`user_groups` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users_page":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`namepage` text,
			`last_visit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users_profils":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`gender` varchar(11) DEFAULT NULL,
			`public_mail` varchar(128) DEFAULT NULL,
			`websites` text,
			`list_ip` text,
			`avatar` text,
			`config` text,
			`info_text` text,
			`birthday` date DEFAULT NULL,
			`country` varchar(30) DEFAULT NULL,
			`hight_avatar` varchar(255) DEFAULT NULL,
			`friends` longtext,
			`date_registration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`),
			UNIQUE KEY `hash_key` (`hash_key`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users_social":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "visitors":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`visitor_user` varchar(255) DEFAULT NULL,
			`visitor_ip` varchar(32) DEFAULT NULL,
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "widgets":
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
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `title`, `groups_access`, `groups_admin`, `active`, `pos`, `orderby`, `pages`) VALUES
			('', 'connected', 'Connecté', '0', '1', 0, 'right', 1, ''),
			('', 'lastconnected', 'Dernier connecté', '0', '1', 0, 'right', 2, ''),
			('', 'newsletter', 'Newsletter', '0', '1', 0, 'left', 2, ''),
			('', 'shoutbox', 'T\'chats', '0', '1', 0, 'bottom', 1, ''),
			('', 'survey', 'Sondages', '0', '1', 0, 'left', 2, ''),
			('', 'users', 'Utilisateurs', '0', '1', 0, 'left', 1, '');";
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