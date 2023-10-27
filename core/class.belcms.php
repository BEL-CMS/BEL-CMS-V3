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

namespace BelCMS\Core;
use BelCMS\Core\Debug as debug;
use BelCMS\Core\Visitors as Visitors;
use BelCMS\PDO\BDD as BDD;
use BelCMS\User\User as User;
use BelCMS\Core\Dispatcher as Dispatcher;
use BelCMS\Widgets\Widgets as Widgets;
use BelCMS\Templates\Templates as Template;
use BelCMS\Core\GetHost as GetHost;
use BelCMS\Core\Notification as Notification;
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
		new Visitors;
		$this->typeMime = self::typeMime ();
		$this->page     = $this->page();
		$this->widgets  = self::getWidgets();
		$this->host     = GetHost::getBaseUrl();
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
		new User;
		if (Dispatcher::isManagement() === true) {
			echo 'Management';
		} else if (Dispatcher::isPage($_SESSION['CONFIG_CMS']['CMS_DEFAULT_PAGE']) === true) {
			$dir = constant('DIR_PAGES').$this->link.DS.'controller.php';
			if (is_file($dir)) {
				require_once $dir;
				$require = "Belcms\Pages\Controller\\".$require;
				$newPage = new $require;
				if (method_exists($newPage, $view)) {
					call_user_func_array(array($newPage,$view),Dispatcher::link());
					echo $newPage->page;
					$error = $newPage->error;
					if ($newPage->error === true) {
						$error_type = $newPage->errorInfos[0];
						$error_text = $newPage->errorInfos[1];
						$error_name = $newPage->errorInfos[2];
						$error_full = $newPage->errorInfos[3];
						self::error($error_type, $error_text, $error_name, $error_full);
					} else {
						self::statsPages();
					}
					if ($error === false AND empty($newPage->page)) {
						Notification::alert(constant('ERROR_LOADING_PAGE'), constant('WARNING'), true);
					}
					$content = ob_get_contents();
				} else {
					Notification::alert(constant('ERROR_LOADING_INSTANCE'), constant('WARNING'), true);
				}
			} else {
				Common::Redirect('error/404.html');
				$content = ob_get_contents();
				echo $content;
			}
		} else {
			require constant('DIR_ERROR').'404.html';
			$content = ob_get_contents();
		}

		if (ob_get_length() != 0) {
			ob_end_clean();
		}

		return $content;
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
	##################################################
	# Récupère la widgets mis dans la variable.
	# $this->widgets[x][nom] = array();
	##################################################
	private function getWidgets ()
	{
		$return  = array();
		$listWidgetsActive = self::getWidgetsActive ();
		foreach ($listWidgetsActive as $key => $value) {
			switch ($value->pos) {
				case 'top':
					$widget = new Widgets ($value, 'top');
					if (!empty($widget)) {
						$return[$value->pos][$value->name] = $widget->getBoxGlobal();
					} else {
						$return[$value->pos][] = '';
					}
				break;
				case 'right':
					$widget = new Widgets ($value, 'right');
					if (!empty($widget)) {
						$return[$value->pos][$value->name] = $widget->getBoxGlobal();
					} else {
						$return[$value->pos][] = '';
					}
				break;
				case 'bottom':
					$widget = new Widgets ($value, 'bottom');
					if (!empty($widget)) {
						$return[$value->pos][$value->name] = $widget->getBoxGlobal();
					} else {
						$return[$value->pos][] = '';
					}
				break;
				case 'left':
					$widget = new Widgets ($value, 'left');
					if (!empty($widget)) {
						$return[$value->pos][$value->name] = $widget->getBoxGlobal();
					} else {
						$return[$value->pos][] = '';
					}				break;
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
				if ($v->groups_access == 0 or in_array(1, $_SESSION['USER']->groups->all_groups)) {
					$return[$k] = $v;
				} else {
					$a = explode('|', $v->groups_access);
					if (in_array($_SESSION['USER']->groups->all_groups, $a)) {
						$return[$k] = $v;
					}
				}
			}
		}
		return $return;	
	}
	##################################################
	# Récupère le template et intefres toute,
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
	# Administration
	##################################################
	private function managements ()
	{
		
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