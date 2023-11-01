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

use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class AdminPages
{
	var		$active;
	var		$vars  = array();
	var		$admin = false;

	public 	$render = null,
			$bdd,
			$models;

	function __construct()
	{
		self::loadLang();

		if ($this->active === false) {
			self::pageOff();
			Notification::error('Page fermer manuellement, via le fichier : controller.<br>Veuillez le réactiver via le FTP manuellement la variable $active sur true');
		} else if ($this->admin === true) {
			if (in_array(1, $_SESSION['USER']->groups->all_groups)) {
				self::superAdmin();
			}
		}

		if (isset($this->bdd) and !empty($this->bdd)){
			self::loadModel($this->bdd);
		}
	}
	#########################################
	# récupère le models (BDD)
	#########################################
	private function loadModel ($name)
	{
		switch ($_REQUEST['option']) {
			case 'pages':
				$dir = self::getDir('pages');
			break;

			case 'widgets':
				$dir = self::getDir('widgets');
			break;

			case 'gaming':
				$dir = self::getDir('gaming');
			break;

			case 'templates':
				$dir = self::getDir('templates');
			break;

			case 'parameter':
				$dir = self::getDir('parameter');
			break;

			case 'users':
				$dir = self::getDir('users');
			break;

			case 'extras':
				$dir = self::getDir('extras');
			break;

			default:
				$dir = null;
			break;
		}

		if ($dir !== null) {
			if (is_file($dir)) {
				require_once $dir;
				$this->models = new $name();
			} else {
				Notification::error(constant('UNKNOW_MODELS'), 'Models');
			}
		} else {
			Notification::error(constant('UNKNOW_MODELS_DL'), 'Models');
		}
	}
	#########################################
	# Retourne le chemin complet du models
	#########################################
	private function getDir ($data = null)
	{
		return ROOT.DS.'managements'.DS.$data.DS.strtolower(strtolower(get_class($this))).DS.'models.php';
	}
	#########################################
	# Page désactiver manuellement
	#########################################
	private function pageOff ()
	{
		ob_start();
		
		Notification::warning('La page demander n\'est pas accesible', 'Page');

		$this->render = ob_get_contents();

		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return;
	}
	#########################################
	# Page uniquement au admin supreme (grp 1)
	#########################################
	private function superAdmin ()
	{
		ob_start();
		?>
			<?php
				Notification::error('La page demander n\'est accesible qu\'aux administrateur de niveau 1', 'Page');
				$this->render = ob_get_contents();

			if (ob_get_length() != 0) {
				ob_end_clean();
			}
			?>
		<?php	
		return;
	}
	#########################################
	# Enregsitre les variables dans vars
	#########################################
	function set ($d) {
		$this->vars = array_merge($this->vars,$d);
	}
	#########################################
	# Rendu de la page demander
	#########################################
	public function render ($filename, $menu = array())
	{
		extract($this->vars);
		ob_start();

		if ($this->admin === true) {
			if (!in_array(1, $_SESSION['USER']->groups->all_groups)) {
				self::superAdmin();
				return;
			}
		}

		if (!empty($menu)):
			$title = defined(strtoupper(get_class($this))) ? constant(strtoupper(get_class($this))) : get_class($this);
		?>

		<div class="card mt-3">
			<div class="card-header">
				<h3 style="padding: 0;margin: 0;" class="card-title">Menu Principal : <?=$title;?></h3>
		  	</div>
		  	<div class="card-body">
				<?php
				foreach ($menu as $k => $v) {
					foreach ($v as $key => $value) {
						if (empty($value['color'])) {
							$value['color'] = '';
						}
					?>
				<a class="btn btn-app <?=$value['color']?>" href="<?=$value['href']?>">
					<i class="<?=$value['icon']?>"></i>
					<?=$key?>
				</a>
					<?php
					}
				}
				?>
			</div>
		</div>
		<?php
		endif;

		switch ($_REQUEST['option']) {
			case 'pages':
				$filename = ROOT.DS.'managements'.DS.'pages'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'widgets':
				$filename = ROOT.DS.'managements'.DS.'widgets'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'parameter':
				$filename = ROOT.DS.'managements'.DS.'parameter'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'gaming':
				$filename = ROOT.DS.'managements'.DS.'gaming'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'templates':
				$filename = ROOT.DS.'managements'.DS.'templates'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'users':
				$filename = ROOT.DS.'managements'.DS.'users'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			case 'extras':
				$filename = ROOT.DS.'managements'.DS.'extras'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			break;

			default:
				Notification::error('Fichier : <strong>'.$filename.' </strong>non disponible...', 'Fichier');
			break;
		}

		if (is_file($filename)) {
			require_once $filename;
		}

		$this->render = ob_get_contents();

		?>
		</div>

		<?php
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
	}
	#########################################
	# récupère le fichier lang
	#########################################
	private function loadLang ()
	{
		if (isset($_REQUEST['option'])) {
			switch ($_REQUEST['option']) {
				case 'pages':
					$dir = ROOT.DS.'managements'.DS.'pages'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'widgets':
					$dir = ROOT.DS.'managements'.DS.'widgets'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'gaming':
					$dir = ROOT.DS.'managements'.DS.'gaming'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'templates':
					$dir = ROOT.DS.'managements'.DS.'templates'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'parameter':
					$dir = ROOT.DS.'managements'.DS.'parameter'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'users':
					$dir = ROOT.DS.'managements'.DS.'users'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;

				case 'extras':
					$dir = ROOT.DS.'managements'.DS.'extras'.DS.strtolower(get_class($this)).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
				break;
			
				default:
					$dir = null;
				break;
			}
		} else {
			$dir = null;
		}

		if ($dir !== null) {
			if (is_file($dir)) {
				require_once $dir;
			}
		}

		if (is_file(constant('MANAGEMENTS').DS.'lang'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php')) {
			require constant('MANAGEMENTS').DS.'lang'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
		}
	}
	#########################################
	# Retourne erreur ou le texte defini
	#########################################
	function error ($title, $msg, $type)
	{
		ob_start();
		?>
		<div id="page-content">
			<ul class="breadcrumb breadcrumb-top">
				<li>Index</li>
			</ul>
			<?php
			Notification::$type($msg, $title);
			$this->render = ob_get_contents();
			?>
		</div>
		<?php
		ob_end_clean();
	}
	#########################################
	# Retourne le debug
	#########################################
	function debug($a, $b = false) {
		ob_start();
		debug($a);
		$this->render = ob_get_contents();
		ob_end_clean();
		if ($b == true) {
			die();
		}
	}
	#########################################
	# Redirection
	#########################################
	function redirect ($url = null, $time = null)
	{
		if ($url === true) {
			$url = $_SERVER['HTTP_REFERER'];
			header("Refresh:$time");
		}

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
		header("refresh:$time;url='$url'");
	}
}