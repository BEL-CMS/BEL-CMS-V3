<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
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
				redirect('/User/register&echo', 5);
				$_SESSION['INSTALL'] = true;
			}
			ob_start("ob_gzhandler");
			?>
			<!doctype html>
			<html lang="fr">
				<head>
					<meta charset="utf-8">
					<title>Installation de Bel-CMS : V.3.0.6</title>
					<link href="/INSTALL/css/FontAwesome.all.6.5.2.min.css" rel="stylesheet" >
					<link href="/INSTALL/css/bootstrap.5.2.3.min.css" rel="stylesheet">
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
					<script src="/INSTALL/js/jquery.min.3.6.3.js"></script>
					<script src="/INSTALL/js/particles.min.js"></script>
					<script src="/INSTALL/js/FontAwesome.all.6.5.2.min.js"></script>
					<script src="/INSTALL/js/popper_2.11.6.min.js"></script>
					<script src="/INSTALL/js/bootstrap_5.2.3.min.js"></script>
					<script src="/INSTALL/js/scripts.js"></script>
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
			'files_admin',
			'gallery',
			'gallery_cat',
			'gallery_cat_valid',
			'gallery_sub_cat',
			'gallery_vote',
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
			'search',
			'search_popular',
			'stats',
			'survey',
			'survey_answer',
			'survey_vote',
			'team',
			'team_users',
			'tickets',
			'tickets_cat',
			'uploads_admin',
			'users',
			'users_gaming',
			'users_groups',
			'users_notification',
			'users_page',
			'users_profils',
			'users_social',
			'visitors',
			'widgets',
			'rgpd',
			'contact_send',
			'coockie_opt',
			'gallery_sub_cat',
			'mails_msg',
			'mails_status',
			'gallery_sub_cat'
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