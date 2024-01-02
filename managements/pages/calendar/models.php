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
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsCalendar
{
	#####################################
	# Infos tables
	#####################################
	#####################################
	# TABLE_EVENTS
	# TABLE_EVENTS_CAT
	#####################################
	public function sendadd ($data = null)
	{
		if ($data !== false) {
			// SECURE DATA
			$send['name']        = Common::VarSecure($data['name'], '');
			$send['color']       = Common::VarSecure($data['color']);
			$send['start_date']  = Common::DatetimeReverse($data['start_date']);
			$send['end_date']    = Common::DatetimeReverse($data['end_date']);
			$send['start_time']  = Common::VarSecure($data['start_time']);
			$send['end_time']    = Common::VarSecure($data['end_time']);
			$send['location']    = Common::VarSecure($data['location'], '');
			$send['description'] = Common::VarSecure($data['description'], 'html');

			if (isset($_FILES['image'])) {
				$screen = Common::Upload('image', 'uploads/events', array('.png', '.gif', '.jpg', '.jpeg'));
				if ($screen = constant('UPLOAD_FILE_SUCCESS')) {
					$send['image'] = 'uploads/events/'.$_FILES['image']['name'];
				}
			} else {
				$send['image'] = '';
			}

			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_EVENTS');
			$sql->insert($send);
			$sql->insert();
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_NEWCAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_NEWCAT_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ERROR_INSERT_BDD')
			);
		}

		return $return;
	}

	public function sendnewcat ($data)
	{
		if ($data !== false) {
			// SECURE DATA
			$send['name']  = Common::VarSecure($data['name'], '');
			$send['color'] = Common::VarSecure($data['color']);
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_EVENTS_CAT');
			$sql->insert($send);
			$sql->insert();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_NEWCAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_NEWCAT_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}

		return $return;
	}

	public function getEvents ()
	{
		$sql = New BDD();
		$sql->table('TABLE_EVENTS');
		$sql->queryAll();
		return $sql->data;
	}

	public function getEdit ($id)
	{
		$sql = New BDD();
		$sql->table('TABLE_EVENTS');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		return $sql->data;
	}

	public function sendedit ($data)
	{
		if (is_array($data)) {
			$update['name']        = Common::VarSecure($data['name'], null);
			$update['color']       = Common::VarSecure($data['color']);
			$update['start_date']  = Common::DatetimeReverse($data['start_date']);
			$update['end_date']    = Common::DatetimeReverse($data['end_date']);
			$update['start_time']  = Common::VarSecure($data['start_time']);
			$update['end_time']    = Common::VarSecure($data['end_time']);
			$update['location']    = Common::VarSecure($data['location'], '');
			$update['description'] = Common::VarSecure($data['description'], 'html'); 
			$id = (int) $data['id'];
			$sql = New BDD();
			$sql->table('TABLE_EVENTS');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($update);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_EDIT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_BDD_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}

	public function del ($id)
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_EVENTS');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->delete();
		if ($sql->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => constant('DEL_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('DEL_BDD_ERROR')
			);
		}
		return $return;
	}
}