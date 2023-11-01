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

final class ModelsGallery
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_GALLERY
	# TABLE_GALLERY_CAT
	#####################################
	public function GetImg ()
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		$sql->queryAll();
		return $sql->data;
	}

	public function GetNameCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_CAT');

		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$where = array(
				'name' => 'cat',
				'value' => $id
			);
			$sql->where($where);
			if (!empty($this->data)){
				
			}
		}
	}
	public function sendadd ($data)
	{
		$insert['name']        = Common::SecureRequest($data['name']);
		$insert['description'] = Common::VarSecure($data['description'], 'html');
		$insert['uploader']    = $_SESSION['USER']['HASH_KEY'];
		if (isset($_FILES['image'])):
			$image = Common::Upload('image', 'uploads/gallery', array('.png', '.gif', '.jpg', '.jpeg', '.ico'));
			if ($image = UPLOAD_FILE_SUCCESS):
				$insert['image'] = 'uploads'.DS.'gallery'.DS.'image'.DS.$_FILES['image']['name'];
			endif;
		else:
			$return = array(
				'type' => 'error',
				'text' => 'Erreur de transfert'
			);
			return $return;
		endif;

		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		$sql->insert($insert);
		$sql->insert();

		$return = array(
			'type' => 'success',
			'text' => ADD_FILE_SUCCESS
		);
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
			$sql->where(array('name' => 'name', 'value' => 'gallery'));
			$sql->insert($upd);
			$sql->update();
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => EDIT_DL_PARAM_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => EDIT_DL_PARAM_ERROR
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

}