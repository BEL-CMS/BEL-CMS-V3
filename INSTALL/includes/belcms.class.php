<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.5 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

define('CHECK_INDEX', true);
require_once ROOT.'requires'.DS.'common.php';
require_once ROOT.'core'.DS.'class.encrypt.php';
use BelCMS\Core\encrypt;

class BelCMS
{
	var $page;

	function __construct()
	{
		if (!session_id()) {
			session_start();
			$_SESSION['CONFIG_CMS']['KEY_ADMIN'] = md5(uniqid(rand(), true));
		}
		$this->page = (!isset($_REQUEST['page'])) ? 'home' : $_REQUEST['page'];
		require_once ROOT.'INSTALL'.DS.'includes'.DS.'checkCompatibility.php';
	}

	public static function getIni($key)
	{
		foreach (ini_get_all(null, false) as $key => $value) {
			return $value;
		}
	}

	public function VIEW()
	{
		ob_start();
		require ROOT.'INSTALL'.DS.'pages'.DS.$this->page.'.php';
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	function insertUserBDD ()
	{
		$passwordCrypt = new encrypt($_POST['password'], $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
		$password      = $passwordCrypt->encrypt();

		$sql = array();

		$user['username']	= $_POST['username'];
		$user['mail']		= $_POST['mail'];
		$user['hash_key']	= md5(uniqid(rand(), true));
		$user['ip']		    = getIp();

		$sql[]  = "INSERT INTO `".$_SESSION['prefix']."users` (
					`id`,
					`username`,
					`hash_key`,
					`password`,
					`mail`,
					`ip`,
					`valid`,
					`expire`,
					`token`,
					`gold`,
					`number_valid`
				) VALUES (
					'' , '".$user['username']."','".$user['hash_key']."','".$password."','".$user['mail']."','".$user['ip']."', '1', '0', '', '1',''
				);";

		$sql[]  = "INSERT INTO `".$_SESSION['prefix']."users_page` (`id`, `hash_key`, `namepage`, `last_visit`) VALUES (
					'',
					'".$user['hash_key']."',
					NULL,
					NOW()
				);";

				$sql[]  = "INSERT INTO `".$_SESSION['prefix']."users_groups` (`id`, `hash_key`, `user_group`, `user_groups`) VALUES (
					'',
					'".$user['hash_key']."',
					1,
					1
				);";

