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

namespace BelCMS\User;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Core;
use BelCMS\Requires\Common as Common;
use BelCMS\Core\Config as BelCMSConfig;
use BelCMS\Core\Dispatcher as Dispatcher;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class User
{
    public function __construct()
    {
		if (isset($_SESSION['USER'])) {
			self::autoUpdateSession();
		} else {
			if (Dispatcher::view() != 'logout') {
				self::autoLogin();
			}
		}    
    }
	#########################################
	# is logged true or false
	#########################################
	public static function isLogged () : bool
	{
		if (!empty($_SESSION['USER'])) {
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}
	#########################################
	# Auto update last visit timer
	#########################################
	private function autoUpdateSession ()
	{
		if (User::isLogged() === true and Dispatcher::view() != 'logout') {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update(array('ip' => Common::GetIp(),'expire' => 0));
			unset($sql); 
			$sql = New BDD();
			$sql->table('TABLE_USERS_PAGE');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
			$sql->update(array('namepage' => Dispatcher::name() ,'last_visit' => date('Y-m-d H:i:s')));
			unset($sql);
		}
	}
	#########################################
	# Auto connection via cookies
	#########################################
	private function autoLogin()
	{
		// Si la session existe déjà, inutile d'aller plus loin
		if (self::isLogged() === false and Dispatcher::view() != 'logout') {
			// Control si la variable $_COOKIE existe
			if (
				isset($_COOKIE['BELCMS_HASH_KEY']) AND
				!empty($_COOKIE['BELCMS_HASH_KEY']) AND
				isset($_COOKIE['BELCMS_NAME']) AND
				!empty($_COOKIE['BELCMS_NAME']) AND
				isset($_COOKIE['BELCMS_PASS']) AND
				!empty($_COOKIE['BELCMS_PASS'])
			) {
				// Passe en tableaux les valeurs du $_COOKIE
				$name     = $_COOKIE['BELCMS_NAME'];
				$hash_key = $_COOKIE['BELCMS_HASH_KEY'];
				$hash     = $_COOKIE['BELCMS_PASS'];
				// Verifie le hash_key est bien de 32 caractere
				if ($hash_key AND strlen($hash_key) == 32) {
					self::login($name, $hash, $hash_key);
				}
			}
		}
	}
	#########################################
	# login
	#########################################
	public static function login($name = null, $password = null, $hash_key = false)
	{
		// Get utilisateur dans la BDD;
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		// Verifie que $name & $password ne son pas vide
		if (!empty($name) AND !empty($password)) {
			// Connexion par mail, name ou par hash_key
			if ($hash_key AND strlen($hash_key) == 32) {
				$hash_key_search = array(
					'name'  => 'hash_key',
					'value' => $hash_key
				);
			} else {
				$hash_key_search = null;
			}
			if (strpos($name, '@')) {
				$request = 'mail';
			} else {
				$request = 'username';
			}

			$sql->where(
				array(
					'name'  => $request,
					'value' => $name
				), $hash_key_search
			);

			$sql->queryOne();

			$results = $sql->data;

			if ($results && is_object($results)) {
				if ($results->expire >= 4) {
					$return['msg']  = constant('ACCOUNT_BLOCKED_REQUEST_NEW_PASS');
					$return['type'] = 'error';
					return $return;				
				}
				if ($results->valid == 0) {
					$return['msg']  = constant('VALIDATION_REQUIRED');
					$return['type'] = 'error';
				}
				if ($hash_key AND strlen($hash_key) == 32) {
					$check_password = $password == $results->password ? true : false;
				} else {
					$check_password = false;
				}
				if (password_verify($password, $results->password) OR $check_password) {
					if (
						!isset($_COOKIE['BELCMS_HASH_KEY']) && 
						!isset($_COOKIE['BELCMS_NAME']) && 
						!isset($_COOKIE['BELCMS_PASS'])
					) {
						setcookie(
							'BELCMS_HASH_KEY',
							$results->hash_key,
							time()+60*60*24*30*3,
							"/",
							$_SERVER['HTTP_HOST'],
							true,
							true
						);
						setcookie(
							'BELCMS_NAME',
							$results->username,
							time()+60*60*24*30*3,
							"/",
							$_SERVER['HTTP_HOST'],
							true,
							true
						);
						setcookie(
							'BELCMS_PASS',
							$results->password,
							time()+60*60*24*30*3,
							"/",
							$_SERVER['HTTP_HOST'],
							true,
							true
						);
					}
					$_SESSION['USER'] = self::getInfosUserAll($results->hash_key);
					$update = New BDD();
					$update->table('TABLE_USERS');
					$update->where(array('name'=>'hash_key','value'=> $results->hash_key));
					$update->update(array('expire'=> 0));
					$return['msg']  = constant('CONNECTION_SUCCESSFULLY');
					$return['type'] = 'success';
				} else {
					// En cas de modification manuel des cookies pour tromper le login
					$return['msg']  = constant('WRONG_USER_PASS');
					$return['type'] = 'error';
					$results->expire++;
					$insert = New BDD();
					$insert->table('TABLE_USERS');
					$insert->where(array('name'=>'hash_key','value'=> $results->hash_key));
					$insert->update(array('expire'=> $results->expire));
				}
			} else {
				// En cas de modification manuel des cookies pour tromper le login
				self::logout();
				$return['msg']  = constant('NO_USER_WITH_USER_AND_MAIL');
				$return['type'] = 'warning';
			}
		} else {
			if ($hash_key AND strlen($hash_key) == 32) {
				$return['msg']  = constant('NAME_OR_PASS_REQUIRED');
				$return['type'] = 'error';
			}
		}
		return $return;
	}
	#########################################
	# Logout
	#########################################
	public static function logout()
	{
		$return = array();

		if (isset($_SESSION['LOGIN_MANAGEMENT'])) {
			unset($_SESSION['LOGIN_MANAGEMENT']);
		}

		$domain = ($_SERVER['HTTP_HOST']);
		setcookie('BELCMS_HASH_KEY', 'data', time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_NAME', 'data', time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_PASS', 'data', time()-60*60*24*365, '/', $domain, false);

		unset($_SESSION['USER'], $_COOKIE["BELCMS_HASH_KEY"],$_COOKIE["BELCMS_NAME"], $_COOKIE["BELCMS_PASS"]);

		session_destroy();

		$return['msg']  = constant('SESSION_COOKIES_DELETE');
		$return['type'] = 'success';

		/* Re cree la _SESSION; */
		if(!isset($_SESSION)) {
			session_start();
		}
		$_SESSION['NB_REQUEST_SQL']   = 0;
		/* Re cree la _SESSION; */
		return $return;
	}
	#########################################
	# Change hash_key en username ou avatar
	#########################################
	public static function getInfosUserAll ($hash_key = false)
	{
		$return = (object) array ();
		if ($hash_key !== false) {
			/* Return info de la table user */
			$user = new BDD();
			$user->table('TABLE_USERS');
			$user->where(array(
				'name'  => 'hash_key',
				'value' => $hash_key
			));
			$user->fields(array('username','hash_key', 'mail', 'ip', 'valid', 'expire', 'token', 'gold'));
			$user->isObject(false);
			$user->queryOne();
			if (!empty($user->data)) {
				$a = array('user' => (object) $user->data);
				/* Return info des groupes de l'user */
				$group = new BDD();
				$group->table('TABLE_USERS_GROUPS');
				$group->where(array(
					'name'  => 'hash_key',
					'value' => $hash_key
				));
				$group->fields(array('user_group','user_groups'));
				$group->isObject(false);
				$group->queryOne();
				$b = array('groups' => (object) $group->data);
				/* Return le profils de l'user */
				$profils = new BDD();
				$profils->table('TABLE_USERS_PROFILS');
				$profils->where(array(
					'name'  => 'hash_key',
					'value' => $hash_key
				));
				$profils->fields(array('gender','public_mail','websites','list_ip','avatar','config','info_text','birthday','country','hight_avatar','friends', 'date_registration'));
				$profils->isObject(false);
				$profils->queryOne();
				$c = array('profils' => (object) $profils->data);
				/* Return le profils de l'user */
				$social = new BDD();
				$social->table('TABLE_USERS_SOCIAL');
				$social->where(array(
					'name'  => 'hash_key',
					'value' => $hash_key
				));
				$social->fields(array('facebook','youtube','whatsapp','instagram','messenger','tiktok','snapchat','telegram','pinterest','x_twitter','reddit','linkedIn','skype','viber','teams_ms','discord','twitch'));
				$social->isObject(false);
				$social->queryOne();
				$d = array('social' => (object) $social->data);
				/* Return info du social */
				/* Return info de la table user */
				$user = new BDD();
				$user->table('TABLE_USERS_PAGE');
				$user->where(array(
					'name'  => 'hash_key',
					'value' => $hash_key
				));
				$user->fields(array('namepage', 'last_visit'));
				$user->isObject(false);
				$user->queryOne();
				$e = array('page' => (object) $user->data);
				/* Return info de la table game */
				$game = new BDD();
				$game->table('TABLE_USERS_GAMING');
				$game->where(array(
					'name'  => 'hash_key',
					'value' => $hash_key
				));
				$game->fields(array('name_game'));
				$game->isObject(false);
				$game->queryOne();
				$f = array('games' => (object) $game->data);
				$return = (object) array_merge($a, $b, $c, $d, $e, $f);
				if (empty($game->data['name_game'])) {
					$return->games->name_game = array();
				} else if (!empty($game->data['name_game'])) {
					$return->games->name_game = explode("|", $game->data['name_game']);
				} else {
					$return->games->name_game =  array();
				}
				$return->user->color = User::colorUsername($hash_key);
				$return->groups->all_groups[] = (int) $return->groups->user_group;
				$count = strpos($return->groups->user_groups,'|');
				if ($count === false) {
					$groups  = explode("|", $return->groups->user_groups);
					foreach ($groups as $k => $v) {
						if (!in_array($v, $return->groups->all_groups)) {
							$return->groups->all_groups[] = (int) $v;
						}
					}
				} else {
					if (!in_array($return->groups->user_groups, $return->groups->all_groups)) {
						$return->groups->all_groups[] = (int) $return->groups->user_groups;
					}
				}
			} else {
				$return = false;
			}
			return $return;
		}
	}
	public static function colorUsername ($hash_key = null, $username = null)
	{
		$color = "#000000";
		if ($hash_key == null and $username)
		{
			$sql = New BDD();
			$sql->table('TABLE_USERS_GROUPS');
			$sql->where(array(
				'name'  => 'hash_key',
				'value' => Common::VarSecure($hash_key, null)
			));
			$sql->fields(array('user_group'));
			$sql->queryOne();
			if (!empty($sql->data)) {
				foreach (BelCMSConfig::getGroups() as $k => $v) {
					if ($sql->data->user_group == $v['id']) {
						$color = $v['color'];
						break;
					}
				}
			} else {
				$color = "#000000";
			}
		} elseif (Common::hash_key($hash_key)) {
			$sql = New BDD();
			$sql->table('TABLE_USERS_GROUPS');
			$sql->where(array(
				'name'  => 'hash_key',
				'value' => $hash_key
			));
			$sql->fields(array('user_group'));
			$sql->queryOne();

			if (!empty($sql->data)) {
				foreach (BelCMSConfig::getGroups() as $k => $v) {
					if ($sql->data->user_group == $v['id']) {
						$color = $v['color'];
						break;
					}
				}
			} else {
				$color = "#000000";
			}
		}
		return $color;
	}
	#########################################
	# Verifie si l'utilisateur existe
	#########################################
	public static function ifUserExist ($hash_key = null)
	{
		$return = false;

		if ($hash_key !== null && strlen($hash_key) == 32) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array(
				'name'  => 'hash_key',
				'value' => $hash_key
			));
			$sql->count();
			$return = $sql->data;
			if (!empty($return)) {
				$return = true;
			}
		}

		return $return;
	}
}
new User;