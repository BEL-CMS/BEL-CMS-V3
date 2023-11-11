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

use BelCMS\Requires\Common;
use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsComments
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_COMMENTS
	#####################################
	public function getAllComments ()
	{
		$sql = New BDD();
		$sql->table('TABLE_COMMENTS');
		$sql->queryAll();
		return $sql->data;
	}
	#####################################
	# Récupère tous les commentaires
	#####################################
	public function getComment($d)
	{
		$return = null;

		if (!empty($d) and is_numeric($d)):
			$where = (array('name' => 'id', 'value' => $d));
			$sql = New BDD();
			$sql->table('TABLE_COMMENTS');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;		
		endif;

		return $sql->data;
	}
	#####################################
	# Edition du commentaires en BDD [ID]
	#####################################
	public function sendedit ($d)
	{
		if (!empty($d['id']) and is_numeric($d['id'])):
			$send['comment'] = Common::VarSecure($d['comment'], 'html');
			$sql = New BDD();
			$sql->table('TABLE_COMMENTS');
			$sql->where(array('name' => 'id', 'value' => $d['id']));
			$sql->update($send);
			// SQL RETURN NB UPDATE == 1
			if ($sql->rowCount == 1):
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_EDIT_SUCCESS')
				);
			else:
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_EDIT_ERROR')
				);
			endif;
		else:
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_ID')
			);			
		endif;
		return $return;
	}
	#####################################
	# Suppression du commentaire en BDD [ID]
	#####################################
	public function del ($data = null)
	{
		if ($data !== null && is_numeric($data)) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_COMMENTS');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
}