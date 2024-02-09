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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Teams
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_TEAM
	# TABLE_TEAM_USERS
	#####################################
	# récupère les teams
	#####################################
	public function getTeam ()
	{
		$sql = New BDD();
		$sql->table('TABLE_TEAM');
		$sql->orderby(array(array('name' => 'orderby', 'type' => 'DESC')));
		$sql->queryAll();
		foreach ($sql->data as $k => $v) {
			$sql->data[$k]->user = self::getUsersTeam($v->id);
		}
		return $sql->data;
	}
	#####################################
	# récupère les joueurs de la team
	#####################################
	public function getUsersTeam ($id)
	{
		$id = (int) $id;

		$sql = New BDD();
		$sql->table('TABLE_TEAM_USERS');
		$where = array(
			'name' => 'teamid',
			'value' => $id
		);
		$sql->where($where);
		$sql->queryAll();

		return $sql->data;
	}

}