<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
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
				$_SESSION['INSTALL'] = true;
			}
			ob_start("ob_gzhandler");
			?>
				<!doctype html>
				<html lang="fr">
				<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<meta name="theme-color" content="#2B2B35">
				<link rel="stylesheet" href="css/plugins/bootstrap.min.css">
				<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
				<link rel="stylesheet" href="css/plugins/swiper.min.css">
				<link rel="stylesheet" href="css/plugins/fancybox.min.css">
				<link rel="stylesheet" href="css/style.css">
				<link rel="stylesheet" href="css/color-3.css">
				<title>Bel-CMS v 3.1.0 :: Installation</title>
				</head>
				<body>
				<div class="art-app">
					<div class="art-mobile-top-bar"></div>
					<div class="art-app-wrapper">
					<div class="art-app-container">
						<div class="art-info-bar">
						<div class="art-info-bar-frame">
							<div class="art-info-bar-header">
							<a class="art-info-bar-btn" href="#.">
								<i class="fas fa-ellipsis-v"></i>
							</a>
							</div>
							<div class="art-header">
							<div class="art-avatar">
								<a data-fancybox="avatar" href="img/logo.jpg" class="art-avatar-curtain">
								<img src="img/logo.jpg" alt="logo">
								</a>
							</div>
							</div>
							<div id="scrollbar2" class="art-scroll-frame">
								<div class="art-table p-15-15">
									<ul>
									<li>
										<h6>Discord :</h6><span><a href="https://discord.gg/mV7ZPZgR4z">Redjoindre</a></span>
									</li>
									<li>
										<h6>X (Twitter) :</h6><span><a href="https://x.com/BelCMS_V3">X</a></span>
									</li>
									<li>
										<h6>Facebook :</h6><span><a href="https://www.facebook.com/Bel.CMS">Lien</a></span>
									</li>
									</ul>
								</div>
								<div class="art-ls-divider"></div>
							</div>
						</div>
						</div>
						<div class="art-content">
						<div class="art-curtain"></div>
						<div class="art-top-bg" style="background-image: url(img/bg.jpg)">
							<div class="art-top-bg-overlay"></div>
						</div>
						<div class="transition-fade" id="swup">
							<div id="scrollbar" class="art-scroll-frame">
							<div class="container-fluid">
								<div class="row p-30-0">
								<div class="col-lg-12">
									<div class="art-section-title">
									<div class="art-title-frame">
										<h4>Bel-CMS V3.1.0 : Installation</h4>
									</div>
									</div>
								</div>
								</div>
							</div>
							<?php
							if ($this->page == 'home'):
							?>
							<div class="container-fluid">
								<div class="row p-30-0">
								<div class="col-lg-8">
									<div class="art-a art-card art-fluid-card">
									<h5 class="mb-15">Description</h5>
									<div class="mb-15" style="text-align: justify;">
										BelCMS est un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.<br>
										Dans un langage plus simple, un système de gestion de contenu est un outil qui vous aide à construire un site Web sans avoir besoin d’écrire tout le code à partir de zéro (ou même de savoir comment coder du tout).
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="art-a art-card">
									<div class="art-table p-15-15">
										<ul>
										<li>
											<h6>Date MAJ :</h6><span>10.12.2024</span>
										</li>
										<li>
											<h6>Version :</h6><span>3.9.0</span>
										</li>
										</ul>
									</div>
									</div>
								</div>
								</div>
							</div>
							<?php
							endif;
							?>
							<div class="container-fluid">
								<div class="row">
								<div class="col-lg-12">
									<div class="art-a art-card">
									<?=self::VIEW()?>
									</div>
								</div>
								</div>
							</div>
							<div class="container-fluid">
								<footer>
								<div>© <?=date('Y');?> Bel-CMS v3</div>
								</footer>
							</div>
							</div>
						</div>
						</div>
						<div class="art-menu-bar">
						<div class="art-menu-bar-frame">
							<div class="art-menu-bar-header">
							<a class="art-menu-bar-btn" href="#.">
								<span></span>
							</a>
							</div>
							<div class="art-current-page"></div>
							<div class="art-scroll-frame">
							<nav id="swupMenu">
								<ul class="main-menu">
								<li class="menu-item"><a href="index.php">Accueil</a></li>
								<li class="menu-item"><a href="index.php&var=check">Vérification</a></li>
								<li class="menu-item"><a href="index.php&var=BDD">Installation BDD</a></li>
								<li class="menu-item"><a href="index.php&var=user">Utilisateur</a></li>
								</ul>
							</nav>
							<ul class="art-language-change">
								<li class="art-active-lang"><a href="#.">FR</a></li>
							</ul>
							</div>
						</div>
						</div>
					</div>
					</div>
					<div class="art-preloader">
					<div class="art-preloader-content">
						<h4>Bel-CMS Installation</h4>
						<div id="preloader" class="art-preloader-load"></div>
					</div>
					</div>
				</div>
				<script src="js/plugins/jquery.min.js"></script>

				<script src="js/plugins/anime.min.js"></script>
				<script src="js/plugins/swiper.min.js"></script>
				<script src="js/plugins/progressbar.min.js"></script>
				<script src="js/plugins/smooth-scrollbar.min.js"></script>
				<script src="js/plugins/overscroll.min.js"></script>
				<script src="js/plugins/isotope.min.js"></script>
				<script src="js/plugins/fancybox.min.js"></script>
				<script src="js/plugins/swup.min.js"></script>
				<script src="js/main.js"></script>
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
			'coockie_opt',
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
			'mails_blacklist',
			'mails_config',
			'mails_msg',
			'mails_status',
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
			'pricing',
			'pricing_list',
			'pricing_sales',
			'rgpd',
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
			'users_hardware',
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