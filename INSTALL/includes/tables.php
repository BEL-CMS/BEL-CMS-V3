<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
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
			`id` int(11) NOT NULL,
			`who` varchar(32) DEFAULT NULL,
			`author` varchar(32) DEFAULT NULL,
			`ip` text DEFAULT NULL,
			`email` text DEFAULT NULL,
			`date` datetime DEFAULT NULL,
			`endban` datetime NOT NULL DEFAULT current_timestamp(),
			`timeban` varchar(5) DEFAULT '0',
			`reason` text DEFAULT NULL,
			`number` int(11) NOT NULL DEFAULT 0,
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

	case 'comments':

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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

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
			('', 'CMS_VERSION', '3.0.9', 1),
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
			KEY `id` (`id`)
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

	case 'coockie_opt':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`title_cookies` varchar(64) DEFAULT NULL,
			`action` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `title_cookies`, `action`) VALUES
		(1, 'Le cookie', '<p style=\"text-align: justify;\">Les termes de &laquo; cookie &raquo; ou &laquo; traceur &raquo; recouvrent par exemple :</p>\r\n<ul style=\"text-align: justify;\">\r\n<li>les cookies HTTP,</li>\r\n<li>les cookies &laquo;&nbsp;flash&nbsp;&raquo;,</li>\r\n<li>le r&eacute;sultat du calcul d&rsquo;une empreinte unique du terminal dans le cas du &laquo;&nbsp;<a title=\"D&eacute;finition - Fingerprinting - Nouvelle fen&ecirc;tre \" href=\"https://www.cnil.fr/fr/definition/fingerprinting\" target=\"_blank\" rel=\"noopener\" data-entity-substitution=\"canonical\" data-entity-type=\"node\" data-entity-uuid=\"e83c2420-67f6-4fa5-82d4-420d90174e38\">fingerprinting</a>&nbsp;&raquo; (calcul d\'un identifiant unique du terminal bas&eacute;e sur des &eacute;l&eacute;ments de sa configuration &agrave; des fins de tra&ccedil;age),</li>\r\n<li>les pixels invisibles ou &laquo;&nbsp;web bugs&nbsp;&raquo;,</li>\r\n<li>tout autre identifiant g&eacute;n&eacute;r&eacute; par un logiciel ou un syst&egrave;me d\'exploitation (num&eacute;ro de s&eacute;rie, adresse MAC, identifiant unique de terminal (IDFV), ou tout ensemble de donn&eacute;es qui servent &agrave; calculer une empreinte unique du terminal (par exemple via une m&eacute;thode de &laquo; fingerprinting &raquo;).</li>\r\n</ul>\r\n<p style=\"text-align: justify;\">Ils peuvent &ecirc;tre d&eacute;pos&eacute;s et/ou lus, par exemple lors de la consultation d\'un site web, d&rsquo;une application mobile, ou encore de l\'installation ou de l\'utilisation d\'un logiciel et ce, quel que soit le type de terminal utilis&eacute;&nbsp;: ordinateur, smartphone, tablette num&eacute;rique ou console de jeux vid&eacute;o connect&eacute;e &agrave; internet.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<h2 style=\"text-align: justify;\">Quel est le cadre juridique applicable&nbsp;?</h2>\r\n<p>L\'article 5(3) de la directive 2002/58/CE modifi&eacute;e en 2009 pose le principe :&nbsp;</p>\r\n<ul>\r\n<li class=\"nomarker\">d\'un <span class=\"glossary-tooltips\" data-definition=\"consentement\"><span class=\"glossary-tooltips-title\">consentement</span></span> pr&eacute;alable de l\'utilisateur avant le&nbsp;stockage d\'informations sur son terminal ou l\'acc&egrave;s &agrave; des informations d&eacute;j&agrave; stock&eacute;es sur celui-ci&nbsp;;</li>\r\n<li>sauf&nbsp;si ces actions sont strictement n&eacute;cessaires &agrave; la fourniture d\'un service de communication en ligne express&eacute;ment demand&eacute; par l\'utilisateur ou ont pour finalit&eacute; exclusive de permettre ou faciliter une communication par voie &eacute;lectronique.</li>\r\n</ul>\r\n<p>L&rsquo;article 82 de la loi Informatique et Libert&eacute;s transpose ces dispositions en droit fran&ccedil;ais.</p>\r\n<p>La CNIL rappelle que le consentement pr&eacute;vu par ces dispositions renvoie &agrave; la d&eacute;finition et aux conditions pr&eacute;vues aux articles 4(11) et 7 du RGPD. Il doit donc &ecirc;tre libre, sp&eacute;cifique, &eacute;clair&eacute;, univoque et l&rsquo;utilisateur doit &ecirc;tre en mesure de le retirer, &agrave; tout moment, avec la m&ecirc;me simplicit&eacute; qu&rsquo;il l&rsquo;a accord&eacute;.</p>\r\n<p>Afin de rappeler et d&rsquo;expliciter le droit applicable au d&eacute;p&ocirc;t et &agrave; la lecture de traceurs dans le terminal de l&rsquo;utilisateur, la CNIL a adopt&eacute; le 17 septembre 2020 des <a title=\"Lignes directrices sur les cookies et autres traceurs (PDF, 287 ko) - Nouvelle fen&ecirc;tre \" href=\"https://www.cnil.fr/sites/cnil/files/atoms/files/lignes_directrices_de_la_cnil_sur_les_cookies_et_autres_traceurs.pdf\" target=\"_blank\" rel=\"noopener\">lignes directrices</a>, compl&eacute;t&eacute;es par une <a title=\"Recommandation sur les cookies et autres traceurs (PDF, 951 ko) - Nouvelle fen&ecirc;tre \" href=\"https://www.cnil.fr/sites/cnil/files/atoms/files/recommandation-cookies-et-autres-traceurs.pdf\" target=\"_blank\" rel=\"noopener\">recommandation </a>visant notamment&nbsp;&agrave; proposer des exemples de modalit&eacute;s pratiques de recueil du consentement.</p>'),
		(2, 'Inscription', '<h2 style=\"text-align: justify;\">En vous inscrivant, vous &ecirc;tes consenti &agrave; introduire un cookie</h2>\r\n<p style=\"text-align: justify;\">3 type de cookie sont applicables &agrave; l\'inscription et/ou login</p>\r\n<ul style=\"text-align: justify;\">\r\n<li>HASH_KEY qui sert comme identifiant,</li>\r\n<li>NAME votre nom d\'utilisateur</li>\r\n<li>PASS votre mot de passe crypte</li>\r\n<li>PHPSESSID la S_SESSION en cours renouvel&eacute; &agrave; chaque fois que vous utilisez le site</li>\r\n</ul>\r\n<h2 style=\"text-align: justify;\">La suppression des cookies</h2>\r\n<p style=\"text-align: justify;\">La suppression des cookies se fait par la simple d&eacute;connexion au site ou la dur&eacute;e du cookie s\'efface automatiquement au bout de trois mois.</p>');";
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

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `description`, `idcat`, `size`, `uploader`, `date`, `ext`, `view`, `dls`, `screen`, `download`) VALUES
		(1, 'jkhhkj', '<p>hjk</p>', 1, '123678', '0c4f77c88f5eafdc88a1f07ed3c8a471', '2024-08-20 14:39:57', 'vif', 10, 8, 'uploads/downloads/screen/coloriage-mandala-art-celtique-15.jpg', 'uploads/downloads/mandala-coloring-page-coloring-page-mandala_614522-2219.avif'),
		(2, 'Internet Download Manager (IDM)  v6.42 Build 14', '<p>jkhkij</p>', 1, '369069', '0c4f77c88f5eafdc88a1f07ed3c8a471', '2024-08-20 15:07:14', 'jpg', 1, 1, 'uploads/downloads/screen/coloriage-mandala-art-celtique-15.jpg', 'uploads/downloads/coloriage-mandala-art-celtique-15.jpg'),
		(3, 'gfdcxfg', '<p>hgfdghf</p>', 1, '369069', '0c4f77c88f5eafdc88a1f07ed3c8a471', '2024-08-20 15:08:29', 'jpg', 7, 4, 'uploads/downloads/screen/coloriage-mandala-art-celtique-15.jpg', 'uploads/downloads/coloriage-mandala-art-celtique-15.jpg');";

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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
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
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `name`, `dir`, `code`) VALUES
		(1, 'happy', '/uploads/emoticones/happy.gif', ':happy:'),
		(2, 'rire', '/uploads/emoticones/D.gif', ':D'),
		(3, 'embarassed', '/uploads/emoticones/embarassed.gif', ':embarassed:'),
		(4, 'frown', '/uploads/emoticones/frown.gif', ':-('),
		(5, 'angry', '/uploads/emoticones/angry.gif', ':angry:'),
		(6, 'cool', '/uploads/emoticones/cool.gif', ':cool:'),
		(7, 'innocent', '/uploads/emoticones/innocent.gif', ':innocent:'),
		(8, 'kiss', '/uploads/emoticones/kiss.gif', ':kiss:'),
		(9, 'laugh', '/uploads/emoticones/laugh.gif', ':laugh:'),
		(10, 'money-mouth', '/uploads/emoticones/money-mouth.gif', ':money-mouth:'),
		(11, 'mouth', '/uploads/emoticones/mouth.gif', ':mouth:'),
		(12, 'ph34r', '/uploads/emoticones/ph34r.gif', ':ph34r:'),
		(13, 'sealed', '/uploads/emoticones/sealed.gif', ':sealed:'),
		(14, 'sleep', '/uploads/emoticones/sleep.gif', ':sleep:'),
		(15, 'smile', '/uploads/emoticones/smile.gif', ':smile:'),
		(16, 'smile 2', '/uploads/emoticones/smile_2.gif', ':smile_2:'),
		(17, 'cool_2', '/uploads/emoticones/cool_2.gif', ':cool_2:'),
		(18, 'cry', '/uploads/emoticones/cry.gif', ':cry:'),
		(19, 'surprised', '/uploads/emoticones/surprised.gif', ':surprised:'),
		(20, 'tongue-out', '/uploads/emoticones/tongue-out.gif', ':tongue-out:'),
		(21, 'undecided', '/uploads/emoticones/undecided', ':undecided:'),
		(22, 'wink', '/uploads/emoticones/wink.gif', ':wink:'),
		(23, 'yell', '/uploads/emoticones/yell.gif', ':yell:');";
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
			`groups_access` text,
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
		(46, 'yopmail'),
		(47, 'shaw.ca'),
		(48, 'netzero.net');";
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
			`author` varchar(32) NOT NULL,
			`message` mediumtext,
			`upload` text,
			`subject` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
			`time_msg` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'mails_status':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`mail_id` varchar(32) NOT NULL,
			`author` varchar(32) NOT NULL,
			`author_send` varchar(32) NOT NULL,
			`subject` varchar(60) DEFAULT NULL,
			`read_msg` tinyint(1) NOT NULL DEFAULT '1',
			`receive` tinyint(1) NOT NULL DEFAULT '0',
			`archive` tinyint(1) NOT NULL DEFAULT '0',
			`close` tinyint(1) NOT NULL DEFAULT '0',
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

	case 'market_sold':
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
			(1, 'BE', 21),
			(2, 'BG', 20),
			(3, 'CZ', 21),
			(4, 'DK', 25),
			(5, 'DE', 19),
			(6, 'EE', 20),
			(7, 'IE', 23),
			(8, 'EL', 24),
			(9, 'ES', 21),
			(10, 'FR', 20),
			(11, 'HR', 25),
			(12, 'IT', 22),
			(13, 'CY', 19),
			(14, 'LV', 21),
			(15, 'LT', 21),
			(16, 'LU', 17),
			(17, 'HU', 27),
			(18, 'MT', 18),
			(19, 'NL', 21),
			(20, 'AT', 20),
			(21, 'PL', 23),
			(22, 'PT', 23),
			(23, 'RO', 19),
			(24, 'SI', 22),
			(25, 'SK', 20),
			(26, 'FI', 24),
			(27, 'SE', 25),
			(28, 'UK', 20),
			(29, '0', 21);";
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

		$insert = "INSERT INTO `".$_SESSION['prefix'].$table."` (`id`, `rewrite_name`, `name`, `date_create`, `author`, `authoredit`, `content`, `additionalcontent`, `tags`, `cat`, `view`, `img`) VALUES
			(1, '1er_news', '1er news', '0000-00-00 00:00:00', '', NULL, '<p style=\"text-align: justify;\">Bonjour et bienvenue sur le CMS (Bel-CMS), aucun compte a &eacute;t&eacute; cr&eacute;&eacute; lors de l\'installation, ne pas l\'oublier parce que c\'est celui qui aura tous les droits.</p>\r\n<p style=\"text-align: justify;\"><br />La version du C.M.S actuel est la <strong>3.0.8</strong> sur <strong>GitHub</strong> et sur le <strong>site</strong> la version <strong>3.0.9</strong>.</p>\r\n<p style=\"text-align: justify;\"><br />Si vous rencontrez le moindre souci, une erreur de frappe, une erreur de toute sorte, essay&eacute; de me pr&eacute;venir svp sur le <strong>Forum</strong>, Merci.</p>', NULL, 'news', '', 26, NULL);";
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
		('', 0, 'articles'),
		('', 0, 'calendar'),
		('', 0, 'comments'),
		('', 0, 'contact'),
		('', 0, 'cookies'),
		('', 0, 'donations'),
		('', 0, 'downloads'),
		('', 0, 'faq'),
		('', 0, 'forum'),
		('', 0, 'gallery'),
		('', 0, 'games'),
		('', 0, 'groups'),
		('', 0, 'guestbook'),
		('', 0, 'links'),
		('', 0, 'mails'),
		('', 0, 'market'),
		('', 0, 'members'),
		('', 0, 'news'),
		('', 0, 'newsletter'),
		('', 0, 'search'),
		('', 0, 'shoutbox'),
		('', 0, 'survey'),
		('', 0, 'teams'),
		('', 0, 'user');";
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
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`plan` int DEFAULT NULL,
			`sales` int DEFAULT '0',
			`type` varchar(32) NOT NULL,
			`verif` tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'rgpd':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`ip` varchar(128) NOT NULL,
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

	case 'tickets':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`subject` varchar(60) NOT NULL,
			`mail` varchar(128) DEFAULT NULL,
			`cat` tinyint DEFAULT '0',
			`date_insert` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`text_sbiject` text,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	break;

	case 'tickets_cat':
		$drop = 'DROP TABLE IF EXISTS `'.$_SESSION['prefix'].$table.'`';
		$sql  = "CREATE TABLE IF NOT EXISTS `".$_SESSION['prefix'].$table."` (
			`id` int NOT NULL AUTO_INCREMENT,
			`name_cat` varchar(128) DEFAULT NULL,
			`id_cat` tinyint NOT NULL DEFAULT '0',
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
		(1, 'stats', 'Statistique', '1|0', '1|2', 1, 'right', 1, 'articles|downloads|forum|games|news', NULL),
		(2, 'lastconnected', 'Dernier connecté', '1', '1', 1, 'right', 2, '', NULL),
		(3, 'newsletter', 'Newsletter', '0', '1', 0, 'right', 2, '', NULL),
		(4, 'shoutbox', 'T\'chat', '1|2|0', '1', 0, 'bottom', 1, 'news', 'MAX_MSG==15'),
		(5, 'survey', 'Sondages', '1|0', '1|2', 0, 'right', 2, 'comments|forum|articles', NULL),
		(6, 'users', 'Utilisateurs', '0', '1', 0, 'left', 1, '', NULL);";
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
		$error = 'ERROR DELETE DATA : '.$table.' : '.$Exception->getMessage();
		echo $error;
	}
	unset($cnx);
}
try { 
	$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password'], $pdo_options);
	$cnx->exec($sql);
	$error = 'Table_'.$_SESSION['prefix'].$table.' créer avec succès';
} catch(PDOException $Exception) {
	$error = 'ERROR BDD INSERT DATA : '.$table.' : '.$Exception->getMessage();
	echo $error;
}
unset($cnx);

if (!is_null($insert) and !empty($error)) {
	try {
		$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password'], $pdo_options);
		$cnx->exec($insert);
		echo 'Création et Insertion des donnes de la table '.$_SESSION['prefix'].$table.' ajouté avec succès';
	} catch(PDOException $Exception) {
		$error = 'ERROR BDD INSERT DATA : '.$table.' : '.$Exception->getMessage();
		echo $error;
	}
	unset($cnx);
}