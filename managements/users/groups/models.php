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

use BelCMS\Requires\Common;
use BelCMS\PDO\BDD;

#   TABLE_GROUPS
#-> id, name, id_group
final class ModelGroups
{
	public function sendnew ($data)
	{
		if (empty($data['name'])) {
			$return['text']  = constant('GROUP_NAME_EMPTY');
			$return['type']  = 'warning';
			return $return;
		}

		$dir = ROOT.DS.'uploads'.DS.'groups'.DS;
		$dirWeb = '/uploads/groups/';

		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
			$fopen  = fopen($dir.'index.html', 'a+');
			fclose($fopen);
		}

		$extensions = array('.png', '.gif', '.jpg', '.ico', '.jpeg');
		if (isset($_FILES['image']['name']) AND !empty($_FILES['image']['name'])) {
			Common::Upload('image', $dir, $extensions);
			$d['image'] = $dirWeb.$_FILES['image']['name'];
		}

		$test = New BDD();
		$test->table('TABLE_GROUPS');
		$test->where(array('name' => 'name', 'value' => $data['name']));
		$test->count();
		$returnCheckName = (int) $test->data;
		if ($returnCheckName >= 1) {
			$return['text']  = constant('GROUP_NAME_RESERVED');
			$return['type']  = 'warning';
			return $return;
		}

		$sql = New BDD();
		$sql->table('TABLE_GROUPS');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryOne();
		$lastid = $sql->data->id_group +1;

		$insert = New BDD();
		$insert->table('TABLE_GROUPS');
		$d['name']     = Common::VarSecure($data['name']);
		$d['color']    = Common::VarSecure($data['color']);
		$d['id_group'] = Common::SecureRequest($lastid);
		$insert->insert($d);
		# check insert new group
		if ($insert->rowCount == 1) {
			$return['text']	= constant('GROUP_SEND_SUCCESS');
			$return['type']	= 'success';
		} else {
			$return['text']	= constant('GROUP_ERROR_SUCCESS');
			$return['type']	= 'error';
		}
		return $return;
	}

	public function delete ($id)
	{
		if (is_numeric($id)) {
			// SECURE DATA
			$id = (int) $id;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_GROUPS');
			$sql->where(array('name'=>'id_group','value' => $id));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_GROUP_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_GROUP_ERROR')
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
	public function edit ($id)
	{
		$sql = New BDD();
		$sql->table('TABLE_GROUPS');
		$sql->where(array('name' => 'id_group', 'value' => $id));
		$sql->queryOne();

		return $sql->data;
	}

	public function sendedit ()
	{
		$dir = ROOT.DS.'uploads'.DS.'groups'.DS;
		$dirWeb = '/uploads/groups/';

		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
			$fopen  = fopen($dir.'index.html', 'a+');
			fclose($fopen);
		}

		$extensions = array('.png', '.gif', '.jpg', '.ico', '.jpeg');
		if (!empty($_FILES['image'])) {
			Common::Upload('image', $dir, $extensions);
		}

		$d['image'] = $dirWeb.$_FILES['image']['name'];

		$s = New BDD;
		$s->table('TABLE_GROUPS');
		$s->where(array('name' => 'id_group','value' => $_POST['id']));
		if ($_POST['id'] != 1 AND $_POST['id'] != 2) {
			$d['name']  = Common::VarSecure($_POST['name']);
		}
		$d['color'] = Common::VarSecure($_POST['color']);
		$s->update($d);

		// SQL RETURN NB DELETE
		if ($s->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => constant('EDIT_GROUP_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('EDIT_GROUP_ERROR')
			);
		}
		return $return;
	}
}