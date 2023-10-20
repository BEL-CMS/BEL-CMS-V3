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
use BelCMS\Config\Config as Config;
use BelCMS\PDO\BDD as BDD;
use BelCMS\User\User as User;
use BelCMS\Core\Dispatcher as Dispatcher;
use BelCMS\Templates\Templates as Template;
use BelCMS\Core\GetHost as GetHost;

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
				$widget,
				$template;

	public		$langs = 'fr';

	public		$host,
				$tags,
				$css,
				$javaScript;

	private 	$user;

	public function __construct ()
	{
		if (isset($_SESSION['USER']['HASH_KEY']) and strlen($_SESSION['USER']['HASH_KEY']) == 32) {
			$this->user     = User::getInfosUserAll($_SESSION['USER']['HASH_KEY']);
			$_SESSION['USER']->$this->user;
		} else {
			$this->user     = (object) array();
		}
		$this->typeMime = self::typeMime ();
		$this->page     = $this->page();
		$this->host     = GetHost::getBaseUrl();
		$this->template = self::template ();
	}

	private function page ()
	{
		ob_start();
		$this->link	  = Dispatcher::page(constant('CMS_DEFAULT_PAGE'));
		$require	  = ucfirst($this->link);
		$view		  = Dispatcher::view();
		if (Dispatcher::isManagement() === true) {
			echo 'Management';
		} else if (Dispatcher::isPage(constant('CMS_DEFAULT_PAGE')) === true) {
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
					}
					if ($error === false AND empty($newPage->page)) {
						Notification::error(constant('ERROR_LOADING_PAGE'), 'Page', true);
					}
					$content = ob_get_contents();
				} else {
					Notification::error(constant('ERROR_LOADING_INSTANCE').$require, 'Page', true);
					$buffer = ob_get_contents();
				}
			} else {
				Notification::error(constant('ERROR_LOADING').$dir, 'Page', true);
				$content = ob_get_contents();
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

	private function management ()
	{
		
	}

	public function typeMime ()
	{
		$typeMime = Dispatcher::header();
		return $typeMime;
	}

	private function config ()
	{

	}

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
	public function error ($type = 'warning', $text = 'inconnu', $title = 'INFO', $full = false)
	{
		ob_start();
		echo Notification::$type($text, $title, $full);
		$return =  ob_get_contents();
		ob_end_clean();
		echo $return;
	}

}