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

use BelCMS\Core\Captcha;
use BELCMS\Pages\Pages;
use BelCMS\Requires\Common;
use BELCMS\User\User as UserInfos;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class User extends Pages
{
	var $useModels = 'User';

	function __construct()
	{
		parent::__construct();
		if (UserInfos::isLogged() === true) {
			$dir = constant('DIR_UPLOADS_USER').$_SESSION['USER']->user->hash_key.'/';
			if (!is_dir($dir)) {
				mkdir($dir, 0774, true);
			}
			$fopen  = fopen($dir.'/index.html', 'a+');
			fclose($fopen);
		}
	}
	#########################################
	# Index de la page utilisateur
	#########################################
	public function index ()
	{
		if (UserInfos::isLogged() === true) {
			$_SESSION['USER'] = UserInfos::getInfosUserAll($_SESSION['USER']->user->hash_key);
			$d['current'] ='user';
			$d['user']    = $_SESSION['USER'];
			$this->set($d);
			$this->render('index');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# copy index
	#########################################
	public function profil ()
	{
		self::index();
	}
	#########################################
	# Sessions
	#########################################
	public function sessions ()
	{
		if (UserInfos::isLogged() === true) {
			$data['user'] = $this->models->sessions();
			$this->set($data);
			$this->render('sessions');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);	
		}
	}
	#########################################
	# Page Avatar
	#########################################
	public function avatar ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $_SESSION['USER'];
			$d['current'] ='avatar';
			$this->set($d);
			$this->render('avatar');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Affiche la pae general de user
	#########################################
	public function generals ()
	{
		if (UserInfos::isLogged() === true) {
			$this->render('generals');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Enregistre les parametres generals
	#########################################
	public function sendGen ()
	{
		$return = $this->models->sendGen($_POST);
		$this->redirect('User/Generals', 3);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
	}
	#########################################
	# affiche la page des notification
	#########################################
	public function Notification ()
	{
		if (UserInfos::isLogged() === true) {
			$data['data'] = $this->models->getNotif();
			$this->set($data);
			$this->render('notification');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}

	public function groups ()
	{
		if (UserInfos::isLogged() === true) {
			$groups = $_SESSION['USER'];
			$grp['groups'] = $groups->groups->all_groups;
			$this->set($grp);
			$this->render('groups');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Page Secure
	#########################################
	public function security ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $_SESSION['USER'];
			$d['current'] ='security';
			$this->set($d);
			$this->render('security');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Page Safety
	#########################################
	public function safety ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $_SESSION['USER'];
			$d['current'] ='safety';
			$this->set($d);
			$this->render('safety');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Page Avatar
	#########################################
	public function social ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $_SESSION['USER'];
			$d['current'] ='social';
			$this->set($d);
			$this->render('social');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	#########################################
	# Page login
	#########################################
	public function login ()
	{
		if (UserInfos::isLogged() === false) {
			$this->render('login');
		} else {
			$d = array();
			$d['user'] = $_SESSION['USER'];
			$this->set($d);
			$this->render('index');
		}
	}
	#########################################
	# S'enregistree
	#########################################	
	public function register ()
	{
		if (UserInfos::isLogged() === true) {
			$valid  = empty($_SESSION['CONFIG_CMS']['VALIDATION'] and $_SESSION['CONFIG_CMS']['VALIDATION'] == 'mail') ? false : true;
			if ($valid == true) {
				$this->redirect('user', 0);
			} else {
				$testUser = $this->models->testUser;
				if ($testUser === true) {
					$this->redirect('user', 0);
				} else {
					$return['captcha'] = Captcha::createCaptcha();
					$this->set($return);
					$this->data = (bool) true;
					$this->render('register');					
				}
			}
		} else {
			$return['captcha'] = Captcha::createCaptcha();
			$this->set($return);
			$this->data = (bool) true;
			$this->render('register');
		}
	}
	#########################################
	# Deconnexion
	#########################################
	public function logout ()
	{
		$return = UserInfos::logout();
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
		$this->redirect('User', 3);
	}
	public function lostpassword ()
	{
		if (UserInfos::isLogged() === false) {
			$this->data = (bool) true;
			$this->render('lostpassword');
		}
	}
	public function sendLostPassword ()
	{
		$return = $this->models->checkToken($_POST);
		if (!isset($return['pass'])) {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('PASSWORD'), false);
			$this->redirect('User/LostPassword?echo', 3);
		} else {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('PASSWORD'), false);
		}
	}

	public function SendRegister ()
	{
		if (Captcha::verifCaptcha($_POST['query_register']) === false) {
			$this->error = true;
			$this->errorInfos = array('error', constant('CODE_CAPTCHA_ERROR'), constant('REGISTRATION'), false);
			return false;
		}

		$return = $this->models->sendRegistration($this->data);

		if ($return['type'] == 'error' or $return['type'] == 'warning') {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('REGISTRATION'), false);
			$this->redirect('User/register&echo', 3);
		} else {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('LOGIN'), false);
			$this->redirect('User', 3);
		}
	}
	public function sendLogin ()
	{
		if (empty($this->data)) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('EMPTY_DATA'), constant('MANAGEMENTS'), false);
		} else {
			$return = UserInfos::login($this->data['username'], $this->data['password']);
			$this->error = true;
			if ($return['type'] == 'error') {
				$this->errorInfos = array('error', $return['msg'], $return['type'], false);
				$this->redirect('User/Login&echo', 3);
			} else if ($return['type'] == 'warning') {
				$this->errorInfos = array('warning', $return['msg'], $return['type'], false);
				$this->redirect('User/Login&echo', 3);
			} else if ($return['type'] == 'success') {
				$this->errorInfos = array('success', $return['msg'], $return['type'], false);
				$this->redirect('User', 3);
			} else {
				$this->errorInfos = array('infos', constant('UNKNOWN_ERROR'), constant('INFO'), false);
				$this->redirect('User/login&echo', 3);
			}

		}
	}

	private function mailpassword ()
	{
		if (empty($this->data)) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('ERROR_NO_DATA'), constant('ERROR_NO_ID'), false);
			$this->redirect('user/login', 3);
		} else {
			unset($this->data['send']);
			$return = $this->models->sendEditPassword($this->data);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('EDIT_MAIL_PASS'), false);
			$this->redirect('User', 2);
		}
	}
	public function GetUser($usermail = null, $userpass = null, $api_key = null)
	{
		if ($usermail !== null && $userpass !== null && $api_key) {
			if (defined('API_KEY')) {
				if (!empty($api_key) && $api_key == constant('API_KEY')) {
					$this->typeMime = 'application/json';
					echo $this->models->GetInfosUser($usermail, $userpass);
				}
			} else {
				echo json_encode(constant('ERROR_API_KEY'));
			}
		} else {
			echo null;
		}
	}
	#########################################
	# Enregistre le compte utilisateur
	#########################################
	public function sendaccount ()
	{
		$return = $this->models->sendAccount($this->data);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], $return['title'], false);
		$this->redirect('User', 2);
	}
	#########################################
	# Enregistre le compte securiter (mdp)
	#########################################
	public function sendsecurity ()
	{
		$return = $this->models->sendSecurity($this->data);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], $return['title'], false);
		$this->redirect('User', 2);
	}
	#########################################
	# Selectionne l'avatar ou le supprime
	#########################################
	public function addAvatar ()
	{
		$return = $this->models->avatarSubmit($_GET);
	}
	#########################################
	# recupere le background
	#########################################
	public function background ()
	{
		$this->render('background');
	}
	#########################################
	# Enregistre le nouveau background
	#########################################
	public function NewBg ()
	{
		$return = $this->models->bgSubmit($_FILES);
		$this->errorInfos = array($return['type'], $return['msg'], $return['ext'], false);
		$this->redirect('User', 2);
	}
	#########################################
	# Enregistre le nouveau avatar (upload)
	#########################################
	public function newavatar ()
	{
		$return = $this->models->sendNewAvatar();
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], $return['ext'], false);
		$this->redirect('User', 2);
	}
	#########################################
	# Change les liens social
	#########################################
	public function submitsocial ()
	{
		$return = $this->models->sendSubmitSocial($this->data);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], $return['ext'], false);
		$this->redirect('User', 2);
	}
	#########################################
	# Page Games
	#########################################
	public function games ()
	{
		if (UserInfos::isLogged() === true) {
			$d['current'] ='games';
			$d['games'] = $this->models->getGames();
			$this->set($d);
			$this->render('games');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
	}
	public function sendGames ()
	{
		if(empty($_POST)) {
			$return = $this->models->sendGames(null);
		} else {
			$return = $this->models->sendGames($_POST['game']);
		}
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], $return['ext'], false);
		$this->redirect('User/Games', 3);
	}
}
