<?php
use BelCMS\Core\Dispatcher;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

use BelCMS\PDO\BDD;
use BelCMS\Core\Notification;
use BelCMS\User\User as Users;

class Maintenance
{
	public  	$status,
				$title,
				$description;

	function __construct ()
	{
		// Instance BDD;
		$sql = New BDD;
		$sql->table('TABLE_MAINTENANCE');
		$sql->queryAll();
		$mtn = $sql->data;
		// Crée un tableau
		foreach ($mtn as $v) {
			$this->{$v->name} = $v->value;
		}
	}

    public function status ()
    {
        return $this->status;
    }

    public function title ()
    {
        return $this->title;
    }

    public function description ()
    {
        return $this->description;
    }
}