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

use BELCMS\Config\Config as Config;
use BELCMS\PDO\BDD as BDD;
use BELCMS\User\User as User;


if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Principale du CMS
################################################
final class BelCMS
{
	public		$render,
				$typeMime;

	public 		$page,
				$widget,
				$template;

	protected	$langs = 'fr';

	private 	$user;

	public function __construct ()
	{
		$this->user     = self::user ();
		$this->typeMime = self::typeMime ();
	}

	private function content ()
	{
		ob_start();
		if (Dispatcher::isManagement() === true) {
			echo 'Management';
		} else if (Dispatcher::isPage(constant('CMS_DEFAULT_PAGE')) === true) {
			require DIR_PAGES.'index.php';
			$dir = DIR_PAGES.Dispatcher::page(constant('CMS_DEFAULT_PAGE')).DS.'controller.php';
			if (is_file($dir)) {
				require_once $dir;
			} else {
				//Notification::error(constant('name'));
			}
		} else {
			require DIR_ERROR.'404.html';
		}
		$content = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}

	private function template ()
	{
		ob_start();
		new template;
		$content = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}

	private function page ()
	{
		ob_start();
		
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

	public function render ()
	{
		$this->render = self::content();
	}

	private function config ()
	{

	}

	private function user ()
	{
		$user = new User;
	}

	public function langs ()
	{
		if (defined('LANGS')) {
			require_once DIR_LANGS.'langs'.DS.constan('LANGS').'.php';
			$this->langs = constant('LANGS');
		} else {
			if ($this->langs == 'fr') {
				require_once DIR_LANGS.'langs'.DS.$this->langs.'.php';
			}
		}

	}
}