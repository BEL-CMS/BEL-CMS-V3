<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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

final class ModelsDownloads
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_DOWNLOADS
	# TABLE_DOWNLOADS_CAT
	#####################################
	public function getAllDl ()
	{
		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS');
		$sql->queryAll();
		return $sql->data;
	}

	public function getDL ($id = null)
	{
		if ($id != null && is_numeric($id)) {
			$sql = New BDD;
			$sql->table('TABLE_DOWNLOADS');
			$where = (array('name' => 'id', 'value' => $id));
			$sql->where($where);
			$sql->queryOne();
			return $sql->data;
		} else {
			return (object) array();
		}
	}

	public function getCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS_CAT');
		if ($id != null && is_numeric($id)) {
			$where = array(
				'name'  => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryAll();
		} else {
			$sql->queryAll();
		}
		return $sql->data;
	}

	public function testName ($name)
	{
		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS_CAT');
		$where = array(
			'name'  => 'name',
			'value' => $name
		);
		$sql->where($where);
		$sql->queryAll();
		if ($sql->rowCount != 0) {
			return false;
		} else {
			return true;
		}
	}

	public function sendnewcat ($data)
	{
		if ($data !== false) {
			// SECURE DATA
			$send['name']        = Common::VarSecure($data['name'], ''); // autorise que du texte
			$send['description'] = Common::VarSecure($data['description'], 'html'); // autorise que les balises HTML
			$data['id_groups']   = isset($data['groups']) ? $data['groups'] : array(0 => 1);
			$send['id_groups']   = implode("|", $data['groups']);
			$send['banner']      = isset($data['banner']) ? $data['banner'] : null;
			$send['ico']         = isset($data['ico']) ? $data['ico'] : null;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS_CAT');
			$sql->insert($send);
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

	public function sendeditcat ($data)
	{
		$id                  = (int) $data['id'];
		$send['name']        = Common::VarSecure($data['name'], null);
		$send['description'] = Common::VarSecure($data['description'], 'html');
		$send['id_groups']   = isset($data['id_groups']) ? implode('|', $data['id_groups']) : 1;
		// SQL UPDATE
		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS_CAT');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->update($send);
		// SQL RETURN NB UPDATE == 1
		if ($sql->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => constant('SEND_EDITCAT_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('SEND_EDIT_ERROR')
			);
		}

		return $return;
	}

	public function delcat ($data = null)
	{
		if ($data !== null && is_numeric($data)) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS_CAT');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_CAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_CAT_ERROR')
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

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['MAX_DL']       = (int) $data['MAX_DL'];
			$opt                  = array('MAX_DL' => $data['MAX_DL']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'downloads'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_DL_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_DL_PARAM_ERROR')
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

	public function sendedit ($data)
	{
		$update['name']        = Common::SecureRequest($data['name']);
		$update['description'] = Common::VarSecure($data['description'], 'html');
		$update['idcat']       = (int) $data['idcat'];
		$id['id']              = (int) $data['id'];

		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS');
		$sql->where(array('name' => 'id', 'value' => $id['id']));
		$sql->update($update);

		$return = array(
			'type' => 'success',
			'text' => constant('EDIT_FILE_SUCCESS')
		);
		return $return;

	}

	public function sendadd ($data)
	{
		$insert['name']        = Common::SecureRequest($data['name']);
		$insert['description'] = Common::VarSecure($data['description'], 'html');
		$insert['idcat']       = (int) $data['idcat'];
		$insert['size']        = filesize($_FILES['download']['tmp_name']);
		$insert['uploader']    = $_SESSION['USER']->user->hash_key;
		$insert['ext']         = substr($_FILES['download']['name'], -3);
		$insert['view']        = 0;
		$insert['dls']         = 0;

		if (isset($_FILES['screen'])) {
			$screen = Common::Upload('screen', 'uploads/downloads'.DS.'screen', array('.png', '.gif', '.jpg', '.jpeg'));
			if ($screen = constant('UPLOAD_FILE_SUCCESS')) {
				$insert['screen'] = 'uploads/downloads/screen/'.$_FILES['screen']['name'];
			}
		} else {
			$insert['screen'] = '';
		}

		if (!empty($_FILES['download']['name'])) {
			Common::Upload('download', 'uploads/downloads',
			array(
				'.png', '.bmp', '.gif', '.jpg', '.ico', '.svg', '.tiff', '.webp', '.jpeg', '.doc', '.txt', '.pdf', '.rar',
				'.zip', '.7zip', '.exe', '.tar', '.psd', '.jar','.avi', '.mpg', '.mpeg', '.av4', '.ac3', '.docx', '.doc', '.mp3',
				'.mp4', '.svg', '.tif', '.tiff', '.txt', '.3gp', '.3g2', '.xml', '.xls', '.xlsx', '.ppt', '.pptx', '.pkg',
				'.iso', '.torrent', '.msi'
				));
			$insert['download'] = 'uploads/downloads/'.$_FILES['download']['name'];
		} else {
			$insert['download'] =  Secure::isUrl($data['url']) ? $data['url'] : '';
		}

		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS');
		$sql->insert($insert);

		$return = array(
			'type' => 'success',
			'text' => constant('ADD_FILE_SUCCESS')
		);
		return $return;
 	}

	public function del ($data = null)
	{
		if ($data !== null && is_numeric($data)) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_FILE_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_FILE_ERROR')
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