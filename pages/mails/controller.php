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

use BelCMS\Core\Interaction;
use BelCMS\Core\Notification;
use BELCMS\Pages\Controller\User as ControllerUser;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;
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
		#########################################
		parent::__construct();
		#########################################
		$dir = constant('DIR_UPLOADS_MAILS');
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
			$fopen  = fopen($dir.'/index.html', 'a+');
			fclose($fopen);
		}
		#########################################
	}
	#########################################
	# Premiere Page avec tout vos message
	#########################################
	public function index ()
	{
		#########################################
		$get['data'] = $this->models->getAllMsg();
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if ($value->archive == 1) {
				unset($get['data'][$key]);
			}
			if ($value->close == 1) {
				unset($get['data'][$key]);
			}
		}
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if (isset($value->author)) {
				$infosUser   = User::getInfosUserAll($value->author_send);
				$user        = $infosUser->user->username;
				$avatar      = $infosUser->profils->avatar;
				$get['data'][$key]->username = $user;
				$get['data'][$key]->avatar = $avatar;
			} else {
				constant('MEMBER_DELETE');
			}
			#########################################
			$message = Common::decrypt($value->msg->message, $value->mail_id);
			$get['data'][$key]->message = $message;
			#########################################
			$get['data'][$key]->time_msg = Common::TransformDate($value->msg->time_msg, 'MEDIUM', 'MEDIUM');
			#########################################
		}
		#########################################
		$this->set($get);
		$this->render('index');
		#########################################
	}

	public function ReadMsg ()
	{
		$id = (is_string($this->data['2'])) ? $this->data['2'] : 0;
		#########################################
		$data['mails'] = $this->models->getAllMailfromID($id);
		#########################################
		foreach ($data['mails'] as $k => $v) {
			$status = $this->models->getStatus($id);
			$data['mails'][$k]->time_msg = Common::TransformDate($v->time_msg, 'MEDIUM', 'MEDIUM');
			$data['mails'][$k]->message  = Common::decrypt($v->message, $v->mail_id);
			$data['mails'][$k]->status   = $status;
		}
		#########################################
		$data['type'] = 'read';
		#########################################
		$this->set($data);
		$this->render('readmsg');
		#########################################
	}
	#########################################
	# Simpole alis
	#########################################
	public function GetMails ()
	{
		self::index();
	}
	#########################################
	# Page de création d'un
	# nouveau message
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
	# Envoie le message
	#########################################
	public function sendNew ()
	{
		// Varibla passé en POST
		$data['author']  = $this->models->getHashKeyUser($_POST['author']);
		$data['subject'] = Common::VarSecure($_POST['subject'], null);
		$data['message'] = Common::VarSecure($_POST['message'], 'html');
		// envoie en base de donnée
		$return = $this->models->sendNew ($data);
		// initialise la réusite du message en BDD
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
		// Redirection à la boite mails au bout de 3s
		$this->redirect('Mails', 3);
	}
	#########################################
	# Réponse à un message
	#########################################
	public function reply ()
	{
		#########################################
		$mail_id = ctype_alnum($_POST['id']) ? $_POST['id'] : false;
		if ($mail_id === false) {
			$this->error = true;
			$this->errorInfos = array('error', constant('ERROR_ID_NOTIFICATION'), constant('ALERT'), true);
		}
		$data['subject'] = Common::VarSecure($_POST['subject'], null);
		$data['message'] = Common::VarSecure($_POST['message'], 'html');
		$data['message'] = Common::crypt($data['message'], $mail_id);
		$data['mail_id'] = $mail_id;
		$data['author']  = Common::hash_key($_POST['author']) ? $_POST['author'] : false;
		#########################################
		if ($data['author'] === false) {
			$this->error = true;
			$this->errorInfos = array('error', constant('ERROR_HASH_KEY_NOTIFICATION'), constant('ALERT'), true);
		}
		#########################################
		$return = $this->models->reply($data);
		#########################################
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
		$this->redirect('Mails', 3);
	}
	#########################################
	# Récupere les utilisateurs avec minimum
	# 3 lettres
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
	# Récupère les message des archives
	#########################################
	public function Archive ()
	{
		#########################################
		$get['data'] = $this->models->getAllMsg();
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if ($value->archive == 0) {
				unset($get['data'][$key]);
			}
			if ($value->close == 1) {
				unset($get['data'][$key]);
			}
		}
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if (isset($value->author)) {
				$infosUser   = User::getInfosUserAll($value->author_send);
				$user        = $infosUser->user->username;
				$avatar      = $infosUser->profils->avatar;
				$get['data'][$key]->username = $user;
				$get['data'][$key]->avatar = $avatar;
			} else {
				constant('MEMBER_DELETE');
			}
			#########################################
			$message = Common::decrypt($value->msg->message, $value->mail_id);
			$get['data'][$key]->message = $message;
			#########################################
			$get['data'][$key]->time_msg = Common::TransformDate($value->msg->time_msg, 'MEDIUM', 'MEDIUM');
			#########################################
		}
		#########################################
		$get['type'] = 'archive';
		#########################################
		$this->set($get);
		$this->render('archive');
		#########################################
	}
	#########################################
	# Récupère les messages de la corbeille
	#########################################
	public function Trash ()
	{
		#########################################
		$get['data'] = $this->models->getAllMsg();
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if ($value->close != 1) {
				unset($get['data'][$key]);
			}
		}
		#########################################
		foreach ($get['data'] as $key => $value) {
		#########################################
			if (isset($value->author)) {
				$infosUser   = User::getInfosUserAll($value->author_send);
				$user        = $infosUser->user->username;
				$avatar      = $infosUser->profils->avatar;
				$get['data'][$key]->username = $user;
				$get['data'][$key]->avatar = $avatar;
			} else {
				constant('MEMBER_DELETE');
			}
			#########################################
			$message = Common::decrypt($value->msg->message, $value->mail_id);
			$get['data'][$key]->message = $message;
			#########################################
			$get['data'][$key]->time_msg = Common::TransformDate($value->msg->time_msg, 'MEDIUM', 'MEDIUM');
			#########################################
		}
		#########################################
		$get['type'] = 'close';
		#########################################
		$this->set($get);
		$this->render('trash');
		#########################################
	}
	#########################################
	# Place le messaqe en archive
	#########################################
	public function Archiving ()
	{
		$id = ctype_alnum($this->data['2']) ? $this->data['2'] : false;
		#########################################
		$return = $this->models->archiving($id);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
		#########################################
		$this->redirect('Mails', 3);
		#########################################
	}
	#########################################
	# Clos le message, plus possible de répondre
	#########################################
	public function close ()
	{
		$id = ctype_alnum($this->data['2']) ? $this->data['2'] : false;
		#########################################
		$return = $this->models->close($id);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
		#########################################
		$this->redirect('Mails', 3);
		#########################################
	}
	#########################################
	# Place tous les messages dans la corbeille
	#########################################
	public function deleteAll ()
	{
		$return = $this->models->closeall();
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['text'], constant('INFO'), false);
		#########################################
		$this->redirect('Mails', 3);
		#########################################
	}
}
