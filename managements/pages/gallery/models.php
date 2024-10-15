<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsGallery
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_GALLERY
	# TABLE_GALLERY_CAT
	# TABLE_GALLERY_VALID
	# TABLE_GALLERY_SUB_CAT
	#####################################
	public function getImg ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		if ($id === null) {
			$sql->queryAll();
			if (!empty($sql->data)) {
				$data = $sql->data;
				foreach ($data as $key => $value) {
					if (!empty($value->cat)) {
						$data[$key]->cat = self::GetNameSubCat($value->cat)->name;
					}
				}
				return $data;
			}
		} else if (is_integer($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			if (!empty($sql->data)) {
				$data = $sql->data;
			}
			return $data;
		}
	}

	public function GetNameCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_CAT');

		if ($id !== null) {
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			if (!empty($sql->data)){
				return $sql->data;
			}
		} elseif ($id == null) {
			$sql->queryAll();
			return $sql->data;
		}
	}

	public function GetAllCat ()
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_CAT');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}

	public function GetNameSubCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_SUB_CAT');

		if ($id !== null) {
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			if (!empty($sql->data)){
				return $sql->data;
			}
		} elseif ($id == null) {
			$sql->queryAll();
			return $sql->data;
		}
	}

	public function sendEdit ($data)
	{
		if (is_array($data)) {
			$id = (int) $data['id'];
			if (isset($_FILES['image'])):
				$image = Common::Upload('image', 'uploads/gallery', array('.png', '.gif', '.jpg', '.jpeg', '.ico'));
				if ($image == constant('UPLOAD_FILE_SUCCESS')):
					$update['image'] = 'uploads/gallery/tmp/'.$_FILES['image']['name'];
					@unlink(ROOT.DS.$data['remove']);
				endif;
			endif;
			$update['cat']  = Common::VarSecure($data['cat'], null);
			$update['name'] = Common::VarSecure($data['name'], null);
			$sql = New BDD();
			$sql->table('TABLE_GALLERY');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($update);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDITING_SUCCESS')
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
				'text' => constant('ERROR_NO_DATA')
			);	
		}
		return $return;
	}

	public function sendDel ($id)
	{
		$id = (int) $id;
		// Retire l'image du FTP
		$remove = self::getImg($id);
		@unlink(ROOT.DS.$remove->image);
		// SQL DELETE
		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		$sql->where(array('name'=>'id','value' => $id));
		$sql->delete();
		// SQL RETURN NB DELETE
		if ($sql->rowCount == true) {
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
		return $return;
	}

	public function sendAddCat ($data)
	{
		if (is_array($data)) {
			if (isset($_FILES['banner'])):
				$image = Common::Upload('banner', 'uploads/gallery/cat', array('.png', '.gif', '.jpg', '.jpeg', '.ico'));
				if ($image == constant('UPLOAD_FILE_SUCCESS')):
					$insert['banner'] = '/uploads/gallery/cat/'.$_FILES['banner']['name'];
				endif;
			endif;
			$insert['name']  = Common::VarSecure($data['name'], null);
			$insert['color'] = Common::VarSecure($data['color'], null);
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_CAT');
			$sql->insert($insert);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('ADD_FILE_SUCCESS')
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
				'text' => constant('ERROR_NO_DATA')
			);	
		}
		return $return;
	}

	public function sendAddSubCat ($data)
	{
		if (is_array($data)) {
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_SUB_CAT');
			$sql->insert($data);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('ADD_FILE_SUCCESS')
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
				'text' => constant('ERROR_NO_DATA')
			);	
		}
		return $return;
	}

	public function sendEditCat ($data)
	{
		if (is_array($data)) {
			$id = (int) $data['id'];
			if (isset($_FILES['image'])):
				$image = Common::Upload('image', 'uploads/gallery/cat', array('.png', '.gif', '.jpg', '.jpeg', '.ico'));
				if ($image == constant('UPLOAD_FILE_SUCCESS')):
					$update['banner'] = '/uploads/gallery/cat/'.$_FILES['image']['name'];
					if (file_exists(ROOT.DS.$data['remove'])) {
						@unlink(ROOT.DS.$data['remove']);
					}
				endif;
			endif;
			$update['name'] = Common::VarSecure($data['name'], null);
			$update['color'] = Common::VarSecure($data['color'], null);
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_CAT');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($update);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDITING_SUCCESS')
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
				'text' => constant('ERROR_NO_DATA')
			);	
		}
		return $return;
	}

	public function delcat ($id)
	{
		if ($id !== null && is_numeric($id)) {
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_CAT');
			$sql->where(array('name'=>'id','value' => $id));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == true) {
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

	public function sendadd ($data)
	{
		$insert['name']        = Common::SecureRequest($data['name']);
		$insert['description'] = Common::VarSecure($data['description'], 'html');
		$insert['uploader']    = $_SESSION['USER']->user->hash_key;
		$insert['cat']         = Common::VarSecure($data['cat'], null);
		if (isset($_FILES['image'])) {
			$image = Common::Upload('image', 'uploads/gallery', array('.png', '.gif', '.jpg', '.jpeg', '.ico'));
			if ($image == constant('UPLOAD_FILE_SUCCESS')):
				$insert['image'] = '/uploads/gallery/'.$_FILES['image']['name'];
			endif;
		} else {
			$return = array(
				'type' => 'error',
				'text' => 'Erreur de transfert'
			);
			return $return;
		}

		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		$sql->insert($insert);

		$return = array(
			'type' => 'success',
			'text' => constant('ADD_FILE_SUCCESS')
		);
		return $return;
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['MAX_IMG']      = (int) $data['MAX_IMG'];
			$opt                  = array('MAX_IMG' => $data['MAX_IMG']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'gallery'));
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

	public function delsubcat ($id)
	{
		if ($id !== null && is_numeric($id)) {
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_SUB_CAT');
			$sql->where(array('name'=>'id','value' => $id));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == true) {
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

	public function sendEditSubCat($data, $id)
	{
		if (is_array($data)) {
			$sql = New BDD();
			$sql->table('TABLE_GALLERY_SUB_CAT');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($data);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDITING_SUCCESS')
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
				'text' => constant('ERROR_NO_DATA')
			);	
		}
		return $return;
	}

	public function getNoValid ()
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY_VALID');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	
	public function deleteAll ()
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY_VALID');
		$sql->delete();
		$return = array(
			'type' => 'success',
			'text' => constant('DELETE_SUCCESS')
		);

		$dir = ROOT.DS.'/uploads/gallery/tmp/';
		Common::deleteFiles($dir);

		return $return;
	}

	public function getTmpID ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY_VALID');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}

	public function accept ($data, $id)
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY');
		$sql->insert($data);

		$delete = new BDD;
		$delete->table('TABLE_GALLERY_VALID');
		$delete->where(array('name' => 'id', 'value' => $id));
		$delete->delete();

		$return = array(
			'type' => 'success',
			'text' => constant('DEPLACE_ACTIF')
		);
		return $return;
	}
}