<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
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

final class Tickets
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_TICKETS
	# TABLE_TICKETS_CAT
	#####################################
	public function getCat () : array
	{
		$sql = new BDD;
		$sql->table('TABLE_TICKETS_CAT');
		$sql->queryAll();
		return $sql->data;
	}
	public function insert ($data) : array
	{
		$sql = new BDD;
		$sql->table('TABLE_TICKETS');
		$sql->insert($data);
		if ($sql->rowCount == true) {
			$return['text'] = constant('ADD_TICKET_OK');
			$return['type'] = 'success';
		} else {
			$return['text'] = constant('ADD_TICKET_NOK');
			$return['type'] = 'error'; 
		}
		return $return;
	}
}