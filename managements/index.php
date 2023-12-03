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

namespace Belcms\Management;

use BelCMS\Core\Dispatcher;
use BelCMS\Core\Interaction;
use BelCMS\Core\Notification;
use BelCMS\Core\Secure;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Managements
{	
	var 	$page,
			$view,
			$link;

	public  $render,
			$data;

	private $controller;

	#########################################
	# redirige l'utilisateur si loguer ou pas
	#########################################
	function __construct()
	{
		$this->link = Dispatcher::link();
		$this->page = Dispatcher::page();
		$this->view = Dispatcher::view();
		
		self::getLangs();

		if (isset($_SESSION['USER']->user->hash_key) && strlen($_SESSION['USER']->user->hash_key) == 32) {
			if (isset($_SESSION['LOGIN_MANAGEMENT']) and $_SESSION['LOGIN_MANAGEMENT'] === true) {
				require_once constant('DIR_ADMIN').'intern'.DS.'adminpages.php';
				self::base();
			} else {
				self::login();
			}
		} else {
			Common::Redirect('User/Login');
		}
	}
	#########################################
	# Page principal avec le menu
	#########################################
	public function base ()
	{
		$render        = self::getLinksPages ();
		$menuPage      = self::menuPage ();
		$menuWidget    = self::menuWidget ();
		$menuGaming    = self::menuGaming ();
		$menuParameter = self::menuParameter ();
		$menuTemplates = self::menuTemplates ();
		$menuUsers     = self::menuUsers ();
		$menuExtras    = self::menuExtras ();
		require_once constant('DIR_ADMIN').'intern'.DS.'layout.php';
	}
	#########################################
	# Gestion des pages & widgets + le dashboard
	#########################################
	private function getLinksPages ()
	{
		$render = null;

		ob_start();

		$groups = $_SESSION['USER']->groups->all_groups;

		require_once constant('DIR_ADMIN').'intern'.DS.'adminpages.php';
		#####################################
		# Accessible Uniquement aux administrateurs de 1er niveau
		#####################################
		if (isset($_REQUEST['option']) and $_REQUEST['option'] == 'parameter') {
			if (
				Dispatcher::view() == strtolower('parameter') or 
				Dispatcher::view() == strtolower('sendparameter') or 
				Dispatcher::page() == strtolower('parameter') or 
				$_REQUEST['option'] == 'parameter' or
				$_REQUEST['option'] == 'extras')
			{
				if (!in_array(1, $groups)) {
					Notification::error(constant('NO_ACCESS_GROUP_PAGE'), 'Page');
					$render = ob_get_contents();
					if (ob_get_length() != 0) {
						ob_end_clean();
					}
					$this->page = defined(strtoupper($this->page)) ? constant(strtoupper($this->page)) : $this->page;
					$Interaction = New Interaction;
					$Interaction->user($_SESSION['USER']->user->hash_key);
					$Interaction->title('Accès non autorisé');
					$Interaction->type('error');
					$Interaction->text('Accès non autorisé de '.$_SESSION['USER']->user->username.' à la page '.$this->page.' : paramètre');
					$Interaction->insert();
					return $render;
				}
			}
		}
		#####################################
		# End
		#####################################
		$this->page = strtolower($this->page);
		# requete page
		if (isset($_REQUEST['option']) and !empty($_REQUEST['option'])) {
			switch ($_REQUEST['option']) {
				case 'pages':
					$requestPage = self::request('pages', $this->page);
				break;

				case 'templates':
					$requestPage = self::request('templates', $this->page);
				break;

				case 'users':
					$requestPage = self::request('users', $this->page);
				break;

				case 'widgets':
					$requestPage = self::request('widgets', $this->page);
				break;

				case 'gaming':
					$requestPage = self::request('gaming', $this->page);
				break;

				case 'parameter':
					$requestPage = self::request('parameter', $this->page);
				break;

				case 'extras':
					$requestPage = self::request('extras', $this->page);
				break;

				default:
					$requestPage = null;
					include constant('DIR_ADMIN').'intern'.DS.'dashboard.php';
				break;
			}
			echo $requestPage;
		} else {
			include constant('DIR_ADMIN').'intern'.DS.'dashboard.php';
		}
		#####################################
		# end requete page
		#####################################
		# Mise en mémoire tempon
		#####################################
		$render = ob_get_contents();
		#####################################
		# reset le tempon
		#####################################
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		#####################################
		# Retourne le rendu de la page
		#####################################
		return $render;
	}
	#########################################
	# Requete des pages = menu
	#########################################
	private function request ($request, $page)
	{
		$scan  = Common::ScanDirectory(constant('DIR_ADMIN').$request);
		if (in_array($page, $scan)) {
			if (self::getAccessPage($page) === false) {
			?>
				<div id="page-content">
			<?php
				Notification::error(constant('NO_ACCESS_GROUP_PAGE'), 'Page');
			?>
				</div>
			<?php
				$page = defined(strtoupper($page)) ? constant(strtoupper($page)) : $page;
				$Interaction = New Interaction;
				$Interaction->user($_SESSION['USER']->user->hash_key);
				$Interaction->title(constant('UNAUTHORIZED_ACCESS'));
				$Interaction->type('error');
				$Interaction->text(constant('UNAUTHORIZED_ACCESS').' : '.$_SESSION['USER']->user->hash_key.' '.constant('ONE_PAGE').' '.$page.' : '.constant('SETTING'));
				$Interaction->insert();
			} else {
				$require = constant('DIR_ADMIN').$request.DS.$page.DS.'controller.php';
				if(!is_file($require)) {
					Notification::error(constant('ACCESS_TO_CONTROLLER_IMPOSSIBLE').'<br> '.$require, 'Page', true);
					die();
				}
				require_once $require;
				$this->controller = $this->page;
				$this->controller = new $this->controller;
				if ($this->controller->active === true) {
					if (method_exists($this->controller, $this->view)) {
						call_user_func_array(array($this->controller,$this->view),$this->link);
					} else {
					?>
					<div id="page-content">
					<?php
						Notification::error(constant('THE_REQUESTED_SUBPAGE').'<strong>'.$this->view.'</strong> '.constant('IS_NOT_AVAILABLE_ON_THE_PAGE').' <strong>'.$page.'</strong>', constant('FILE'));
					?>
					</div>
					<?php
					}
					echo $this->controller->render;
				}
			}
		} else {
			Notification::error(constant('UNKNOWN_PAGE'), 'Page');
		}
	}
	#########################################
	# Page Login
	#########################################
	private function login ()
	{
		if (isset($_REQUEST['umal']) && isset($_REQUEST['passwrd'])) {
			if (!empty($_REQUEST['umal']) && !empty($_REQUEST['passwrd'])) {

				if (Secure::isMail($_REQUEST['umal']) === false) {
					$return['ajax'] = constant('PLEASE_ENTER_YOUR_MAIL');
					echo json_encode($return);
					return;
				}

				$return = array();

				$sql = New BDD();
				$sql->table('TABLE_USERS');
				$sql->where(array('name' => 'mail', 'value' => $_REQUEST['umal']));
				$sql->queryOne();
				$data = $sql->data;

				if (password_verify($_REQUEST['passwrd'], $data->password)) {
					if ($_SESSION['USER']->user->hash_key == $data->hash_key) {
						$Interaction = New Interaction;
						$Interaction->user($_SESSION['USER']->user->hash_key);
						$Interaction->type('success');
						$Interaction->title(constant('AUTHORIZED_ACCESS'));
						$Interaction->text(constant('LOGGED_IN_TO_ADMIN'));
						$Interaction->insert();
						$_SESSION['LOGIN_MANAGEMENT'] = true;
						$return['ajax'] = constant('LOGIN_IN_PROGRESS');
					} else {
						$Interaction = New Interaction;
						$Interaction->user($_SESSION['USER']->user->hash_key);
						$Interaction->type('error');
						$Interaction->title(constant('UNAUTHORIZED_ACCESS'));
						$Interaction->text(constant('TRY_TO_CONNECT_WHIT_ANOTHER_HASHKEY'));
						$Interaction->insert();
						$return['ajax'] = constant('HASHKEY_DOES_NOT_MATCH_YOURS');
					}
				} else {
					$Interaction = New Interaction;
					$Interaction->user($_SESSION['USER']->user->hash_key);
					$Interaction->type('error');
					$Interaction->title(constant('UNAUTHORIZED_ACCESS'));
					$Interaction->text(constant('ATTEMPTED_ACCESS_WHIT_WRONG_PASS'));
					$Interaction->insert();
					$return['ajax'] = constant('THE_PASS_IS_NOT_CORRECT');
				}

				echo json_encode($return);
			}
		} else {
			include constant('DIR_ADMIN').'intern/login.php';
		}
	}
	#########################################
	# Menu des pages
	#########################################
	private function menuPage ()
	{
		$pages  = self::getPages ();
		$return = array();

		foreach ($pages as $k => $v) {
			$return['/'.$v.'?management&option=pages'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu des Widgets
	#########################################
	private function menuWidget ()
	{
		$widgets  = self::getWidgets ();
		$return   = array();

		foreach ($widgets as $k => $v) {
			$return['/'.$v.'?management&option=widgets'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu des Widgets
	#########################################
	private function menuTemplates ()
	{
		$templates = self::getTemplates ();
		$return    = array();

		foreach ($templates as $k => $v) {
			$return['/'.$v.'?management&option=templates'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu Utilisateurs
	#########################################
	private function menuUsers ()
	{
		$users  = self::getUsers ();
		$return = array();

		foreach ($users as $k => $v) {
			$return['/'.$v.'?management&option=users'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu gaming
	#########################################
	private function menuGaming ()
	{
		$gaming  = self::getGaming ();
		$return  = array();

		foreach ($gaming as $k => $v) {
			$return['/'.$v.'?management&option=gaming'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu parameter
	#########################################
	private function menuParameter ()
	{
		$parameter  = self::getParameter ();
		$return     = array();

		foreach ($parameter as $k => $v) {
			$return['/'.$v.'?management&option=parameter'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Menu Extras
	#########################################
	private function menuExtras ()
	{
		$parameter  = self::getExtras ();
		$return     = array();

		foreach ($parameter as $k => $v) {
			$return['/'.$v.'?management&option=extras'] = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
		}
		return $return;
	}
	#########################################
	# Scan le dossier des pages
	#########################################
	private function getPages ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'pages', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier des widgets
	#########################################
	private function getWidgets ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'widgets', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier d'utilisateurs
	#########################################
	private function getUsers ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'users', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier du templates
	#########################################
	private function getTemplates ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'templates', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier gaming
	#########################################
	private function getGaming ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'gaming', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier parameter
	#########################################
	private function getParameter ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'parameter', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Scan le dossier des pages
	#########################################
	private function getExtras ()
	{
		$scan = Common::ScanDirectory(constant('DIR_ADMIN').'extras', true);
		asort($scan);
		return $scan;
	}
	#########################################
	# Autorisation des pages
	#########################################
	private function security ()
	{
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->where(array('name' => 'email', 'value' => $_REQUEST['umal']));
		$sql->queryOne();
		$data = $sql->data;
	}
	#########################################
	# Accès au page admin via les groupes
	#########################################
	public function getAccessPage ($page = null)
	{
		if ($page === null) {
			return false;
		} else {
			$bdd = self::accessSqlPages($page);
			if (isset($bdd[$page]->access_admin)) {
				if (in_array(0, $bdd[$page]->access_admin)) {
					return true;
				} else {
					foreach ($bdd[$page]->access_admin as $k => $v) {
						$_SESSION['USER'] = User::getInfosUserAll($_SESSION['USER']->user->hash_key);
						$access = $_SESSION['USER']->groups->all_groups;
						if (isset($_SESSION['USER']->user->hash_key) && strlen($_SESSION['USER']->user->hash_key) == 32) {
							if (in_array(1, $access)) {
								return true;
							}
							if (in_array($v, $access)) {
								return true;
							} else {
								return false;
							}
						}
					}
				}
			} else {
				return true;
			}
		}
	}
	#########################################
	# BDD Complet de la page demandé
	#########################################
	public function accessSqlPages ($name)
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_CONFIG');
		$sql->where(array('name' => 'name', 'value' => $name));
		$sql->queryAll();
		if (empty($sql->data)) {
			$return = false;
		} else {
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$v->name] = $v;
				$return[$v->name]->access_groups = explode('|', $return[$v->name]->access_groups);
				$return[$v->name]->access_admin  = explode('|', $return[$v->name]->access_admin);
				if (!empty($v->config)) {
					$return[$v->name]->config = Common::transformOpt($return[$v->name]->config);
				} else {
					unset($return[$v->name]->config);
				}
				unset($return[$k], $return[$v->name]->name);
			}
		}
		return $return;
	}
	#########################################
	# récupère tout les fichiers de lang et les inclus
	#########################################
	private function getLangs ()
	{
		$scan = Common::ScanFiles(constant('DIR_ADMIN').'langs');
		foreach ($scan as $k => $v) {
			require_once constant('DIR_ADMIN').'langs'.DS.$v;
		}
	}
}