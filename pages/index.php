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

namespace Belcms\Pages;
use BelCMS\Core\Dispatcher;
use BelCMS\Core\Notification;
use BelCMS\PDO\BDD;
use BelCMS\Core\Secures;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

#########################################
# Demarre la class Pages
#########################################
class Pages
{
	var 		$vars = array(),
				$useModels,
				$typeMime = 'text/html',
				$error    = false,
				$errorInfos,
				$data;

	public		$page,
				$subPage,
				$id,
				$models;

	protected 	$pageName,
				$subPageName;

	function __construct()
	{
		if (isset($this->useModels) and !empty($this->useModels)){
			self::loadModel($this->useModels);
		}
		// Extrait les données mis en variable pour les données à la page HTML.
		$this->data        = self::get();
		$this->pageName    = Dispatcher::page();
		$this->subPageName = Dispatcher::view();
		$this->id          = isset($_GET['id']) ? $_GET['id'] : 0 ;
		$dirLangs = constant('DIR_PAGES').strtolower($this->pageName).DS.'langs'.DS.'lang.'.$_SESSION['CONFIG_CMS']['CMS_WEBSITE_LANG'].'.php';
		if (is_file($dirLangs)) {
			include $dirLangs;
		}
	}
	#########################################
	# Retourne le rendu de la page,
	# et gère les accès & variables (set);
	#########################################
	function render($filename)
	{
		// Test si l'utilisateur a accès à la page.
		if (Secures::getAccessPage(strtolower($this->pageName)) === false) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('NO_ACCESS_GROUP_PAGE'), 'Info', $full = false);
			return false;
		}
		// Test si la page est activée.
		if (Secures::getPageActive(strtolower($this->pageName)) === false) {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_PAGE'), 'warning', false);
			return false;
		}
		extract($this->vars);
		// Démarre la mémoire tampon
		ob_start();
		// Si il y a un template 
		if (!empty($_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'])) {
			// Si il y a un template avec une page custom
			$dir = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.strtolower($this->pageName).'.'.strtolower($filename).'.php';
			// Si le fichier existe, on inclut
			if (is_file($dir)) {
				include $dir;
			// Autrement on test de prendre la page par default
			} else {
				$dir = constant('DIR_PAGES').strtolower($this->pageName).DS.$filename.'.php';
				// test si le fichier exsite dans la page (normalement oui, c'est un fichier d'origine).
				if (is_file($dir)) {
					include $dir;
				// Autrement une page d'erreur se met en route.
				} else {
					$this->error = true;
					$this->errorInfos = array('warning', $error_text, constant('NOT_FOUND'), $full = true);
					return false;
				}
			}
		// S'il n'y a pas de template
		} else {
			// On teste s'il a une page custom dans le template par défaut
			$custom = constant('DIR_TPL').strtolower('default').DS.'custom'.DS.strtolower($this->pageName).'.'.strtolower($filename).'.php';
			$dirDefault = constant('DIR_PAGES').strtolower($this->pageName).DS.$filename.'.php';
			// Si le fichier existe, on inclut
			if (is_file($custom)) {
				include $custom;
			// Si pas, on essaye d'inclure le fichier par défaut (il doit exister normalement !)
			} else if (is_file($dirDefault)) {
				include $dirDefault;
			// Vraiment, au cas où le fichier a été effacé, j'inclus une erreur
			} else {
				$this->error = true;
				$this->errorInfos = array('warning', $error_text, constant('FILE_NO_FOUND'), $full = true);
				return false;
			}
		}
		// Met en le tampon dans une variable ($this->page);
		$this->page = ob_get_contents();
		// Verifie si le tampon est rempli, 
		// Détruit les données du tampon de sortie
		// et éteint la temporisation de sortie.
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
	}
	#########################################
	# inclus le models
	#########################################
	public function loadModel ($name)
	{
		$dir = constant('DIR_PAGES').strtolower($name).DS.'models.php';

		if (is_file($dir)) {
			require_once $dir;
			$name = "Belcms\Pages\Models\\".$name;
			$this->models = new $name();
		} else {
			$error_name   = constant('FILE_NO_FOUND_MODELS');
			$error_text   = constant('FILE').' : <br>'.$dir.' '.constant('NOT_FOUND');
			$this->error  = true;
			$this->errorInfos = array('error', $error_text, $error_name, $full = true);
			return false;
		}
	}
	#########################################
	# récupere le fichier de langue
	#########################################
	public function loadLang ($name)
	{
		$fileLoadlang = constant('DIR_PAGES').strtolower($name).DS.'langs'.DS.'lang.fr.php';
		if (is_file($fileLoadlang)) {
			require $fileLoadlang;
		}
	}
	#########################################
	# Assemble les variable passé par,
	# le controller en $this-set(array());
	#########################################
	public function set ($d)
	{
		$this->vars = array_merge($this->vars,$d);
	}
	#########################################
	# Récupère les données passées par
	# un formulaire ou un lien.
	#########################################
	public function get ()
	{
		$request = $_SERVER['REQUEST_METHOD'] == 'POST' ? 'POST' : 'GET';
		if ($request == 'POST') {
			$return = $_POST;
		} else if ($request == 'GET') {
			$return = new Dispatcher;
			$return = $return->link;
		}
		return $return;
	}
	#########################################
	# Redirect
	#########################################
	function redirect ($url = null, $time = null)
	{
		if ($url === true) {
			$url = $_SERVER['HTTP_REFERER'];
			header("refresh:$time;url='$url'");
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
	#########################################
	# Redirection direct
	#########################################
	function linkHeader ($url = null)
	{
		header("Content-disposition: attachment; filename=$url");
		header("Content-Type: application/force-download");
		readfile($url);
	}
	#########################################
	# Pagination count nb ligne
	#########################################
	function paginationCount ($nb, $table, $where = false)
	{
		$return = 0;

		$sql = New BDD();
		$sql->table($table);
		if ($where !== false) {
			$sql->where($where);
		}
		$sql->count();
		$return = $sql->data;

		return $return;
	}
	#########################################
	# Pagination
	#########################################
	function pagination ($nbpp = '5', $page = null, $table = null, $where = false)
	{
		$nbpp        = $nbpp == 0 ? 5 : $nbpp;
		$current     = (int) Dispatcher::RequestPages();
		$page_url    = $page.'?';
		$total       = self::paginationCount($nbpp, $table, $where);
		$adjacents   = 1;
		$current     = ($current == 0 ? 1 : $current);
		$start       = ($current - 1) * $nbpp;
		$prev        = $current - 1;
		$next        = $current + 1;
		$setLastpage = ceil($total/$nbpp);
		$lpm1        = $setLastpage - 1;
		$setPaginate = null;

		if ($setLastpage > 1) {
			$setPaginate .= '<nav id="belcms_pagination"><ul>';
			if ($setLastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $setLastpage; $counter++) {
					if ($counter == $current) {
						$setPaginate.= '<li class="belcms_pagination_item active"><a href="#">'.$counter.'</a></li>';
					} else {
						$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
					}
				}
			} else if($setLastpage > 5 + ($adjacents * 2)) {
				if ($current < 1 + ($adjacents * 2)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="belcms_pagination_item active"><a href="#">'.$counter.'</a></li>';
						} else {
							$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
					$setPaginate .= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$setPaginate .= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$setLastpage.'">'.$setLastpage.'  </a></li>';
				}
				else if($setLastpage - ($adjacents * 2) > $current && $current > ($adjacents * 2)) {
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page=1">1</a></li>';
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page=2">2</a></li>';
					for ($counter = $current - $adjacents; $counter <= $current + $adjacents; $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="belcms_pagination_item active"><a href="#">'.$counter.'</a></li>';
						}
						else {
							$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$setLastpage.'">'.$setLastpage.'</a></li>';
				} else {
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page=1">1</a></li>';
					$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page=2">2</a></li>';
					for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="belcms_pagination_item active"><a href="#">'.$counter.'</a></li>';
						} else {
							$setPaginate.= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
				}
			}

			if ($current < $counter - 1) {
				$setPaginate .= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$next.'"><i class="fa-solid fa-forward"></i></a></li>';
				$setPaginate .= '<li class="belcms_pagination_item"><a href="'.$page_url.'page='.$setLastpage.'"><i class="fa-solid fa-slash"></i></a></li>';
			} else {
				$setPaginate .= '<li class="belcms_pagination_item disabled"><a href="#"><i class="fa-solid fa-forward"></i></a></li>';
				$setPaginate .= '<li class="belcms_pagination_item disabled"><a href="#"><i class="fa-solid fa-slash"></i></a></li>';
			}
		}

		return $setPaginate;
	}
}