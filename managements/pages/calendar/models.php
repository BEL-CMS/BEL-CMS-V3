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
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_EVENTS');
			$sql->insert($send);
			$sql->insert();
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_NEWCAT_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_NEWCAT_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => ERROR_INSERT_BDD
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
					'text' => SEND_NEWCAT_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_NEWCAT_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => ERROR_NO_DATA
			);
		}

		return $return;
	}

	public function getEvents ()
	{
		$sql = New BDD();
		$sql->table('TABLE_EVENTS');
		$sql->isObject(false);
		$sql->queryAll();
		$events = array();
		debug($sql->data);
		foreach ($sql->data as $db_event) {
			$event = new stdClass();
			$event->title = $db_event['name'];
			$event->image = $db_event['image'];
			
			$event->day   = date('j', strtotime($db_event['start_date']));
			$event->month = date('n', strtotime($db_event['start_date']));
			$event->year  = date('Y', strtotime($db_event['start_date']));
			if (!$db_event['end_date'] || ($db_event['end_date'] == '0000-00-00')) {
				$event->duration = 1;	
			} else {
				if (date('Ymd', strtotime($db_event['start_date'])) == date('Ymd', strtotime($db_event['end_date']))) {
					$event->duration = 1;
				} else {
					$start_day = date('Y-m-d', strtotime($db_event['start_date']));
					$end_day = date('Y-m-d', strtotime($db_event['end_date']));
					$event->duration = ceil(abs(strtotime($end_day) - strtotime($start_day)) / 86400) + 1;
				}
			}
			$event->time        = $db_event['end_time'] ? $db_event['start_time'] . ' - ' . $db_event['end_time'] : $db_event['start_time'];
			$event->color       = $db_event['color'];
			$event->location    = $db_event['location'];
			$event->description = nl2br($db_event['description']);
			
			array_push($events, $event);
		}
		return;
	}
}