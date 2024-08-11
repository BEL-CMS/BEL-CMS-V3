<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
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

	function __construct()
	{
		parent::__construct();

		$this->models->deleteAllMsg ();
	}

	public function index ()
	{
		if (User::isLogged()) {
			$mails = $this->models->getMailsAlll();
			foreach ($mails as $key => $value) {
				if ($value->close_send == 1 or $value->archive_send == 1) {
					unset($mails[$key]);
				}
			}
			$result['mails'] = $mails; 
			$this->set($result);
			$this->render('index');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function GetMails ()
	{
		self::index();
	}

	public function MailsSend ()
	{
		if (User::isLogged()) {
			$mails = $this->models->getMailsSend();
			foreach ($mails as $key => $value) {
				if ($value->close_send == 1 or $value->archive_send == 1) {
					unset($mails[$key]);
				}
			}
			$result['mails'] = $mails; 
			$this->set($result);
			$this->render('mailsend');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function getMailsArchive ()
	{
		if (User::isLogged()) {
			$d['mails'] = $this->models->getMailsArchive();
			$this->set($d);
			$this->render('archive');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function trash ()
	{
		if (User::isLogged()) {
			$d['mails'] = $this->models->getMailTrach();
			$this->set($d);
			$this->render('trash');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function new () 
	{
		if (User::isLogged()) {
			$this->render('new');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Envoie le nouveau message
	#########################################
	public function sendNew ()
	{
		if (User::isLogged() === true) {
			$testUser = $this->models->GetUser($this->data['author']);
			if ($testUser === true) {
				$return = $this->models->sendNew($this->data);
				$this->error = true;
				$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
				$this->redirect('Mails', 3);
			} else {
				// Redirection vers le login, après 3 secondes
				$this->redirect('Mails/Mails/New', 3);
				// Initialise une erreur / message information
				$this->error = true;
				// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
				$this->errorInfos = array('warning', constant('USER_FALSE'), constant('INFO'), false);
			}
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	public function deleteAll ()
	{
		// Place tout les messages dans la corbeille
		$this->models->deleteAll();
		// Redirection vers les message, après 3 secondes
		$this->redirect('Mails', 3);
		// Initialise une erreur / message information
		$this->error = true;
		// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
		$this->errorInfos = array('warning', constant('MESSAGE_DELETE_SUCCESS'), constant('INFO'), false);
	}
	#########################################
	# Récupere les utilisateurs avec minimum 3 lettres
	#########################################
	public function getUsers ()
	{
		if (User::isLogged() === true) {
			$this->typeMime = 'application/json';
			$search = $_GET['term'];
			echo json_encode(array('username' => $this->models->getUsers($search)));
		} else {
			echo json_encode(array('username'=> ''));
		}
	}
}