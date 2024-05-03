<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.2 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
#   TABLE_USERS
#-> id, author, ip, date, reason
final class ModelsBan
{
	public function getUsers ($user = null)
	{
		$sql = New BDD;
		$sql->table('TABLE_USERS');
		if ($user !== null) {
			$where = array('name' => 'author', 'value' => $user);
			$sql->where($where);
			$sql->queryOne();
		} else {
			$sql->queryAll();
		}
		$return = $sql->data;

		return $return;
	}

	public function sendadd ($data)
	{
		// Variables et récupérations de données.
		$return  = (object) array();
		$author  = strlen($data['author']) == 32 ? $data['author'] : false;
		$author  = str_replace(' ', "_", $author);
		$ipBan   = Secure::isIp($data['ip_ban']);
		$date    = Secure::isString($data['date']);
		$reason  = Common::VarSecure($data['reason'], 'html');
		$email   = Secure::isMail($data['email']);
		$gold    = empty($data['gold']) ? false : true;
		// Initialise le time.
		$current = new DateTime('now');
		$date    = $current->format('Y-m-d H:i:s');
		// Récupère le serial de l'administrateur.
		if ($gold) {
			$gold = empty(Secure::isInt($data['gold'])) ? null : Secure::isInt($data['gold']);
		}
		// Recherche un auteur & email & ip ou rien.
		if ($author != false and $email != false and $ipBan != false) {
			$where   = 'WHERE 1 AND `author` = "'.$author.'" or `email` = "'.$email.'" or `ip` = "'.$ipBan.'"';
		} elseif ($author == false and $email == false and $ipBan == false) {
			$where = false;
		} else if ($author == false and $email == false and $ipBan != false) {
			$where  = 'WHERE 1 AND `ip` = "'.$ipBan.'"';
		} else if ($author == false and $email != false and $ipBan == false) {
			$where  = 'WHERE 1 AND `email` = "'.$email.'"';
		} else if ($author != false and $email == false and $ipBan == false) {
			$where  = 'WHERE 1 AND `author` = "'.$author.'"';
		} else {
			$where  = false;
		}
		// Recherche un auteur & email & ip ou rien.
		if ($author != false or $email != false or $ipBan != false) {
			self::deleteBan($where);
		}
		// Initialise le time du ban.
		$current->add(new DateInterval($data['date']));
		$endban  = $current->format('Y-m-d H:i:s');
		$timeban = $data['date'];
		// L'auteur ou L'IP ou email est vide.
		if ($author == false and $email == false and $ipBan == false) {
			return array(
				'type' => 'error',
				'text' => constant('NO_EXIST_USER_IP_MAIL')
			);
		}
		// Impossible de s'autobannir par nom (logiquement impossible, vu qu'il ne se trouve pas dans la liste)...).
		if ($author == $_SESSION['USER']->user->username or $ipBan == Common::GetIp()) {
			return array(
				'type' => 'error',
				'text' => constant('IMPOSSIBLE_TO_BAN_YOURSELF')
			);
		}
		// Utilisateur qui veut ban par hash_key.
		$user = New BDD;
		$user->table('TABLE_USERS');
		$user->where('WHERE 1 AND `hash_key` = "'.$_SESSION['USER']->user->hash_key.'"');
		$user->queryOne();
		// Utilisateur qui veut ban par ip.
		$userIP = New BDD;
		$userIP->table('TABLE_USERS');
		$userIP->where('WHERE 1 AND `ip` = "'.Common::GetIp().'"');
		$userIP->queryOne();
		// Vérifie si l'utilisateur existe.
		$sql = New BDD;
		$sql->table('TABLE_USERS');
		$where  = str_replace('author', "hash_key", $where);
		$sql->where($where);
		$sql->queryOne();
		if ($sql->rowCount != 0) {
			$user = $sql->data;
			$userHash_key = $user->hash_key;
			$userInfos = User::getInfosUserAll($userHash_key);
			$gold = $userInfos->user->gold;
			$groups = $userInfos->groups->all_groups;
		}
		// Contrôle si l'utilisateur a un compte enregistré [NON].
		if ($sql->rowCount == 0) {
			// Contrôle si e-mail d'utilisateur est à bannir est bon.
			if ($sql->data->mail && $sql->data->ip) {
				$textTime = defined(strtoupper($timeban)) ? constant(strtoupper($timeban)) : null;
				self::addBan (null,$sql->data->ip,$sql->data->mail,$date,$endban,$timeban,$reason);
				return array(
					'type' => 'success',
					'text' => constant('EMAIL_USER').' : '.$email.'<br>'.constant('END').' IP : '.$ipBan.' '.constant('EAST').' '.constant('BANNED_SUCCESSFULLY').'<br>'.constant('BAN_DURATION_OF').' '.$textTime.'<br> date de fin '.Common::TransformDate($endban, 'MEDIUM', 'SHORT')
				);
			} else {
				$error = constant('NO_EXIST_IP_MAIL');
			}
			if ($email and !empty($error)) {
				$textTime = defined(strtoupper($timeban)) ? constant(strtoupper($timeban)) : null;
				self::addBan (null,null,$email,$date,$endban,$timeban,$reason);
				return array(
					'type' => 'success',
					'text' => constant('EMAIL_USER').' : '.$email.' '.constant('EAST').' '.constant('BANNED_SUCCESSFULLY').'<br>'.constant('BAN_DURATION_OF').' '.$textTime.'<br> date de fin '.Common::TransformDate($endban, 'MEDIUM', 'SHORT')
				);
			} else {
				$error = constant('EMAIL_USER_BAN');
			}
			// Contrôle si IP d'utilisateur est à bannir est bon.
			if ($ipBan) {
				$textTime = defined(strtoupper($timeban)) ? constant(strtoupper($timeban)) : null;
				self::addBan (null,$ipBan,null,$date,$endban,$timeban,$reason);
				return array(
					'type' => 'success',
					'text' => constant('IP_USER').' : '.$ipBan.' '.constant('EAST').' '.constant('BANNED_SUCCESSFULLY').'<br>'.constant('BAN_DURATION_OF').' '.$textTime.'<br> date de fin '.Common::TransformDate($endban, 'MEDIUM', 'SHORT')
				);
				$error = constant('BANNED_SUCCESSFULLY');
			} else {
				$error = constant('IPV4_IPV6_NO_VALID');
			}
			// return l'erreur en texte.
			if (!empty($error)) {
				return array(
					'type' => 'error',
					'text' => $error
				);
			}
		// Contrôle si l'utilisateur est un Gold ou du group 1 (administrateur) [OUI].
		} else if ($gold == '1' or in_array(1, $groups)) {
			// Contrôle si l'utilisateur qui va bannir est un Gold ou qu'il possède une clef sécurité valide.
			if ($user->data->gold == '1' or constant('KEY_ADMIN') == $gold) {
				// Contrôle si l'utilisateur à bannir existe et son IP
				if (User::ifUserExist($sql->data->hash_key) and Secure::isIp($sql->data->ip) or $email !== false) {
					$textTime = defined(strtoupper($timeban)) ? constant(strtoupper($timeban)) : null;
					self::addBan ($sql->data->hash_key,$sql->data->ip,$sql->data->email,$date,$endban,$timeban, $reason);
					return array(
						'type' => 'success',
						'text' => constant('USER').' : '.$sql->data->username.' '.constant('EAST').' '.constant('BANNED_SUCCESSFULLY').'<br>'.constant('WHITE').' ' .constant('SINCE').' '.constant('IP_USER').' : '.$sql->data->ip.'<br>'.constant('TOWARDS').' '.$textTime.'.'
					);
				// Verifie si l'utilisateur existe et verifie IP valide.
				} else {
					return array(
						'type' => 'error',
						'text' => constant('NO_EXIST_USER_IP_MAIL')
					);
				}
			// L'utilisateur qui veut bannir n'est pas Gold ou n'a pas de clé valide.
			}
		// Contrôle si l'utilisateur a un compte enregistré [OUI].
		} else {
			// Contrôle si l'utilisateur à bannir existe et son IP ou son email.
			if (User::ifUserExist($sql->data->hash_key) and Secure::isIp($sql->data->ip) or $sql->data->email !== false) {
				$textTime = defined(strtoupper($timeban)) ? constant(strtoupper($timeban)) : null;
				self::addBan ($sql->data->hash_key,$sql->data->ip,$sql->data->mail,$date,$endban,$timeban, $reason);
				return array(
					'type' => 'success',
					'text' => constant('USER').' : '.$sql->data->username.' '.constant('EAST').' '.constant('BANNED_SUCCESSFULLY').'<br>'.constant('WHITE').' ' .constant('SINCE').' '.constant('IP_USER').' : '.$sql->data->ip.'<br>'.constant('TOWARDS').' '.$textTime.', date de fin '.Common::TransformDate($endban, 'MEDIUM', 'SHORT').'.'
				);
			// L'utilisateur n'existe pas ou l'IP n'est pas bon.
			} else {
				return array(
					'type' => 'error',
					'text' => constant('NO_EXIST_USER_IP_MAIL')
				);
			}
		}
	}
	private function addBan ($author = null,$ip = null, $email = null, $date = null, $endban = null, $timeban = null, $reason = null
	) {
		$insert['who']      = $_SESSION['USER']->user->hash_key;
		$insert['author']   = $author;
		$insert['ip']       = $ip;
		$insert['email']    = $email;
		$insert['date']     = $date;
		$insert['endban']   = $endban;
		$insert['timeban']  = $timeban;
		$insert['reason']   = $reason;
		// BDD return count (0 or 1);
		$sql = New BDD;
		$sql->table('TABLE_BAN');
		$sql->insert($insert);
		// SQL RETURN NB INSERT
		if ($sql->rowCount == true) {
			$return = array(
				'type' => 'success',
				'text' => 'SUCCESS'
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => 'ERROR'
			);
		}
		return $return;
	}

	private function deleteBan ($where = false)
	{
		$del = New BDD;
		$del->table('TABLE_BAN');
		$del->where($where);
		$del->delete();
	}

	public function getUsersBan ()
	{
		$return = array();
		$sql = New BDD;
		$sql->table('TABLE_BAN');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}

	public function del ($id)
	{
		$return   = array();
		$valid = Common::SecureRequest($id);

		if ($valid == true) {
			$sql = New BDD;
			$sql->table('TABLE_BAN');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->delete();

			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => 'Erreur dans la base de donnée'
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('UNKNOWN_ERROR_ID')
			);
		}
		return $return;
	}
}