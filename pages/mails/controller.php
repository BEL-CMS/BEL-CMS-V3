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
	#########################################
	# Vérifie s'il y a un nouveau message
	#########################################
	public function testMsg ()
	{
		$this->typeMime = 'application/json';
		if (User::isLogged() === true) {
			echo json_encode(array('data' => $this->models->testNewMSG()));
		} else {
			echo json_encode(array('data'=> false));
		}
	}
	#########################################
	# Nouveau message
	#########################################
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
	#########################################
	# lecture des messages
	#########################################
	public function read ()
	{
		if (User::isLogged() === true) {
			// Récupère les messages qui ne sont pas archivés
			$data['inbox'] = $this->models->getMessagesRead($this->data[2]);
			if ($data['inbox'] === false) {
				$data['inbox'] = array();
				$this->redirect('Mails', 3);
			} else {
				// Transmet les données à la page receives
				$this->set($data);
				$this->render('receives');	
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
	#########################################
	# Réponse a un message
	#########################################
	public function reply ()
	{
		if (User::isLogged() === true) {
			$data['mail_id'] = $this->data[2];
			$data['test'] = $this->models->getTestReply($this->data[2]);
			$this->set($data);
			$this->render('reply');
			$this->redirect('Mails', 3);
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Envoie la réponse en base de donnée
	#########################################
	public function sendReply ()
	{
		if (User::isLogged() === true) {
			$return = $this->models->sendReply($this->data);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
			$this->redirect('Mails', 3);
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# lecture des messages qui sont archivé
	#########################################
	public function archive()
	{
		if (User::isLogged() === true) {
			$data['inbox'] = $this->models->getMessages(true);
			$this->set($data);
			$this->render('archive');	
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Récupere les messages supprimé.
	# Si les deux participant ont clos le sujet,
	# la conversation sera effacée de la base de donnée
	#########################################
	public function close ()
	{
		if (User::isLogged() === true) {
			$data['inbox'] = $this->models->getMessagesClose();
			$this->set($data);
			$this->render('close');	
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Met le message dans la boîte de suppression
	#########################################
	public function remove ()
	{
		if (User::isLogged() === true) {
			$return = $this->models->sendRemove($this->data[2]);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
			$this->redirect('Mails', 3);
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Envoie le message dans la boîte d'archive
	#########################################
	public function sendArchive()
	{
		if (User::isLogged() === true) {
			$return = $this->models->sendArchive($this->data[2]);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
			$this->redirect('Mails', 3);

		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Récupérer les messages archives
	#########################################
	public function readArchive ()
	{
		if (User::isLogged() === true) {
			$data['inbox'] = $this->models->readArchive($this->data[2]);
			$this->set($data);
			$this->render('readarchive');	
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Vous ajouté à la liste d'envoi e-mail
	#########################################
	public function subcribe ()
	{
		if (User::isLogged() === true) {
			// Redirection vers le login, après 3 secondes
			$this->redirect('Mails/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('success', constant('SUBCRIBE_OK'), constant('INFO'), true);
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Vous retirez de la liste d'envoi e-mail
	#########################################
	public function unsubcribe ()
	{
		if (User::isLogged() === true) {
			// Redirection vers le login, après 3 secondes
			$this->redirect('Mails/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('success', constant('SUBCRIBE_REMOVE'), constant('INFO'), true);
		} else {
			// Redirection vers le login, après 3 secondes
			$this->redirect('User/login&echo', 3);
			// Initialise une erreur / message information
			$this->error = true;
			// message information (alert error infos success warning), le message, le titre, full page ou non (true-false)
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
}