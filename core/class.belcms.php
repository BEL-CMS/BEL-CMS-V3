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

namespace BelCMS\Core;
use BelCMS\Core\Debug as debug;
use BelCMS\Core\Visitors;
use BelCMS\PDO\BDD;
use BelCMS\User\User;
use BelCMS\Core\Dispatcher;
use BelCMS\Templates\Templates as Template;
use BelCMS\Core\GetHost;
use BelCMS\Core\Notification;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Principale du CMS
################################################
final class BelCMS
{
	var 		$link;

	public		$typeMime;

	public 		$page,
	            $view,
				$widgets = array(),
				$template;

	public		$langs = 'fr';

	public		$host,
				$tags,
				$css,
				$javaScript,
				$fullwide;

	public function __construct ()
	{
		$this->link = Dispatcher::page($_SESSION['CONFIG_CMS']['CMS_DEFAULT_PAGE']);
		if ($this->link != 'Mails') {
			new Visitors;
		}
		$this->widgets  = self::getWidgets ();
		$this->typeMime = self::typeMime ();
		$this->page     = $this->page();
		$this->host     = GetHost::curPageURL();
		$this->template = self::template ();
	}
	##################################################
	# Récupère la page uniquement sans le template
	# contenue brut texte mis dans la variable $this->page
	##################################################
	private function page ()
	{
		ob_start();
		$this->link	  = Dispatcher::page($_SESSION['CONFIG_CMS']['CMS_DEFAULT_PAGE']);
		$require	  = ucfirst($this->link);
		$view		  = Dispatcher::view();
		$landing      = Dispatcher::link();
		new User;
		$unavailable = new \Maintenance;
		if ($unavailable->status() == 'close') {
			if (User::isLogged()) {
				if (in_array(1, $_SESSION['USER']->groups->all_groups)) {
					Notification::alert($unavailable->description(), constant('WARNING'), false);
				}
			} else {
				if (empty($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'])) {
					$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'] = constant('NO_NAME');
				}
				require ROOT.DS.'maintenance'.DS.'tpl'.DS.'index.php';
				die();
			}
		}
		$dirLanding = ROOT.DS.'templates'.DS.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'landing.php';
		if ($_SESSION['CONFIG_CMS']['LANDING'] == '1' && is_file($dirLanding) && count($landing) == 0) {
			require_once $dirLanding;
			die();
		} else {
			$dir = constant('DIR_PAGES').strtolower($this->link).DS.'controller.php';
			if (is_file($dir)) {
				require_once $dir;
				$require = "Belcms\Pages\Controller\\".$require;
				$newPage = new $require;
				if (method_exists($newPage, $view)) {
					call_user_func_array(array($newPage,$view),Dispatcher::link());
					if ($newPage->typeMime == 'application/json') {
						die();
					}
					$error = $newPage->error;
					if ($error === false AND empty($newPage->page)) {
						Notification::alert('Page '.$this->link.' vide', 'Page', false);
					} else {
						echo $newPage->page;
						self::statsPages();
					}
					if ($newPage->error === true) {
						$error_type = $newPage->errorInfos[0];
						$error_text = $newPage->errorInfos[1];
						$error_name = $newPage->errorInfos[2];
						$error_full = $newPage->errorInfos[3];
						self::error($error_type, $error_text, $error_name, $error_full);
					}
					$content = ob_get_contents();
				} else {
					Notification::alert(constant('ERROR_LOADING_INSTANCE'), constant('WARNING'), true);
					$content = ob_get_contents();
				}
			} else {
				Common::Redirect('error/404.html');
				$content = ob_get_contents();
				echo $content;
			}
		}

		if (ob_get_length() != 0) {
			ob_end_clean();
		}

		return $content;
	}
	##################################################
	# Récupère la widgets mis dans la variable.
	# $this->widgets[x][nom] = array();
	##################################################
	private function getWidgets ()
	{
		$return  = array();
		$listWidgetsActive = self::getWidgetsActive ();
		foreach ($listWidgetsActive as $value) {
			$dir = constant('DIR_WIDGETS').strtolower($value->name).DS.'controller.php';
			if (is_file($dir)) {
				require $dir;
				$require = "Belcms\Widgets\Controller\\".ucfirst($value->name)."\\".ucfirst($value->name);
				$widgets = new $require();
				if (method_exists($widgets, 'index')) {
					$widgets->index($value);
					$view = $widgets->view;
				}
			} else {
				return false;
			}
			switch ($value->pos) {
				case 'top':
					$return['top'][$value->name] = array('view' => $view);
				break;
				case 'right':
					$return['right'][$value->name] = array('view' => $view);
				break;
				case 'bottom':
					$return['bottom'][$value->name] = array('view' => $view);
				break;
				case 'left':
					$return['left'][$value->name] = array('view' => $view);
				break;
			}
		}
		return $return;
	}
	##################################################
	# Récupère la widgets actif
	# ne récupère pas les widgets dont les groupes
	# ne correspond pas au votre (sauf 0 ou admin nv1)
	##################################################
	private function getWidgetsActive ()
	{
		$return = array();
		$a      = array();
		$b      = array();

		$sql = new BDD;
		$sql->table('TABLE_WIDGETS');
		$sql->where(array(
			'name'  => 'active',
			'value' => 1
		));
		$sql->orderby(array('name' => 'orderby', 'value' => 'ASC'));
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $k => $v) {
				if (empty($v->page)) {
					$b[$k] = $v;
				} else {
					$a = explode('|', $v->pages);
					if (empty($v->page)) {
						if (!in_array($this->link, $a)) {
							$b[$k] = $v;
						}
					}
				}
			}
			foreach ($b as $k => $v) {
				if (isset($_SESSION['USER']) and !empty($_SESSION['USER'])) {
					if ($v->groups_access == 0 or in_array(1, $_SESSION['USER']->groups->all_groups)) {
						$return[$k] = $v;
					} else {
						$a = explode('|', $v->groups_access);
						if (in_array($_SESSION['USER']->groups->all_groups, $a)) {
							$return[$k] = $v;
						}
					}
				} else {
					if ($v->groups_access == 0) {
						$return[$k] = $v;
					}
				}
			}
		}
		return $return;	
	}
	##################################################
	# Récupérer le template et intégrer toute
	# les variable $this (c'est-a-dire) 
	# page / widgets / lien / user
	##################################################
	private function template ()
	{
		ob_start();
		new Template($this);
		$content = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}
	##################################################
	# Récupère le typeMime passé text ou html ou json
	# <!> Sûrement a effacé dans le futur vu qu'il
	# est gerer par le lien ex:
	# https://lien/page/id/?json = encode en json
	# https://lien/page/id/?text = sans rien juste la page en pur text
	# https://lien/page/id/?echo = la page complete sans le template
	##################################################
	public function typeMime ()
	{
		$typeMime = Dispatcher::header();
		return $typeMime;
	}
	##################################################
	# Récupère le language utilisé:
	# <!> pour l'instant, il n'a que le FR, mais facilement
	# possible de mettre toutes les langues proposées,
	# il suffit de reglé dans l'admin ENG pour integrer:
	# dans tout les dossier lang.eng.php etc...
	##################################################
	public function langs ()
	{
		if (defined('LANGS')) {
			require_once constant('DIR_LANGS').'langs'.DS.constant('LANGS').'.php';
			$this->langs = constant('LANGS');
		} else {
			if ($this->langs == 'fr') {
				require_once constant('DIR_LANGS').'langs'.DS.$this->langs.'.php';
			}
		}
	}
	##################################################
	# Statistique par page, incrémentation.
	##################################################
	private function statsPages ()
	{
		$sql = new BDD;
		$sql->table('TABLE_PAGE_STATS');
		$sql->where(array(
			'name' => 'page',
			'value' => $this->link

		));
		$sql->queryOne();
		if (!empty($sql->data)) {
			$update['nb_view'] = $sql->data->nb_view +1;
			$insert = new BDD;
			$insert->table('TABLE_PAGE_STATS');
			$insert->where(array(
				'name' => 'page',
				'value' => $this->link
			));
			$insert->update($update);
		}
	}
	#########################################
	# Retourn un message d'information de type
	# error - success - warning - infos
	#########################################
	public function error ($type = null, $text = 'inconnu', $title = 'INFO', $full = false)
	{
		if ($type == null) {
			$type = constant('INFO');
		}
		ob_start();
		echo Notification::$type($text, $title, $full);
		$return =  ob_get_contents();
		ob_end_clean();
		echo $return;
	}

}