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

namespace BELCMS\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class User
{
    public function __construct()
    {
		if (User::isLogged() === true) {
			self::autoUpdateSession();
		} else {
			self::autoLogin();
		}    
    }

    private function coockies ()
    {
    	
    }
	#########################################
	# is logged true or false
	#########################################
	public static function isLogged ():bool
	{
		if (isset($_SESSION['USER']['HASH_KEY']) and strlen($_SESSION['USER']['HASH_KEY']) == 32) {
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
		if (User::isLogged() === true) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']['HASH_KEY']));
			$sql->update(
				array(
					'last_visit' => date('Y-m-d H:i:s'),
					'ip' => Common::GetIp(),
					'expire' => 0,
				)
			);
		}
	}
	#########################################
	# Auto connection via cookies
	#########################################
	private function autoLogin()
	{
		// Si la session existe déjà, inutile d'aller plus loin
		if (User::isLogged() === false) {
			if (
				isset($_COOKIE['BEL-CMS-HASH_KEY']) AND
				!empty($_COOKIE['BEL-CMS-HASH_KEY']) AND
				isset($_COOKIE['BEL-CMS-NAME']) AND
				!empty($_COOKIE['BEL-CMS-NAME']) AND
				isset($_COOKIE['BEL-CMS-PASS']) AND
				!empty($_COOKIE['BEL-CMS-PASS'])
			) {
				if (strlen($_COOKIE['BEL-CMS-HASH_KEY']) == 32) {
					self::login($_COOKIE['BEL-CMS-NAME'], $_COOKIE['BEL-CMS-PASS'], $_COOKIE['BEL-CMS-HASH_KEY']);
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

			if ($results && is_array($results) && sizeof($results)) {
				if ($results['expire'] >= 4) {
					$return['msg']  = constant('ACCOUNT_BLOCKED_REQUEST_NEW_PASS');
					$return['type'] = constant('ERROR');
					return $return;				
				}
				if ($hash_key AND strlen($hash_key) == 32) {
					$check_password = $password == $results['passwordhash'] ? true : false;
				} else {
					$check_password = false;
				}
				if ($results['valid'] == 0) {
					$return['msg']  = constant('VALIDATION_REQUIRED');
					$return['type'] = constant('ERROR');
				}
				if (password_verify($password, $results['passwordhash']) OR $check_password) {
					setcookie(
						'BEL-CMS-HASH_KEY',
						$results['hash_key'],
						time()+60*60*24*30*3,
						"/",
						$_SERVER['HTTP_HOST'],
						true,
						true
					);
					setcookie(
						'BEL-CMS-NAME',
						$results['username'],
						time()+60*60*24*30*3,
						"/",
						$_SERVER['HTTP_HOST'],
						true,
						true
					);
					setcookie(
						'BEL-CMS-PASS',
						$results['passwordhash'],
						time()+60*60*24*30*3,
						"/",
						$_SERVER['HTTP_HOST'],
						true,
						true
					);
					$_SESSION['USER']['HASH_KEY'] = $results['hash_key'];
					$update = New BDD();
					$update->table('TABLE_USERS');
					$update->where(array('name'=>'hash_key','value'=> $results['hash_key']));
					$update->update(array('expire'=> 0));
					$return['msg']  = constant('CONNECTION_SUCCESSFULLY');
					$return['type'] = constant('SUCCESS');
				} else {
					// En cas de modification manuel des cookies pour tromper le login
					self::logout();
					$return['msg']  = constant('WRONG_USER_PASS');
					$return['type'] = constant('ERROR');
						$results['expire']++;
						$insert = New BDD();
						$insert->table('TABLE_USERS');
						$insert->where(array('name'=>'hash_key','value'=> $results['hash_key']));
						$insert->update(array('expire'=> $results['expire']));
				}
			} else {
				// En cas de modification manuel des cookies pour tromper le login
				self::logout();
				$return['msg']  = constant('NO_USER_WITH_USER_AND_MAIL');
				$return['type'] = constant('WARNING');
			}
		} else {
			if ($hash_key AND strlen($hash_key) == 32) {
				$return['msg']  = constant('NAME_OR_PASS_REQUIRED');
				$return['type'] = constant('ERROR');
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

		unset($_SESSION['USER']);
		setcookie('BEL-CMS-HASH_KEY', '', -1, '/');
		setcookie('BEL-CMS-NAME', '', -1, '/');
		setcookie('BEL-CMS-PASS', '', -1, '/');
		session_destroy();

		$return['msg']  = constant('SESSION_COOKIES_DELETE');
		$return['type'] = constant('SUCCESS');

		return $return;
	}
}