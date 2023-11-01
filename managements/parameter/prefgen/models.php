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

use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsPrefGen
{
	public function send ($data = null)
	{
		$data['cms_debug'] = isset($data['cms_debug']) ? 1 : 0;
		$data['cms_log']   = isset($data['cms_log']) ? 1 : 0;

		foreach ($data as $k => $v) {
			$sql = New BDD();
			$sql->table('TABLE_CONFIG');
			$sql->where(array('name'=>'name','value'=>strtoupper($k)));
			$sql->update(array('value' => $v));
			unset($sql);
		}

		$save = array(
			'type' => 'success',
			'text' => constant('SAVE_BDD_SUCCESS')
		);

		return $save;
	}
	public function getData ()
	{
		$return = (object) array();

		$sql = New BDD();
		$sql->table ('TABLE_CONFIG');
		$sql->orderby (array(array('name' => 'name', 'type' => 'ASC')));
		$sql->fields(array('name', 'value', 'editable'));
		$sql->queryAll();
		$data = $sql->data;
		foreach ($data as $a) {
			$return->{strtolower($a->name)} = (object) array('value' => $a->value, 'editable' => $a->editable);
		}
		foreach ($return as $a => $b) {
			$return->{$a}->editable = ($b->editable == '1') ? 'disabled' : '0';
		}
		return $return;
	}
}
