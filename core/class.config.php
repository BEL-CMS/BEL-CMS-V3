<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Config
{
	public 	$return,
			$access_groups,
			$access_admin;

	public static function GetConfigPage ($page = null)
	{
		$return = null;

		if ($page != null) {
			$page = strtolower(trim(strtolower($page)));
			$sql = New BDD;
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => $page));
			$sql->queryOne();
			$return = $sql->data;
			$return->access_groups = explode('|', $return->access_groups);
			$return->access_admin  = explode('|', $return->access_admin);
			if (!empty($return->config)) {
				$return->config = Common::transformOpt($return->config);
			} else {
				$return->config = (object) array();
			}
		}

		return $return;
	}

	public static function GetConfigWidgets ($widget = null)
	{
		$return = null;

		if ($widget != null) {
			$widget = trim(strtolower($widget));
			$sql = New BDD;
			$sql->table('TABLE_WIDGETS');
			$sql->where(array('name' => 'name', 'value' => $widget));
			$sql->queryOne();
			$return = $sql->data;
			if (strpos($return->groups_access, '|') !== false) {
				$return->groups_access = explode('|', $return->groups_access);
			} else {
				$return->groups_access = array(0, $return->groups_access);
			}
			$return->groups_admin  = explode('|', $return->groups_admin);
			$return->opttions      = Common::transformOpt($return->opttions);
			$return->pages  = explode('|', $return->pages);
			if (!empty($return->config)) {
				$return->config = Common::transformOpt($return->config);
			} else {
				$return->config = (object) array();
			}
		}

		return $return;
	}

	public static function getGroups ($true = false)
	{
		$return = (object) array();

		$sql = New BDD;
		$sql->table('TABLE_GROUPS');
		$sql->fields(array('id', 'name', 'id_group', 'color', 'image'));
		$sql->queryAll();

		foreach ($sql->data as $k => $v) {
			$a = defined(strtoupper($v->name)) ? constant(strtoupper($v->name)) : ucfirst(strtolower($v->name));
			if ($true == false) {
				$a = defined(strtoupper($v->name)) ? constant(strtoupper($v->name)) : ucfirst(strtolower($v->name));
				$return->$a = array('id' => $v->id_group, 'color' => $v->color, 'image' => $v->image);
			} else {
				$a = defined(strtoupper($v->name)) ? constant(strtoupper($v->name)) : ucfirst(strtolower($v->name));
				$return->{$v->id} = array('name' => $a, 'color' => $v->color, 'image' => $v->image);
			}

		}

		return $return;
	}

	public static function getGroupsForID ($id = null)
	{
		if ($id == 0) {
			return (object) array(
				'name'     => constant('VISITORS'),
				'id_group' => 0,
				'image'    => '',
				'color'    => ''
			);
		}
		$id = (int) $id;
		$return = constant('UNKNOWN');
		$sql = New BDD;
		$sql->where(array('name' => 'id_group', 'value' => $id));
		$sql->table('TABLE_GROUPS');
		$sql->fields(array('name', 'id_group', 'color', 'image'));
		$sql->queryOne();
		if (!empty($sql->data)) {
			$return = $sql->data;
		}
		return $return;
	}
}