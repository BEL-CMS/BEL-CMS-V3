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
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Dispatcher
{
	public $link;

    public function __construct()
    {
		if (isset($_GET['params']) AND !empty($_GET['params'])) {
			if (Secure::isString($_GET['params'])) {
				$this->link = explode('/', Secure::isString($_GET['params'], '/'));
			}
		} else {
			$this->link = array();
		}
    }
	#########################################
	# return le lien complet en tableau
	#########################################
	public static function link ()
	{
		$return     = null;
		$dispatcher = new Dispatcher;
		$return     = $dispatcher->link;
		return $return;
	}
	#########################################
	# return le nom de la page.
	#########################################
	public static function page ($page = null)
	{
		$return = null;
		$dispatcher = new Dispatcher;
		if (count($dispatcher->link) != 0 AND isset($dispatcher->link[0])) {
			$return = Common::VarSecure($dispatcher->link[0], null) === false ? '' : $dispatcher->link[0];
		} else {
			$return = Common::VarSecure($page);
		}
		return $return;
	}
	#########################################
	# return le nom de la vu.
	# https://bel-cms.dev/news/=>view<=/nom/id
	#########################################
	public static function view () : string
	{	
		$return = 'index';
		$dispatcher = new Dispatcher;
		if (count($dispatcher->link) != 0 AND isset($dispatcher->link[1]) AND !empty($dispatcher->link[1])) {
			if (Common::VarSecure($dispatcher->link[1], null) === false) {
				$return = 'index';
			} else {
				$return = Common::VarSecure($dispatcher->link[1], null);
			}
		}
		return $return;
	}
	#########################################
	# return le nom :
	# https://bel-cms.dev/news/view/=>nom<=/id
	#########################################
	public static function name ($link) : string
	{
		$return = null;
		$dispatcher = new Dispatcher;
		if (isset($dispatcher->link[2]) AND !empty($dispatcher->link[2])) {
			$return = Secure::isString($dispatcher->link[2]);
		}
		return $return;
	}
	#########################################
	# return l'ID ex: numéro de la :
	# page, numéro de l'article, du downloads...
	# https://bel-cms.dev/news/view/nom/=>id<=
	#########################################
	public static function id () : int
	{
		$return = null;
		$dispatcher = new Dispatcher;
		if (isset($dispatcher->link[3]) AND !empty($dispatcher->link[3])) {
			$return = Secure::isInt($dispatcher->link[3]);
		}
		return $return;
	}
	#########################################
	# return true si c'est une page
	#########################################
	public static function isPage ($pages = null): bool
	{
		$return = false;
		$page   = Dispatcher::page();

		if (!empty($page)) {
			//$page = constant('CMS_DEFAULT_PAGE');
			//debug($page);
		}

		if (!empty($page)) {
			if (Common::ExistsPage($page) === true) {
				$return = (bool) true;
			}
		} else if (Common::ExistsPage($pages) === true) {
			$return = (bool) true;
		}
		return $return;
	}
	#########################################
	# return true si la page doit-être,
	# redirigé vers l'administration.
	######################################### 
	public static function isManagement() : bool
	{
		$return = false;
		$getManagement = array(
			'admin',
			'Administration',
			'Admin',
			'Management',
			'management',
		);
		foreach ($getManagement as $k) {
			if (array_key_exists($k, $_REQUEST)) {
				$return = true;
				break;
			}
		}
		return $return;
	}
	#########################################
	# return si la page doit-être redirigé vers
	# du json return entête : json_encode();
	#########################################
	public static function IsJson () : bool
	{
		$return = false;
		if (isset($_GET['json']) or isset($_GET['jquery'])) {
			$return = true;
		}
		return $return;
	}
	#########################################
	# return la page sans les modules ou
	# extension que du HTML.
	#########################################
	public static function IsEcho () : bool
	{
		$return = false;
		if (isset($_GET['echo'])) {
			$return = true;
		}
		return $return;
	}
	#########################################
	# return le type mime
	# echo (sans tpl), json, echo (avec tpl)
	#########################################
	public static function header () : string
	{
		$page = constant('CMS_DEFAULT_PAGE');
		//debug($page);
		if (isset($_GET['text'])) {
			$return = 'text/plain';
		} else if (isset($_GET['json']) or isset($_GET['jquery'])) {
			$return = 'application/json';
		} else if (Dispatcher::isPage() === true) {
			$return = 'text/html';
		} else {
			$return = 'text/html';
		}
		return $return;
	}
	#########################################
	# return le numero de la page 
	# ex: https://bel-cms.dev/news/le_nom/id?page=1
	#########################################
	public static function RequestPages () : int
	{
		$return = 0;
		if (isset($_GET['page']) AND is_numeric($_GET['page']) ) {
			$return = intval($_GET['page']);
		} else {
			$return = 1;
		}
		return $return;
	}
}