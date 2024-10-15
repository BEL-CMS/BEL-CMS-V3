<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsFAQ
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_FAQ
	# TABLE_FAQ_CAT
	#####################################
	public function getFAQ ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_FAQ');

		if ($id !== null and is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			if (!empty($sql->data)) {
				$sql->data->namecat = self::getNameCat($sql->data->id_cat);
			}
			return $sql->data;
		} else {
			$sql->queryAll();
			if (!empty($sql->data)) {
				foreach ($sql->data as $k => $v) {
					$sql->data[$k]->namecat = self::getNameCat($v->id_cat);
				}
			}
			return $sql->data;   
		}
	}

	private function getNameCat ($id = null)
	{
		if ($id !== null and is_numeric($id)) {
			$sql = new BDD();
			$sql->table('TABLE_FAQ_CAT');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			return $return->name;
		}
	}

	public function getCat ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_FAQ_CAT');

		if ($id !== null and is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			return $return;
		} else {
			$sql->queryAll();
			$return = $sql->data;
			return $return;
		}
	}

	public function sendQuest ($data = null)
	{
		if ($data !== null and is_array($data)) {

			$insert['name']    = Common::VarSecure($data['name'], null);
			$insert['content'] = Common::VarSecure($data['content'], 'html');
			$insert['id_cat']  = (int) $data['idcat'];
			$insert['publish'] = $_SESSION['USER']->user->hash_key;

			$sql = New BDD();
			$sql->table('TABLE_FAQ');
			$sql->insert($insert);

			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_BDD_PARTIEL')
				);	
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);	
		}
		return $return;
	}

	public function sendEdit ($data = null)
	{
		if ($data !== null and is_array($data) and is_numeric($data['id'])) {
			$update['name']    = Common::VarSecure($data['name'], null);
			$update['content'] = Common::VarSecure($data['content'], 'html');
			$update['id_cat']  = (int) $data['idcat'];

			$sql = New BDD();
			$sql->table('TABLE_FAQ');
			$sql->where(array('name' => 'id', 'value' => $data['id']));
			$sql->update($update);

			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_BDD_PARTIEL')
				);	
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);	
		}
		return $return;
	}

	public function sendAddCat ($data = null)
	{
		if ($data !== null and !empty($data['name'])) {
			$insert['name'] = Common::VarSecure($data['name'], null);

			$sql = New BDD();
			$sql->table('TABLE_FAQ_CAT');
			$sql->insert($insert);

			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_BDD_PARTIEL')
				);	
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('EMPTY_NAME')
			);	
		}
		return $return;
	}

	public function sendEditCat ($data)
	{
		if ($data !== null and !empty($data['name']) and is_numeric($data['id'])) {
			$update['name'] = Common::VarSecure($data['name'], null);

			$sql = New BDD();
			$sql->table('TABLE_FAQ_CAT');
			$sql->where(array('name' => 'id', 'value' => $data['id']));
			$sql->update($update);

			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_EDIT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_ERROR')
				);	
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('EMPTY_NAME_OR_ID')
			);	
		}
		return $return;
	}

	public function sendDel($id = null)
	{
		if ($id !== null and is_numeric($id)) {
			$del = New BDD();
			$del->table('TABLE_FAQ');
			$del->where(array('name' => 'id', 'value' => $id));
			$del->delete();
			if ($del->rowCount == true) {
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
				'text' => constant('ID_ERROR')
			);	
		}
		return $return;
	}

	public function sendDelCat ($id = null)
	{
		if ($id !== null and is_numeric($id)) {

			$sql = New BDD();
			$sql->table('TABLE_FAQ_CAT');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->delete();

			if ($sql->rowCount == true) {

				$del = New BDD();
				$del->table('TABLE_FAQ');
				$del->where(array('name' => 'id_cat', 'value' => $id));
				$del->delete();

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
				'text' => constant('ID_ERROR')
			);	
		}
		return $return;
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'faq'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('PARAMETER_EDITING_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_PARAM_ERROR')
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
}