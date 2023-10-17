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

namespace Belcms\Pages;
use BelCMS\Core\Notification as Notification;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Core\Secures as Secures;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

#########################################
# Demarre une $_SESSION
#########################################
class Pages
{
	var $vars = array(),
		$intern;

	public	$page;

	private $models,
			$data;

	function __construct()
	{
		self::get();
		if (isset($this->models) and !empty($this->models)){
			self::loadModel($this->models);
		}
	}
	#########################################
	# Retourne le rendu de la page,
	# et gère les accès & variables (set);
	#########################################
	function render($filename)
	{
		// Test si l'utilisateur a accès à la page.
		if (Secures::getAccessPage(strtolower(get_class($this))) === false) {
			self::error('Page', constant('NO_ACCESS_GROUP_PAGE'), 'infos');
			return false;
		}
		// Test si la page est activée.
		if (Secures::getPageActive(strtolower(get_class($this))) === false) {
			self::error('Page', constant('NO_ACCESS_PAGE'), 'warning');
			return false;
		}
		// Extrait les données mis en variable pour les données à la page HTML.
		extract($this->vars);
		// Démarre la mémoire tampon
		ob_start();
		if ($this->intern) {
			$dir    = constant('DIR_ADMIN').'pages'.DS.strtolower(get_class($this)).DS.$filename.'.php';
			$custom = null;
		} else {
			if (defined('MANAGEMENT')) {
				$dir = isset($_GET['widgets']) ?
				$dir = constant('DIR_WIDGETS').strtolower(get_class($this)).DS.'management'.DS.$filename.'.php':
				$dir = constant('DIR_PAGES').strtolower(get_class($this)).DS.'management'.DS.$filename.'.php';
			} else {
				$dir = constant('DIR_PAGES').strtolower(get_class($this)).DS.$filename.'.php';
			}
			$custom = defined('MANAGEMENT') ? null :
				constant('DIR_TPL').constant('CMS_TPL_WEBSITE').DS.'custom'.DS.lcfirst(get_class($this)).'.'.$filename.'.php';
		}
		// Regarde s'il y a un fichier personnalisé et l'inclus,
		// ou bien récupère l'original.
		if (is_file($custom)) {
			require_once $custom;
		} else if (is_file($dir)) {
			require_once $dir;
		} else {
			$error_name    = constant('FILE_NO_FOUND');
			$error_content = '<p><strong>'.constant('FILE').' : '.$filename.' '.constant('NO_FOUND').'</strong><p>';
			self::error($error_name, $error_content, 'error');
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
	private function models ()
	{
		$this->models = '';
	}
	#########################################
	# Assemble les variable passé par,
	# le controller en $this-set(array());
	#########################################
	function set ($d)
	{
		$this->vars = array_merge($this->vars,$d);
	}
	#########################################
	# Récupère les données passées par
	# un formulaire ou un lien.
	#########################################
	private function get ()
	{
		$this->data = $_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST : $_GET;
	}
	#########################################
	# inclus le models
	#########################################
	function loadModel ($models)
	{
		$dir = null;
		if (is_file($dir)) {
			require_once $dir;
			$this->models = new $name();
		} else {
			ob_start();
			$error_name    = constant('FILE_NO_FOUND');
			$error_content = '<p><strong>'.constant('FILE').' : '.$dir.' '.constant('NO_FOUND').'</strong><p>';
			self::error($error_name, $error_content, 'error');
			ob_end_clean();
		}
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
	function link ($url = null, $time = null)
	{
		header("refresh:$time;url='$url'");
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
		$management  = defined('MANAGEMENT') ? '?management&' : '?';
		$current     = (int) Dispatcher::RequestPages();
		$page_url    = $page.$management;
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
			$setPaginate .= '<nav><ul class="pagination justify-content-center">';
			if ($setLastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $setLastpage; $counter++) {
					if ($counter == $current) {
						$setPaginate.= '<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
					} else {
						$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
					}
				}
			} else if($setLastpage > 5 + ($adjacents * 2)) {
				if ($current < 1 + ($adjacents * 2)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
						} else {
							$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$setLastpage.'">'.$setLastpage.'</a></li>';
				}
				else if($setLastpage - ($adjacents * 2) > $current && $current > ($adjacents * 2)) {
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page=1">1</a></li>';
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page=2">2</a></li>';
					for ($counter = $current - $adjacents; $counter <= $current + $adjacents; $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
						}
						else {
							$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$lpm1.'">'.$lpm1.'</a></li>';
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$setLastpage.'">'.$setLastpage.'</a></li>';
				} else {
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page=1">1</a></li>';
					$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page=2">2</a></li>';
					for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {
						if ($counter == $current) {
							$setPaginate.= '<li class="page-item active"><a class="page-link">'.$counter.'</a></li>';
						} else {
							$setPaginate.= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$counter.'">'.$counter.'</a></li>';
						}
					}
				}
			}

			if ($current < $counter - 1) {
				$setPaginate .= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$next.'"><i class="fa-solid fa-forward"></i></a></li>';
				$setPaginate .= '<li class="page-item"><a class="page-link" href="'.$page_url.'page='.$setLastpage.'"><i class="fa-solid fa-slash"></i></a></li>';
			} else{
				$setPaginate .= '<li class="page-item disabled"><a class="page-link"><i class="fa-solid fa-forward"></i></a></li>';
				$setPaginate .= '<li class="page-item disabled"><a class="page-link"><i class="fa-solid fa-slash"></i></a></li>';
			}
			//$setPaginate .= '<li class="">Page '.$current.' '. OF . ' '.$setLastpage.'</li>';
			//$setPaginate .= '</ul></nav>'.PHP_EOL;
		}

		return $setPaginate;
	}
	#########################################
	# Retourn un message d'information de type
	# error - success - warning - infos
	#########################################
	function error ($title, $msg, $type)
	{
		ob_start();
		Notification::$type($msg, $title);
		$this->page = ob_get_contents();
		ob_end_clean();
	}
}