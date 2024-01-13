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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common as Common;
use BelCMS\Core\Dispatcher;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Downloads
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_DOWNLOADS
	# TABLE_DOWNLOADS_CAT
	#####################################
	public function getCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_DOWNLOADS_CAT');

		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			return $sql->data;
		} else {
			$sql->queryAll();
			return $sql->data;
		}
	}

	public function getDls ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$config = Config::GetConfigPage('downloads');
			if (isset($config->config['MAX_DL'])) {
				$nbpp = (int) $config->config['MAX_DL'];
			} else {
				$nbpp = (int) 5;
			}

			$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS');
			$id = (int) $id;
			$where = array(
				'name' => 'idcat',
				'value' => $id
			);
			$sql->where($where);
			$sql->limit(array(0 => $page, 1 => $nbpp), true);
			$sql->queryAll();
			return $sql->data;
		}
	}

	public function getDlsDetail ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS');
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
	
			$sqlCat = New BDD();
			$sqlCat->table('TABLE_DOWNLOADS_CAT');
			$idCatwhere = array(
				'name' => 'id',
				'value' => $return->idcat
			);
			$sqlCat->where($idCatwhere);
			$sqlCat->queryOne();
			$returnCat = $sqlCat->data;

			if (Secures::isAcess($returnCat->id_groups) == true) {
				return $return;
			} else {
				return false;
			}
		}
	}

	public function ifAccess ($id)
	{
		if ($id !== null && is_numeric($id)) {
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS');
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;

			$sqlCat = New BDD();
			$sqlCat->table('TABLE_DOWNLOADS_CAT');
			$idCatwhere = array(
				'name' => 'id',
				'value' => $return->idcat
			);
			$sqlCat->where($idCatwhere);
			$sqlCat->queryOne();
			$returnCat = $sqlCat->data;

		}
		if (Secures::isAcess($returnCat->id_groups) == true) {
			return true;
		} else {
			return false;
		}
	}

	public function getDownloads ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			$sql = New BDD();
			$sql->table('TABLE_DOWNLOADS');
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;

			self::AddDownload($id);

			return $return->download;
		}
	}

	public function NewView ($id = false)
	{
		if ($id) {
			$id  = Common::secureRequest($id);
			$get = New BDD();
			$get->table('TABLE_DOWNLOADS');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			$data = $get->data;
			if ($get->rowCount != 0) {
				$count = (int) $data->view;
				$count++;
				$update = New BDD();
				$update->table('TABLE_DOWNLOADS');
				$update->where($where);
				$update->update(array('view' => $count));
			}
		}
	}

	public function AddDownload ($id = false)
	{
		if ($id) {
			$id  = Common::secureRequest($id);
			$get = New BDD();
			$get->table('TABLE_DOWNLOADS');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			$data = $get->data;
			if ($get->rowCount != 0) {
				$count = (int) $data->dls;
				$count++;
				$update = New BDD();
				$update->table('TABLE_DOWNLOADS');
				$update->where($where);
				$update->update(array('dls' => $count));
			}
		}
	}

	public function countFiles ($id)
	{
			$id  = Common::secureRequest($id);
			$get = New BDD();
			$get->table('TABLE_DOWNLOADS');
			$where = array(
				'name'  => 'idcat',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryAll();
			if ($get->rowCount != 0) {
				return (int) $get->rowCount;
			} else {
				return (int) 0;
			}
	}
}
