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

namespace BELCMS\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Mails extends Pages
{
	var $useModels = 'Mails';
	#########################################
	# Index de la page Mail
	#########################################
	public function index ()
	{
		// Si l'utilisateur est logué
		if (User::isLogged() === true) {
			// Récupère les messages qui ne sont pas archivés
			$data['inbox'] = $this->models->getMessages();
			// Transmet les données à la page index
			$this->set($data);
			// le nom de la page
			$this->render('index');
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function new ()
	{
		if (User::isLogged() === true) {
			$this->render('new');
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function send ()
	{
		if (User::isLogged() === true) {
			//$crypt = Common::randomString(32);
			//$message = "<p>test</p>";
			//$var = Common::crypt($message, $crypt);
			//debug($crypt, false);
			//debug($var, false);
			//debug(Common::decrypt($var, $crypt));
		}
	}
}