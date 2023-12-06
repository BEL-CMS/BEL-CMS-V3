<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
final class ModelsMarket
{
	#########################################
	# Infos tables
	#########################################
	# TABLE_MARKET
	# TABLE_MARKET_CAT
	#########################################
	#########################################
	# Récupère toutes les ventes
	#########################################
	public function getBuy ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_MARKET');
		if ($id != null && is_numeric($id)):
			$where = array(
				'name'  => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
		else:
			$sql->queryAll();
		endif;
		if (!empty($sql->data)):
			return $sql->data;
		else:
			return array();
		endif;
	}
	#########################################
	# Récupère toutes les catégories
	#########################################
	public function sendEditBuy ($data)
	{
		if ($data['id'] != null && is_numeric($data['id'])):
			// SECURE DATA
			$send['name']        = Common::VarSecure($data['name'], ''); // autorise que du texte
			$send['description'] = Common::VarSecure($data['description'], 'html'); // autorise que les balises HTML
			$send['amount']      = isset($data['amount']) ? Secure::isString($data['amount']) : 0;
			$send['remaining']   = isset($data['remaining']) ? Secure::isString($data['remaining']) : 0;
			$send['cat']         = isset($data['cat']) ? Secure::isString($data['cat']) : null; 
			if (isset($_FILES['screen'])):
				$screen = Common::Upload('screen', 'uploads/market', array('.png', '.gif', '.jpg', '.jpeg'));
				if ($screen = UPLOAD_FILE_SUCCESS):
					$send['screen'] = 'uploads'.DS.'uploads/market'.DS.$_FILES['screen']['name'];
				endif;
			else:
				if (!empty($send['screen'])):
					$send['screen'] = $data['screen'];
				else:
					$send['screen'] = '';
				endif;
			endif;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_MARKET');
			$sql->insert($send);
			$where = array(
				'name'  => 'id',
				'value' => $data['id']
			);
			$sql->where($where);
			$sql->update();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1):
				$return = array(
					'type' => 'success',
					'text' => SEND_SUCCESS
				);
			else:
				$return = array(
					'type' => 'warning',
					'text' => SEND_ERROR
				);
			endif;
		else:
			$return = array(
				'type' => 'warning',
				'text' => ERROR_NO_DATA
			);
		endif;

		return $return;
	}
	#########################################
	# Récupère toutes les catégories
	#########################################
	public function getAllCat ()
	{
		$sql = New BDD();
		$sql->table('TABLE_MARKET_CAT');
		$sql->queryAll();
		return $sql->data;
	}
	#########################################
	# Ajoute une vente
	#########################################
	public function sendBuy ($data)
	{
		if ($data !== false) {
			// SECURE DATA
			$send['name']        = Common::VarSecure($data['name'], ''); // autorise que du texte
			$send['description'] = Common::VarSecure($data['description'], 'html'); // autorise que les balises HTML
			$send['amount']      = isset($data['amount']) ? Secure::isString($data['amount']) : 0;
			$send['remaining']   = isset($data['remaining']) ? Secure::isString($data['remaining']) : 0;
			if (isset($_FILES['screen'])) {
				$screen = Common::Upload('screen', 'uploads/market', array('.png', '.gif', '.jpg', '.jpeg'));
				if ($screen = UPLOAD_FILE_SUCCESS) {
					$send['screen'] = 'uploads'.DS.'uploads/market'.DS.$_FILES['screen']['name'];
				}
			} else {
				$send['screen'] = '';
			}
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_MARKET');
			$sql->insert($send);
			$sql->insert();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_ERROR
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
	#########################################
	# Ajoute une catégorie
	#########################################
	public function sendaddCat ($data)
	{
		$return = null;
		$send['name']        = Common::VarSecure($data['name'], ''); // autorise que du texte
		$data['groups']      = isset($data['groups']) ? $data['groups'] : array(1);
		$send['groups']      = implode("|", $data['groups']);
		if (is_array($data)):
			$sql = New BDD();
			$sql->table('TABLE_MARKET_CAT');
			$sql->insert($send);

			$return = array(
				'type' => 'success',
				'text' => ADD_CAT_SUCCESS
			);
		endif;
		return $return;
	}
	#########################################
	# Récupère toute les catégorie de la BDD
	#########################################
	public function getCat ($id = null)
	{
		if ($id != null && is_numeric($id)):
			$sql = New BDD();
			$sql->table('TABLE_MARKET_CAT');
			if ($id != null && is_numeric($id)):
				$where = array(
					'name'  => 'id',
					'value' => $id
				);
				$sql->where($where);
				$sql->queryOne();
			else:
				$sql->queryAll();
			endif;
			if (!empty($sql->data)):
				return $sql->data;
			else:
				return array();
			endif;
		endif;
	}
	#########################################
	# Efface une catégorie en BDD
	#########################################
	public function delcat ($data = null)
	{
		if ($data !== null && is_numeric($data)) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_MARKET_CAT');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => DEL_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => DEL_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => ERROR_NO_DATA
			);
		}
		return $return;
	}
	#########################################
	# Edit une catégorie en BDD
	#########################################
	public function sendeditcat ($data)
	{
		$id             = (int) $data['id'];
		$send['name']   = Common::VarSecure($data['name'], null);
		$send['groups'] = implode('|', $data['groups']);

		// SQL UPDATE
		$sql = New BDD();
		$sql->table('TABLE_MARKET_CAT');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->update($send);
		// SQL RETURN NB UPDATE == 1
		if ($sql->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => SEND_SUCCESS
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => DEL_ERROR
			);
		}

		return $return;
	}
}