				$sql[]  = "INSERT INTO `".$_SESSION['prefix']."users_profils` (
					`id`,
					`hash_key`,
					`gender`,
					`public_mail`,
					`websites`,
					`list_ip`,
					`avatar`,
					`info_text`,
					`birthday`,
					`country`,
					`hight_avatar`,
					`friends`,
					`date_registration`,
					`visits`,
					`gravatar`,
					`profils`)
				VALUES (
					'', '".$user['hash_key']."', NULL, NULL, NULL, NULL, 'assets/img/default_avatar.jpg', NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, NULL, '0', '0');";

		$sql[]  = "INSERT INTO `".$_SESSION['prefix']."users_social` (
					`id`,
					`hash_key`,
					`facebook`,
					`youtube`,
					`whatsapp`,
					`instagram`,
					`messenger`,
					`tiktok`,
					`snapchat`,
					`telegram`,
					`pinterest`,
					`x_twitter`,
					`reddit`,
					`linkedIn`,
					`skype`,
					`viber`,
					`teams_ms`,
					`discord`,
					`twitch` 	
					)
				VALUES (
					NULL , '".$user['hash_key']."', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL
				);";
		foreach ($sql as $insert) {
			try {
				$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password']);
				$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$cnx->exec($insert);
				$return = true;
			} catch(PDOException $e) {
				$return = $e->getMessage();
				debug($return);
			}
			unset($cnx);
		}
	}

	public function HTML()
	{
		if ($this->page == 'create_sql') {
			$table = $_REQUEST['table'];
			require_once ROOT.'INSTALL'.DS.'includes'.DS.'tables.php';
			if ($error === true) {
				echo json_encode(array($error));
			} else {
				echo json_encode(array($error));
			}
		} else {
			if ($this->page == 'finish') {
				self::insertUserBDD();
				//BelCMS::RepEfface(ROOT.'INSTALL');
			}
			ob_start("ob_gzhandler");
			?>
			<!doctype html>
			<html lang="fr">
				<head>
					<meta charset="utf-8">
					<title>Installation de Bel-CMS : V.3.0.5</title>
					<link href="http://cdn.determe.be/FontAwesome.all.6.5.2.min.css" rel="stylesheet" >
					<link href="http://cdn.determe.be/bootstrap.5.2.3.min.css" rel="stylesheet">
					<link href="/INSTALL/css/styles.css" rel="stylesheet" >
				</head>
				<body>
					<header class="container">
						<img src="/INSTALL/img/logo.png" alt="Logo Bel-CMS">
						<a href="https://bel-cms.dev" title="Bel-CMS">Bel-CMS</a>
					</header>
					<div id="background" class="container">
						<canvas class="background"></canvas>
					</div>
					<main id="main" class="container">
						<?=self::VIEW()?>
					</main>
					<footer class="container">
					<span>&copy; <a href="https://bel-cms.dev">Bel-CMS <?=date('Y');?></a></span>
					</footer>
					<script src="http://cdn.determe.be/jquery.min.3.6.3.js"></script>
					<script src="http://cdn.determe.be/particles.min.js"></script>
					<script src="http://cdn.determe.be/FontAwesome.all.6.5.2.min.js"></script>
					<script src="http://cdn.determe.be/popper_2.11.6.min.js"></script>
					<script src="http://cdn.determe.be/bootstrap_5.2.3.min.js"></script>
					<script src="http://cdn.determe.be/scripts.install_cms_3.0.5.js"></script>
				</body>
			</html>
			<?php
			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;
		}
	}

	public static function RepEfface($dir) {
	$handle = opendir($dir);
	while($elem = readdir($handle)) {
		if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
			self::RepEfface($dir.'/'.$elem);
		} else {
			if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
				unlink($dir.'/'.$elem);
			}
		}        
	}
	$handle = opendir($dir);
	while($elem = readdir($handle)) {
		if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.') {
			self::RepEfface($dir.'/'.$elem);
			rmdir($dir.'/'.$elem);
		}
	}
	rmdir($dir);
   }

	public static function TABLES () {
		$tables = array(
			'articles',
			'articles_content',
			'ban',
			'capcha',
			'comments',
			'config',
			'config_pages',
			'config_tpl',
			'contact',
			'contact_send',
			'donations',
			'donations_receive',
			'downlaods_stats',
			'downloads',
			'downloads_cat',
			'emoticones',
			'events',
			'events_cat',
			'faq',
			'faq_cat',
			'gallery',
			'gallery_cat',
			'games',
			'groups',
			'guestbook',
			'interaction',
			'links',
			'links_cat',
			'mails',
			'mails_blacklist',
			'mails_config',
			'mails_msg',
			'mails_unsubscribe',
			'maintenance',
			'market',
			'market_address',
			'market_cat',
			'market_img',
			'market_link',
			'market_order',
			'market_sold',
			'market_tva',
			'newsletter',
			'newsletter_send',
			'newsletter_tpl',
			'notificaton',
			'page_forum',
			'page_forum_post',
			'page_forum_posts',
			'page_forum_threads',
			'page_news',
			'page_news_cat',
			'page_shoutbox',
			'page_stats',
			'paypal',
			'paypal_purchase',
			'stats',
			'survey',
			'survey_answer',
			'survey_vote',
			'team',
			'team_users',
			'uploads_admin',
			'users',
			'users_gaming',
			'users_groups',
			'users_notification',
			'users_page',
			'users_profils',
			'users_social',
			'visitors',
			'widgets'
		);
		return $tables;
	}
}
#########################################
# Debug
#########################################
function debug ($data = null, $exitAfter = false)
{
	echo '<pre>';
		print_r($data);
	echo '</pre>';
	if ($exitAfter === true) {
		exit();
	}
}
function redirect ($url = null, $time = null)
{
	$scriptName = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

	$fullUrl = ($_SERVER['HTTP_HOST'].$scriptName);

	if (!strpos($_SERVER['HTTP_HOST'], $scriptName)) {
		$fullUrl = $_SERVER['HTTP_HOST'].$scriptName.$url;
	}

	if (!strpos($fullUrl, 'http://')) {
		if ($_SERVER['SERVER_PORT'] == 80) {
			$url = 'http://'.$fullUrl;
		} else if ($_SERVER['SERVER_PORT'] == 443) {
			$url = 'https://'.$fullUrl;
		} else {
			$url = 'http://'.$fullUrl;
		}
	}

	$time = (empty($time)) ? 0 : (int) $time * 1000;

	?>
	<script>
	window.setTimeout(function() {
		window.location = '<?php echo $url; ?>';
	}, <?php echo $time; ?>);
	</script>
	<?php
}

function getIp () {
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$return = $_SERVER['HTTP_CLIENT_IP'];
	}
	else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$return = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$return = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
	}
	if ($return == '::1') {
		$return = '127.0.0.1';
	}
	return $return;
}
?>