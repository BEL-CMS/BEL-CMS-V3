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

namespace Belcms\Widgets\Models\lastConnected;
use BelCMS\PDO\BDD as BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Models
{
	public function getUsers($limit = 5)
	{
		$return = null;

		$sql = New BDD();
		$sql->table('TABLE_USERS_PAGE');
		$sql->orderby(array(array('name' => 'last_visit', 'type' => 'DESC')));
		$sql->fields(array('hash_key', 'namepage', 'last_visit'));
		$sql->limit($limit);
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
			/*
			foreach ($return as $k => $v) {
				$return[$k]->avatar = is_file($v->avatar) ? $v->avatar : 'assets/img/default_avatar.jpg';
			}
			*/
		}
		return $return;

	}
}
