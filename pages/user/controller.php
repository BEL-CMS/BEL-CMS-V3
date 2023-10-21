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
use BELCMS\Pages\Pages;
use BELCMS\User\User as UserInfos;
use BelCMS\PDO\BDD as BDD;
use BELCMS\Core\Notification as Notification;
use BelCMS\Core\Secure as Secure;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class User extends Pages
{
	var $useModels = 'ModelsUser';
	#########################################
	# Index de la page utilisateur
	#########################################
	public function index ()
	{
		if (UserInfos::isLogged() === true) {
			$dir = constant('DIR_USERS').$_SESSION['USER']['HASH_KEY'].'/';
			if (!is_dir($dir)) {
			    mkdir($dir, 0777, true);
			}
			$fopen  = fopen($dir.'/index.html', 'a+');
			$fclose = fclose($fopen);
			$d            = array();
			$d['user']    = $this->models->getDataUser ($_SESSION['USER']['HASH_KEY']);
			$d['gaming']  = $this->models->getGaming ();
			$d['gamers']  = $this->models->getTeamUsers ();
			$d['current'] ='user';
			$this->set($d);
			$this->render('index');
		} else {
			$this->redirect('User/login&echo', 3);
			Notification::warning(constant('LOGIN_REQUIRE'));
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
	# Page Avatar
	#########################################
	public function avatar ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $this->models->getDataUser ($_SESSION['USER']['HASH_KEY']);
			$d['current'] ='avatar';
			$this->set($d);
			$this->render('avatar');
		} else {
			$this->redirect('User/login', 3);
			Notification::warning(constant('LOGIN_REQUIRE'));
		}
	}
	#########################################
	# Page Secure
	#########################################
	public function security ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $this->models->getDataUser ($_SESSION['USER']['HASH_KEY']);
			$d['current'] ='security';
			$this->set($d);
			$this->render('security');
		} else {
			$this->redirect('User/login', 3);
			Notification::warning(constant('LOGIN_REQUIRE'));
		}
	}
	#########################################
	# Page Safety
	#########################################
	public function safety ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $this->models->getDataUser ($_SESSION['USER']['HASH_KEY']);
			$d['current'] ='safety';
			$this->set($d);
			$this->render('safety');
		} else {
			$this->redirect('User/login', 3);
			Notification::warning(constant('LOGIN_REQUIRE'));
		}
	}
	#########################################
	# Page Avatar
	#########################################
	public function social ()
	{
		if (UserInfos::isLogged() === true) {
			$d = array();
			$d['user']    = $this->models->getDataUser ($_SESSION['USER']['HASH_KEY']);
			$d['current'] ='social';
			$this->set($d);
			$this->render('social');
		} else {
			$this->redirect('User/login', 3);
			Notification::warning(constant('LOGIN_REQUIRE'));
		}
	}
	#########################################
	# Page login
	#########################################
	public function login ()
	{
		if (UserInfos::isLogged() === false) {
			self::queryRegister();
			if (isset($_REQUEST['echo'])) {
				$this->render('login');
			} else {
				$this->render('login');
			}
		} else {
			$d = array();
			$d['user'] = $this->models->getDataUser($_SESSION['USER']['HASH_KEY']);
			$this->set($d);
			$this->render('index');
		}
	}
	public function loginSecure ()
	{
		if (isset($_REQUEST['echo'])) {
			if (UserInfos::isLogged() === false) {
				$this->redirect('user/login&echo', 0);
			}
		}
	}
	#########################################
	# S'enregistree
	#########################################	
	public function register ()
	{
		if (UserInfos::isLogged() === false) {
			self::queryRegister();
			$this->data = (bool) true;
			$this->render('register');
		} else {
			$this->redirect('user', 0);
		}
	}
	private function queryRegister () {
		$_SESSION['TMP_QUERY_REGISTER'] = array();
		$_SESSION['TMP_QUERY_REGISTER']['number_1'] = rand(1, 9);
		$_SESSION['TMP_QUERY_REGISTER']['number_2'] = rand(1, 9);
		$_SESSION['TMP_QUERY_REGISTER']['overall']  = $_SESSION['TMP_QUERY_REGISTER']['number_1'] + $_SESSION['TMP_QUERY_REGISTER']['number_2'];
		$_SESSION['TMP_QUERY_REGISTER'] = Common::arrayChangeCaseUpper($_SESSION['TMP_QUERY_REGISTER']);	
	}
	#########################################
	# Deconnexion
	#########################################
	public function logout ()
	{
		$return = UserInfos::logout();
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
		$this->redirect('user', 3);
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
		unset($_POST['send']);
		$return = $this->models->checkToken($_POST);
		if (!isset($return['pass'])) {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('PASSWORD'), false);
			$this->redirect('User/LostPassword', 3);
		} else {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('PASSWORD'), false);
		}
	}

	public function sendRegister ()
	{
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
	public function sendSecurelogin ()
	{
		if (isset($_REQUEST['umal']) && isset($_REQUEST['passwrd'])) {
			if (!empty($_REQUEST['umal']) && !empty($_REQUEST['passwrd'])) {

				if (Secure::isMail($_REQUEST['umal']) === false) {
					$return['text'] = 'Veuillez entrer votre e-mail';
					$return['type']	= 'warning';
					$this->error = true;
					$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
					$this->redirect('managements', 2);
					return;
				}

				$return = array();

				$sql = New BDD();
				$sql->table('TABLE_USERS');
				$sql->where(array('name' => 'email', 'value' => $_REQUEST['umal']));
				$sql->queryOne();
				$data = $sql->data;

				if (password_verify($_REQUEST['passwordhash'], $data->passwordhash)) {
					if ($_SESSION['USER']['HASH_KEY'] == $data->hash_key) {
						$interaction = New Interaction;
						$interaction->user($_SESSION['USER']['HASH_KEY']);
						$interaction->type('success');
						$interaction->title('Accès autorisé');
						$interaction->text('S\'est connecté au management');
						$interaction->insert();
						$_SESSION['LOGIN_MANAGEMENT'] = true;
						$return['text'] = 'login en cours...';
						$return['type']	= 'success';
					} else {
						$Interaction = New Interaction;
						$Interaction->user($_SESSION['USER']['HASH_KEY']);
						$Interaction->type('error');
						$Interaction->title('Accès non autorisé');
						$Interaction->text('À tenter de ce connecté avec un autre Hash Key !');
						$Interaction->insert();
						$return['text'] = 'Hash_key ne corespond pas au votre ?...';
						$return['type']	= 'danger';
					}
				} else {
					$Interaction = New Interaction;
					$Interaction->user($_SESSION['USER']['HASH_KEY']);
					$Interaction->type('error');
					$Interaction->title('Accès non autorisé');
					$Interaction->text('Tentative d\'accès avec un mauvais mot de passe !');
					$Interaction->insert();
					$return['text'] = 'Le password n\'est pas le bon !!!';
					$return['type']	= 'warning';
				}
			}
		}
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->error('Managements', $return['text'], $return['type']);
		$this->redirect('managements', 2);
	}
	public function sendLogin ()
	{
		if (empty($this->data)) {
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
			$this->error(ERROR, 'Field Empty', 'error');
		} else {
			$return = UserInfos::login($this->data['username'], $this->data['password']);
			if ($return['type'] == 'error') {
				Notification::error($return['msg']);
				$this->redirect('User/Login&echo', 3);
			} else if ($return['type'] == 'warning') {
				$this->redirect('User/Login&echo', 3);
				Notification::warning($return['msg']);
			} else if ($return['type'] == 'success') {
				$this->redirect('User/Profil', 3);
				Notification::success($return['msg']);
			} else {
				$this->redirect('User/login&echo', 3);
				Notification::warning('Erreur inconnu');
			}
		}
	}

	private function mailpassword ()
	{
		if (empty($this->data)) {
			$this->error(ERROR, 'Field Empty');
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
			$this->redirect('user/login', 3);
		} else {
			unset($this->data['send']);
			$return = $this->models->sendEditPassword($this->data);
			$this->error('Edit mail & password', $return['msg'], $return['type']);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
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
				echo json_encode('Error API KEY');
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
		$this->error($return['title'], $return['msg'], $return['type']);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->redirect('User', 2);
	}
	#########################################
	# Enregistre le compte securiter (mdp)
	#########################################
	public function sendsecurity ()
	{
		$return = $this->models->sendSecurity($this->data);
		$this->error($return['title'], $return['msg'], $return['type']);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->redirect('User', 2);
	}
	#########################################
	# Selectionne l'avatar ou le supprime
	#########################################
	public function avatarsubmit ()
	{
		$return = $this->models->avatarSubmit($this->data);
		$this->error($return['ext'], $return['msg'], $return['type']);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->redirect('User', 2);
	}
	#########################################
	# Enregistre le nouveau avatar (upload)
	#########################################
	public function newavatar ()
	{
		$return = $this->models->sendNewAvatar();
		$this->error($return['ext'], $return['msg'], $return['type']);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->redirect('User', 2);
	}
	#########################################
	# Change les liens social
	#########################################
	public function submitsocial ()
	{
		$return = $this->models->sendSubmitSocial($this->data);
		$this->error($return['ext'], $return['msg'], $return['type']);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('MANAGEMENTS'), false);
		$this->redirect('User', 2);
	}
}
