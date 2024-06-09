<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
*/

namespace BelCMS\User;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\Core\Config as BelCMSConfig;
use BelCMS\Core\Dispatcher;
use BelCMS\Core\Secure;
use BelCMS\Core\encrypt;
use GetHost;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class User
{
    public function __construct()
    {
		if (!isset($_SESSION['USER']) AND
		isset($_COOKIE['BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES']]) AND
		isset($_COOKIE['BELCMS_NAME_'.$_SESSION['CONFIG_CMS']['COOKIES']]) AND
		isset($_COOKIE['BELCMS_PASS_'.$_SESSION['CONFIG_CMS']['COOKIES']]))
		{
			self::loginCookies();
		}
		if (isset($_SESSION['USER']))
		{
			self::autoUpdateSession();
		}
    }
	#########################################
	# login normal
	#########################################
	public static function login($name = null, $password = null, $hash_key = false)
	{
		$return = null;
		if ($name !== null AND $password !== null) {
			if ($hash_key !== false AND strlen($hash_key) == 32) {
				$array[] = array('name' => 'hash_key', 'value' => $hash_key);
			} else if (Secure::isMail($name)) {
				$array[] = array('name'=> 'mail', 'value'=> $name);
			} else {
				$array[] = array('name'=> 'username', 'value'=> $name);
			}

			$sql = new BDD;
			$sql->table('TABLE_USERS');
			$sql->where($array);
			$sql->queryOne();
			$results = $sql->data;

			$passwordCrypt =  new encrypt($results->password, $_SESSION['CONFIG_CMS']['KEY_ADMIN']);
			$passwordDecrypt = $passwordCrypt->decrypt();

			if ($password == $passwordDecrypt) {
				setcookie(
					'BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES'],
					$results->hash_key,
					time()+60*60*24*30*3,
					"/",
					$_SERVER['HTTP_HOST'],
					true,
					true
				);
				setcookie(
					'BELCMS_NAME_'.$_SESSION['CONFIG_CMS']['COOKIES'],
					$results->username,
					time()+60*60*24*30*3,
					"/",
					$_SERVER['HTTP_HOST'],
					true,
					true
				);
				setcookie(
					'BELCMS_PASS_'.$_SESSION['CONFIG_CMS']['COOKIES'],
					$results->password,
					time()+60*60*24*30*3,
					"/",
					$_SERVER['HTTP_HOST'],
					true,
					true
				);

				$_SESSION['USER'] = self::getInfosUserAll($results->hash_key);
				$return['msg']  = constant('CONNECTION_SUCCESSFULLY');
				$return['type'] = 'success';
				return $return;
			} else {
				$return['msg']  = constant('WRONG_USER_PASS');
				$return['type'] = 'error';
				//self::addBan ();
				return $return;
			}
		} else {
			if ($hash_key AND strlen($hash_key) == 32) {
				$return['msg']  = constant('NAME_OR_PASS_REQUIRED');
				$return['type'] = 'error';
				return $return;
			}
		}
	}
	#########################################
	# login COOKIES
	#########################################
	public static function loginCookies ()
	{
		if (self::isLogged() === false and Dispatcher::view() != 'logout') {
			$hash_key = $_COOKIE['BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES']];
			$password = $_COOKIE['BELCMS_PASS_'.$_SESSION['CONFIG_CMS']['COOKIES']];

			$where[] = array('name' => 'hash_key', 'value' => $hash_key);
			$where[] = array('name'=> 'password','value'=> $password);

			$sql = new BDD;
			$sql->table('TABLE_USERS');
			$sql->where($where);
			$sql->queryOne();
			$results = $sql->data;
		
			if (!empty($results)) {
				$_SESSION['USER'] = self::getInfosUserAll($results->hash_key);
			} else {
				return false;
			}
		}
	}
	#########################################
	# Delete all user configuration.
	#########################################
	public static function delUserAllCofnig ($hash_key = false)
	{
		if ($hash_key !== false and strlen($hash_key) == 32) {
			$delUsers = new BDD;
			$delUsers->table('TABLE_USERS');
			$delUsers->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delUsers->delete();

			$delprofils = new BDD;
			$delprofils->table('TABLE_USERS_PROFILS');
			$delprofils->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delprofils->delete();

			$delSocial = new BDD;
			$delSocial->table('TABLE_USERS_SOCIAL');
			$delSocial->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delSocial->delete();

			$delGaming = new BDD;
			$delGaming->table('TABLE_USERS_GAMING');
			$delGaming->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delGaming->delete();

			$delGaming = new BDD;
			$delGaming->table('TABLE_USERS_GROUPS');
			$delGaming->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delGaming->delete();

			$delGaming = new BDD;
			$delGaming->table('TABLE_USERS_PAGE');
			$delGaming->where(array('name' => 'hash_key', 'value' => $hash_key));
			$delGaming->delete();

			self::logout();
		}
	}
	#########################################
	# is logged true or false.
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
	# ADD Ban
	#########################################
	private static function addBan ()
	{
		$where = array('name' => 'ip', 'value' => Common::GetIp());
		$sql = new BDD;
		$sql->table('TABLE_BAN');
		$sql->where($where);
		$sql->orderby(array('name' => 'id', 'type' => 'DESC'));
		$sql->limit(1);
		$sql->queryOne();

		if (empty($sql->data)) {
			$dateNow = new \DateTimeImmutable('now');
			$endban  = $dateNow->format('Y-m-d H:i:s');
			$insert['date']    = $dateNow->format('Y-m-d H:i:s');
			$insert['ip']      = Secure::isIp(Common::GetIp());
			$insert['endban']  = $endban;
			$insert['reason']  = constant('NO_BANS_YET');
			$insert['number']  = 1;
			$update['timeban'] = 'PT0M';
			$sqlInsert = new BDD;
			$sqlInsert->table('TABLE_BAN');
			$sqlInsert->insert($insert);
			return $insert['reason'];
		} else {
			$dateNow = new \DateTimeImmutable('now');
			$count = $sql->data->number;
			$count = $count + 1;

			switch ($count) {
				case '1':
					$update['timeban'] = '0';
					$newDate = $dateNow->format('Y-m-d H:i:s');
					$return  = false;
				break;

				case '2':
					$update['timeban'] = '0';
					$newDate = $dateNow->format('Y-m-d H:i:s');
					$return  = false;
				break;

				case '3':
					$update['timeban'] = '0';
					$newDate = $dateNow->format('Y-m-d H:i:s');
					$return  = false;
				break;

				case '4':
					$update['timeban'] = 'PT1M';
					$newDate = $dateNow->add(new \DateInterval('PT1M'));
					$return  = constant('ACCOUNT_BLOCKED_ONE');
				break;

				case '5':
					$update['timeban'] = 'PT5M';
					$newDate = $dateNow->add(new \DateInterval('PT5M'));
					$return  = constant('ACCOUNT_BLOCKED_FIVE');
				break;

				case '6':
					$update['timeban'] = 'PT10M';
					$newDate = $dateNow->add(new \DateInterval('PT10M'));
					$return  = constant('ACCOUNT_BLOCKED_TEN');
				break;

				case '7':
					$update['timeban'] = 'PT15M';
					$newDate = $dateNow->add(new \DateInterval('PT15M'));
					$return  = constant('ACCOUNT_BLOCKED_FIFTEEN');
				break;

				case '8':
					$update['timeban'] = 'PT30M';
					$newDate = $dateNow->add(new \DateInterval('PT30M'));
					$return  = constant('ACCOUNT_BLOCKED_THIRTY');
				break;

				case '9':
					$update['timeban'] = 'PT1H';
					$newDate = $dateNow->add(new \DateInterval('PT1H'));
					$return  = constant('ACCOUNT_BLOCKED_ONE_HOUR');
				break;
				
				case '10':
					$update['timeban'] = 'P1D';
					$newDate = $dateNow->add(new \DateInterval('P1D'));
					$return  = constant('ACCOUNT_BLOCKED_TWENTY_FOUR');
				break;

				case '11':
					$update['timeban'] = 'P99Y';
					$newDate = $dateNow->add(new \DateInterval('P99Y'));
					$return  = constant('ACCOUNT_BLOCKED_LIFE');
				break;
				
				default:
					$update['timeban'] = 'P99Y';
					$newDate = $dateNow->add(new \DateInterval('P99Y'));
					$return  = constant('ACCOUNT_BLOCKED_LIFE');
				break;
			}

			$update['reason']  = Common::VarSecure($return, 'html');
			if ($return === false) {
				$update['endban']  = $newDate;
				$return = constant('NO_BANS_YET');
			} else {
				$update['endban']  = $newDate->format('Y-m-d H:i:s');
			}
			$update['number']  = $count;
			$sqlUpdate = new BDD;
			$sqlUpdate->table('TABLE_BAN');
			$sqlUpdate->update($update);

			self::dieCoockie();
			return $return;
		}
	}
	public static function dieCoockie() 
	{
		$domain = ($_SERVER['HTTP_HOST']);
		setcookie('BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES'], false, time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_NAME_'.$_SESSION['CONFIG_CMS']['COOKIES'], false, time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_PASS_'.$_SESSION['CONFIG_CMS']['COOKIES'], false, time()-60*60*24*365, '/', $domain, false);
		unset($_SESSION['USER'], $_COOKIE["BELCMS_HASH_KEY"],$_COOKIE["BELCMS_NAME"], $_COOKIE["BELCMS_PASS"]);
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
		setcookie('BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES'], 'data', time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_NAME_'.$_SESSION['CONFIG_CMS']['COOKIES'], 'data', time()-60*60*24*365, '/', $domain, false);
		setcookie('BELCMS_PASS_'.$_SESSION['CONFIG_CMS']['COOKIES'], 'data', time()-60*60*24*365, '/', $domain, false);

		unset($_SESSION['USER'], $_COOKIE["BELCMS_HASH_KEY"],$_COOKIE["BELCMS_NAME"], $_COOKIE["BELCMS_PASS"]);

		if (isset($_SESSION)) {
			session_destroy();
		}

		$return['msg']  = constant('SESSION_COOKIES_DELETE');
		$return['type'] = 'success';

		return $return;
	}
	#########################################
	# Récupère le hash_key depuis un username
	#########################################
	public static function getHashKey ($username = false)
	{
		$username = Common::VarSecure($username, null);
		$user = new BDD();
		$user->table('TABLE_USERS');
		$user->where(array(
			'name'  => 'username',
			'value' => $username
		));
		$user->fields(array('hash_key'));
		$user->queryOne();
		$return = $user->data;
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
			$user->fields(array('username','hash_key', 'password', 'mail', 'ip', 'valid', 'expire', 'token', 'gold', 'number_valid'));
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
				$profils->fields(array('gender','public_mail','websites','list_ip','avatar','info_text','birthday','country','hight_avatar','friends', 'date_registration', 'visits','gravatar', 'profils'));
				$profils->isObject(false);
				$profils->queryOne();
				if ($profils->data['gravatar'] == '1') {
					$gravatar = hash('sha256', strtolower(trim($a['user']->mail)));
					$profils->data['avatar'] = 'https://gravatar.com/avatar/'.$gravatar;
				}
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
				if ($count == true) {
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
			//debug($return);
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