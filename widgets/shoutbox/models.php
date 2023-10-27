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

namespace Belcms\Widgets\Models\Shoutbox;
use BelCMS\PDO\BDD as BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Models
{
	public function getMsg()
	{
		$nbpp = 10;

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit($nbpp);
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
		} else {
			$return = array();
		}
		return $return;
	}

	public function getsmiley ()
	{
		$sql = New BDD();
		$sql->table('TABLE_EMOTICONES');
		$sql->queryAll();
		return $sql->data;
	}
}
