<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
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

#####################################
# Infos tables
#####################################
# TABLE_UPLOADS_ADMIN
#####################################
final class ModelsFiles
{
	#####################################
	# Répértoire des uploads
	#####################################
	public function index ()
	{
		$sql = new BDD;
		$sql->table('TABLE_UPLOADS_ADMIN');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
    # insert dans la BDD l'upload
	#####################################
	public function sendpost ($data)
	{
		$dir = ROOT.DS.'uploads'.DS.'files';

		$insert['name']    = $data['name'];
		$insert['uplaods'] = $_SESSION['USER']->user->hash_key;
		$insert['sub']     = $data['description'];

		if (!empty($_FILES['file']['name'])) {
			$upload = Common::Upload('file', $dir);
			$insert['file'] = '/uploads/files/'.$_FILES['file']['name'];
		}
		if ($upload == constant('UPLOAD_FILE_SUCCESS')) {
			$sql = new BDD;
			$sql->table('TABLE_UPLOADS_ADMIN');
			$sql->insert($insert);
			$return = array(
				'type' => 'success',
				'text' => constant('UPLOAD_FILE_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ERROR_UPLOAD')
			);
		}

		return $return;
	}
	#####################################
    # Supprime un fichier
	# de la base de donnée
	# et supprime du~FTP
	#####################################
	public function delete ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_UPLOADS_ADMIN');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$return = $sql->data;

		if (file_exists(ROOT.DS.$return->file)) {
			unlink(ROOT.DS.$return->file);
		}

		$sql = new BDD;
		$sql->table('TABLE_UPLOADS_ADMIN');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->delete();
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

		return $return;
	}
}