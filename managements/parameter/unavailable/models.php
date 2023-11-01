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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsUnavailable
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_MAINTENANCE
	#####################################
	public function getMaintenance ()
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_MAINTENANCE');
		$sql->queryAll();

		if ($sql->data) {
			foreach ($sql->data  as $k => $v) {
				$return[$v->name] = $v->value;
			}
		}

		return $return;
	}

	public function openClose ($data)
	{
		if (isset($data["close"]) && ($data["close"] == 'open')) {
			$edit = 'open';
		} else {
			$edit = 'close';
		}
		// SQL UPDATE
		$sql = New BDD();
		$sql->table('TABLE_MAINTENANCE');
		$sql->where(array('name' => 'id', 'value' => 1));
		$sql->update(array('value' => $edit));

		// SQL RETURN NB UPDATE
		if ($sql->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => EDIT_CLOSE_SUCCESS
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => EDIT_CLOSE_ERROR
			);
		}

		return $return;
	}

	public function sendpost ($data)
	{
		$title = Common::VarSecure($data["title"], '');
		$description = Common::VarSecure($data['description'], 'html');
		// SQL UPDATE

		$te = New BDD();
		$te->table('TABLE_MAINTENANCE');
		$te->where(array('name' => 'id', 'value' => 2));
		$te->update(array('value' => $title));

		$desc = New BDD();
		$desc->table('TABLE_MAINTENANCE');
		$desc->where(array('name' => 'id', 'value' => 3));
		$desc->update(array('value' => $description));

		// SQL RETURN NB UPDATE
		if ($desc->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => EDIT_CLOSE_SUCCESS
			);
		} else {
			$return = array(
				'type' => 'error',
				'text' => EDIT_CLOSE_ERROR
			);
		}

		return $return;
	}
}