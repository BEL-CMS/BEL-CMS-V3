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

	case "capcha":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`IP` varchar(45) NOT NULL,
			`dateinsert` varchar(5) DEFAULT NULL,
			`code` varchar(32) NOT NULL,
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
			('', 'HOST', '".$host."', 1),
			('', 'LANDING', '0', 1),
			('', 'COOKIES', '".randomString(6)."', 1);";
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
			('', 'gallery', 1, '1|2|0', '1|2', 'MAX_IMG==5'),
			('', 'managements', 1, '1', '1', ''),
			('', 'news', 1, '1|0', '1', 'MAX_NEWS==1'),
			('', 'mails', 1, '2', '1', NULL),
			('', 'games', 1, '1|0', '1', 'MAX_GAMING_PAGE==5'),
			('', 'guestbook', 1, '1|2|0', '1|2', 'MAX_USER==6'),
			('', 'market', 1, '1|0', '1', 'NB_BUY==6{||}NB_BILLING==10'),
			('', 'donations', 0, '1|2|0', '1', NULL),
			('', 'calendar', 1, '0', '1|2', 'MAX_LIST==2'),
			('', 'faq', 1, '1|2|0', '1|2', NULL),
			('', 'links', 1, '1|2|0', '1|2', 'MAX_LINKS==6'),
			('', 'newsletter', 1, '1|2|0', '1|2', 'MAX_LINKS==6');";
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

	case 'downlaods_stats':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`id_dls` int NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
	  		`size` varchar(64) NOT NULL,
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'events_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(32) NOT NULL,
			`color` varchar(7) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'faq_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'gallery':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`name` varchar(128) DEFAULT NULL,
			`uploader` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`image` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`description` text,
			`cat` int DEFAULT NULL,
			`view` int NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case 'gallery_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL,
			`name` varchar(64) NOT NULL,
			`screen` varchar(128) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

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

	case 'guestbook':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` text NOT NULL,
			`message` text,
			`date_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
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

	case "market":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_cat":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`screen` text NOT NULL,
			`user_groups` text,
			`img` varchar(128) DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_address":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_img":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`id_market` int NOT NULL,
			`img` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_link":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`id_purchase` text,
			`link` text,
			`downloads` int DEFAULT NULL,
			`key_dl` varchar(32) DEFAULT NULL,
			PRIMARY KEY (`id`)
	  	) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_sold":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "market_tva":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
		  `id` int NOT NULL AUTO_INCREMENT,
		  `country` varchar(2) NOT NULL DEFAULT 'FR',
		  `price` tinyint NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

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

	case "market_order":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`id_command` int NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "newsletter":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`email` varchar(256) NOT NULL,
			`registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "newsletter_send":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`template` int NOT NULL,
			`receiver` text,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`send` tinyint(1) DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "newsletter_tpl":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`template` varchar(128) NOT NULL,
			`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "donations":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
			`last_name` text,
			`adress` text,
			`iban` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`bic` varchar(16) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "donations_receive":
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
				`lockpost` int NOT NULL,
				`viewpost` int NOT NULL,
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
				`image` text,
				`file` text,
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
			('', 0, 'user'),
			('', 0, 'news'),
			('', 0, 'mails'),
			('', 0, 'games'),
			('', 0, 'guestbook'),
			('', 0, 'donations'),
			('', 0, 'gallery'),
			('', 0, 'faq'),
			('', 0, 'links'),
			('', 0, 'team');";
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

	case "paypal":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) NOT NULL,
			`value` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		
		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `value`) VALUES
			('', 'PAYPAL_SANDBOX', 'false'),
			('', 'PAYPAL_SANDBOX_CLIENT_ID', ''),
			('', 'PAYPAL_SANDBOX_CLIENT_SECRET', ''),
			('', 'PAYPAL_PROD_CLIENT_ID', ''),
			('', 'PAYPAL_PROD_CLIENT_SECRET', ''),
			('', 'PAYPAL_CURRENCY', 'EUR'),
			('', 'PAYPAL_LOGO', ''),
			('', 'PAYPAL_COUNTRY', ''),
			('', 'PAYPAL_ADRESS', '');";
	break;

	case "paypal_purchase":
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
			`hash_dls` text DEFAULT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `purchase` (`id_purchase`),
			UNIQUE KEY `id_paypal` (`id_paypal`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "team":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "team_users":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`teamid` varchar(16) NOT NULL,
			`author` varchar(32) NOT NULL,
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

	case "notificaton":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`hash_key` varchar(32) NOT NULL,
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`ip` text NOT NULL,
			`message` text NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "users_notification":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`author` varchar(32) NOT NULL,
			`date_notif` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`message` text,
			`ip` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "uploads_admin":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "links":
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
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	break;

	case "links_cat":
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name` varchar(64) DEFAULT NULL,
			`color` varchar(16) DEFAULT NULL,
			`description` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
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