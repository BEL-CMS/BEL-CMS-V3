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

class BelCMS
{
	var $page;

	function __construct()
	{
		if (!session_id()) {
			session_start();
		}
		$this->page = (!isset($_REQUEST['page'])) ? 'home' : $_REQUEST['page'];
		require_once ROOT.'INSTALL'.DS.'includes'.DS.'checkCompatibility.php';
	}

	public function VIEW()
	{
		ob_start();
		require ROOT.'INSTALL'.DS.'pages'.DS.$this->page.'.tpl';
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
			ob_start("ob_gzhandler");
			?>
			<!DOCTYPE HTML>
			<html lang="fr">
			    <head>
			    	<title>Installation du C.M.S [BEL-CMS]</title>
			        <meta charset="UTF-8">
			        <meta http-equiv="x-ua-compatible" content="ie=edge">
			        <link href="/INSTALL/img/favicon.ico" rel="shortcut icon">
			        <link type="text/plain" rel="author" href="/INSTALL/humans.txt">
			        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
			        <link rel="stylesheet" href="/INSTALL/css/styles.css">
			    </head>
			    <body>
			    	<main>
			    		<h1>Installation de BEL-CMS v3.0.0</h1>
			    		<?=self::VIEW()?>
			    	</main>
			        <script src="/INSTALL/js/jquery.min.js"></script>
			        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
			        <script src="/INSTALL/js/scripts.js"></script>
				</body>
			</html>
			<?php
			$buffer = ob_get_contents();
			ob_end_clean();
			return $buffer;
		}
	}

	public static function TABLES () {
		$tables = array(
			'articles',
			'articles_content',
			'ban',
			'comments',
			'config',
			'config_pages',
			'config_tpl',
			'downloads',
			'downloads_cat',
			'emoticones',
			'games',
			'groups',
			'guestbook',
			'interaction',
			'mails',
			'mails_blacklist',
			'mails_msg',
			'mails_unsubscribe',
			'maintenance',
			'market',
			'market_address',
			'market_cat',
			'market_link',
			'market_img',
			'market_sold',
			'market_order',
			'market_tva',
			'newsletter',
			'newsletter_send',
			'newsletter_tpl',
			'page_forum',
			'page_forum_post',
			'page_forum_posts',
			'page_forum_threads',
			'page_news',
			'page_news_cat',
			'page_shoutbox',
			'page_stats',
			'page_survey',
			'page_survey_author',
			'page_survey_quest',
			'paypal',
			'paypal_purchase',
			'users',
			'users_gaming',
			'users_groups',
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
function insertUserBDD ()
{
	$sql = array();

	$user['username']	= $_POST['username'];
	$user['password']	= password_hash($_POST['password'], PASSWORD_DEFAULT);
	$user['email']		= $_POST['email'];
	$user['hash_key']	= md5(uniqid(rand(), true));
	$user['ip']		= getIp();

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
				`gold`
			) VALUES (
				NULL , '".$user['username']."','".$user['hash_key']."','".$user['password']."','".$user['email']."','".$user['ip']."', '1', '0', '', '1'
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
				`config`,
				`info_text`,
				`birthday`,
				`country`,
				`hight_avatar`,
				`friends`,
				`date_registration`
				)
			VALUES (
				NULL , '".$user['hash_key']."', '', '', '', '', 'assets/img/default_avatar.jpg', '', '', '', '', '', '', NOW()
			);";

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
			$return = false;
	foreach ($sql as $insert) {
		try {
			$cnx = new PDO('mysql:host='.$_SESSION['host'].';port='.$_SESSION['port'].';dbname='.$_SESSION['dbname'], $_SESSION['username'], $_SESSION['password']);
			$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$cnx->exec($insert);
			$return = true;
		} catch(PDOException $e) {
			$return = $e->getMessage();
			return $return;
		}
		unset($cnx);
	}
	return $return;
}

function recursive_delete($dir) {
	$d = dir($dir);  
	if (is_dir($dir) && !is_link($dir)) {
	  if ($d = opendir($dir)) {
		while (($entry = readdir($d)) !== false) {
		  if ($entry == '.' || $entry == '..') continue;
		  $path = $dir .'/'. $entry;
		  if (is_file($path)) unlink($path);
		  if (is_dir($path)) recursive_delete($path);
		}
		closedir($d);
	  }
	  return rmdir($dir);
	}
	return unlink($dir);
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