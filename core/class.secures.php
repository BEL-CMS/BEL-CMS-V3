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

namespace BelCMS\Core;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;
use BelCMS\User\User as Users;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Secures
{
	#########################################
	# Accès au page via les groupes
	#########################################
	public static function getAccessPage ($page = null)
	{
		if ($page === null) {
			return false;
		} else {
			$bdd = self::accessSqlPages($page);
			if (isset($bdd[$page]->access_groups)) {
				if (in_array(0, $bdd[$page]->access_groups)) {
					return true;
				} else {
					if (Users::isLogged()) {
						foreach ($bdd[$page]->access_groups as $k => $v) {
							$user = self::accessSqlUser();
							$access = $user->access ? $user->access : array(0);
							if (in_array(1, $access)) {
								return true;
							}
							if (in_array($v, $access)) {
								return true;
							} else {
								return false;
							}
						}
					}
				}
			} else {
				return true;
			}
		}
	}
	#########################################
	# Accès au widgets via les groupes
	#########################################
	public static function getAccessWidgets ($Widget = null)
	{
		if ($Widget === null) {
			return false;
		} else {
			$bdd = self::accessSqlWidget($Widget);
			if (in_array(0, $bdd[$Widget]->groups_access)) {
				return true;
			} else {
				foreach ($bdd[$Widget]->groups_access as $k => $v) {
					$user   = self::accessSqlUser();
					$user   = $user[$_SESSION['USER']->user->hash_key];
					$access = $user->access;
					if (isset($_SESSION['USER']->user->hash_key) && strlen($_SESSION['USER']->user->hash_key) == 32) {
						if (in_array($v, $access)) {
							return true;
						} else {
							return false;
						}
					} else {
						return false;
					}
				}
			}
		}
	}
	#########################################
	# Accès aux page si activer
	#########################################
	public static function getPageActive ($page) 
	{
		$bdd = self::accessSqlPages($page);
		if (isset($bdd[$page]->active)) {
			if ($bdd[$page]->active == 1) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	#########################################
	# Accès aux widgets si activer
	#########################################
	public static function getwidgetsActive ($widgets) 
	{
		$bdd = self::accessSqlWidget($widgets);
		if ($bdd[$widgets]->active == 1) {
			return true;
		} else {
			return false;
		}
	}
	#########################################
	# BDD Complet de la page demandé
	#########################################
	public static function accessSqlPages ($name)
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_CONFIG');
		$sql->where(array('name' => 'name', 'value' => $name));
		$sql->queryAll();
		if (empty($sql->data)) {
			$return = false;
		} else {
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$v->name] = $v;
				$return[$v->name]->access_groups = explode('|', $return[$v->name]->access_groups);
				$return[$v->name]->access_admin  = explode('|', $return[$v->name]->access_admin);
				if (!empty($v->config)) {
					$return[$v->name]->config = Common::transformOpt($return[$v->name]->config);
				} else {
					unset($return[$v->name]->config);
				}
				unset($return[$k], $return[$v->name]->name);
			}
		}
		return $return;
	}
	#########################################
	# BDD Complet du widget demandé
	#########################################
	public static function accessSqlWidget ($name)
	{
		$sql = New BDD();
		$sql->table('TABLE_WIDGETS');
		$sql->where(array('name' => 'name', 'value' => $name));
		$sql->queryAll();
		if (empty($sql->data)) {
			$return = false;
		} else {
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$v->name] = $v;
				$return[$v->name]->groups_access = explode('|', $return[$v->name]->groups_access);
				$return[$v->name]->groups_admin  = explode('|', $return[$v->name]->groups_admin);
				unset($return[$k], $return[$v->name]->name);
			}
		}
		return $return;
	}
	#########################################
	# Accès uniquement aux groupes et au 
	# groupe principal (assemblé) 
	# securisé par le hash_key
	# * A delete groupe repris dans la $_SESSION['USER']
	#########################################
	public static function accessSqlUser ()
	{
		if (Users::isLogged()) {
			if (isset($_SESSION['USER']->user->hash_key) and strlen($_SESSION['USER']->user->hash_key) == 32) {
				$user = Users::getInfosUserAll($_SESSION['USER']->user->hash_key);
				$return = new \stdClass();
				$return->access = $user->groups->all_groups;
			} else {
				return false;
			}
		}
		return $return;
	}
	#########################################
	# retourne tout les groupes
	# et possible de retourné un seul
	#########################################
	public static function getGroups ($group = null) : array
	{
		$sql = New BDD;
		$sql->table('TABLE_GROUPS');
		$sql->fields(array('name', 'id_group'));
		$sql->queryAll();
		$data = $sql->data;

		if ($group != null) {
            $return = null;
			return $return[$group];
		} else {
			foreach ($data as $k => $v) {
				$return[$v->id_group] = $v->name;
			}
			return $return;
		}
	}

	public static function IsAcess ($data = null) : bool
	{
		$return = (bool) false;

		if ($data == null or $data == 0) {
			return (bool) true;
		}

		$g = explode('|', $data);
		if (in_array(0, $g)) {
			return (bool) true;
		}

		if (Users::isLogged()) {
			// Accès à tout au groupe n°1 (Admin)
			if (in_array(1, $_SESSION['USER']->groups->all_groups)) {
				return true;
			} else {
				if (in_array($data, $_SESSION['USER']->groups->all_groups)) {
					return true;
				}
			}
		} else {
			return (bool) false;
		}
		return $return;
	}
}