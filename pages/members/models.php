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

namespace Belcms\Pages\Models;
use BelCMS\Core\Dispatcher as Dispatcher;
use BelCMS\Core\Secure as Secure;
use BelCMS\PDO\BDD as BDD;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Members
{
	public function GetUsers ($where = false)
	{
		$nbpp = (int) 9;

		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->orderby(array(array('name' => 'username', 'type' => 'ASC')));
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$sql->queryAll();
		$returnSql = $sql->data;
		unset($sql);

		foreach ($returnSql as $k => $v) {
			$return[$k] = User::getInfosUserAll($v->hash_key);
		}
		return $return;
	}

	public function GetLastPost ($hash_key)
	{
		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$sql->where(array('name' => 'author', 'value' => $hash_key));
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit(3);
		$sql->queryAll();
		$return = $sql->data;
		unset($sql);

		return $return;
	}

	public function addFriendSQL ($hash_key = false)
	{
		if ($hash_key !== false && ctype_alnum($hash_key)) {
			$sql = New BDD;
			$sql->table(constant('TABLE_USERS_PROFILS'));
			$where = array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key);
			$sql->where($where);
			$sql->queryOne();
			$count  = $sql->rowCount;
			$data   = $sql->data;
			unset($sql);
			if ($count == 0) {
				return null;
			} else {
				$friends = explode('|', $data->friends);
				if (!in_array($hash_key, $friends)) {
					$friends[] = $hash_key;
					$implode   = implode('|', $friends);
					$sql = New BDD;
					$sql->table(constant('TABLE_USERS_PROFILS'));
					$where = array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key);
					$sql->where($where);
					$update['friends'] = $implode;
					$sql->update($update);
					return $sql->rowCount;
				}
			}
		} else {
			return null;
		}
	}

	public function getJson ()
	{
		$user   = array();
		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->orderby(array(array('name' => 'username', 'type' => 'DESC')));
		$sql->fields(array('hash_key', 'username', 'last_visit'));
		$sql->queryAll();

		foreach ($sql->data as $k => $v) {
			$sql = New BDD();
			$sql->table('TABLE_USERS_PROFILS');
			$where = 	array(
							'name'  => 'hash_key',
							'value' => $v->hash_key
						);
			$sql->where($where);
			$sql->fields(array('websites', 'country'));
			$sql->queryOne();
			$user[$k]->username = $v->username;
			$user[$k]->last_visit = $v->last_visit;
			$user[$k]->websites = $sql->data->websites;
			$user[$k]->country = $sql->data->country;
			$return['data'] = $user;
		}

		return $return;
	}

	public function getViewUser ($name)
	{
		$return = array();

		if (!empty($name)) {
			$name = trim($name);

			$sql = New BDD;
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'username', 'value' => $name));
			$sql->queryOne();
			$data = $sql->data;

			if (!empty($data)) {
				$data->main_groups = explode('|', $data->main_groups);
				if (empty($data->avatar) OR !is_file($data->avatar)) {
					$data->avatar = 'assets/img/default_avatar.jpg';
				}
				$return = $data;
			}
		}

		return $return;
	}
}

