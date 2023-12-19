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
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_MARKET');
			$where = array(
				'name'  => 'id',
				'value' => $data['id']
			);
			$sql->where($where);
			$sql->update($send);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1):
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			else:
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_ERROR')
				);
			endif;
		else:
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
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
			$send['author']      = $_SESSION['USER']->user->hash_key; 
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_MARKET');
			$sql->insert($send);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_ERROR')
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

	public function sendimg ($data = null) 
	{
		$dir = ROOT.'/uploads/market/'.$data.'/';
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('Failed to create directory');
			} else {
				$fopen  = fopen($dir.'/index.html', 'a+');
				fclose($fopen);
			}
		}
		$screen = Common::Upload('file', $dir, array('.png', '.gif', '.jpg', '.jpeg', '.ico','.PNG', '.GIF', '.JPG', '.JPEG', '.ICO'));

		if ($screen == constant('UPLOAD_FILE_SUCCESS')) {
			$dirPath = '/uploads/market/'.$data.'/'.$_FILES['file']['name'];
			$send['img']       = $dirPath;
			$send['id_market'] = $data;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_MARKET_IMG');
			$sql->insert($send);
			$return = constant('UPLOAD_FILE_SUCCESS');
		} else {
			$return = array('msg' => $screen);
		}

		return $return;
	}


	public function getImg ($id = null)
	{
		if ($id != null) {
			$sql = New BDD();
			$sql->table('TABLE_MARKET_IMG');
			$sql->fields(array('img'));
			$sql->where(array('name' => 'id_market', 'value' => $id));
			$sql->queryAll();
			return $sql->data;
		}
	}
	#########################################
	# Ajoute une catégorie
	#########################################
	public function sendaddCat ($data)
	{
		$return = null;
		$send['name']        = Common::VarSecure($data['name'], ''); // autorise que du texte
		$data['groups']      = isset($data['groups']) ? $data['groups'] : array(1);
		$send['user_groups'] = implode("|", $data['groups']);

		if (isset($_FILES['img'])) {
			$screen = Common::Upload('img', 'uploads/market/cat', array('.png', '.gif', '.jpg', '.jpeg', '.ico', '.bmp'));
			if ($screen == constant('UPLOAD_FILE_SUCCESS')) {
				$send['img'] = '/uploads/market/cat/'.$_FILES['img']['name'];
			}
		} else {
			$send['img'] = '';
		}

		if (is_array($data)):
			$sql = New BDD();
			$sql->table('TABLE_MARKET_CAT');
			$sql->insert($send);

			$return = array(
				'type' => 'success',
				'text' => constant('ADD_CAT_SUCCESS')
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
	#########################################
	# Edit une catégorie en BDD
	#########################################
	public function sendeditcat ($data)
	{
		$id                  = (int) $data['id'];
		$send['name']        = Common::VarSecure($data['name'], null);
		if (isset($data['groups']) and in_array(0, $data['groups'])) {
			$send['user_groups'] = 0;
		} else {
			if (isset($data['groups'])) {
				$send['user_groups'] = implode('|', $data['groups']);
				if (is_array($send['user_groups']) and !in_array('1', $send['user_groups'])) {
					$send['user_groups'] = '1|'.$send['user_groups']; 
				} else {
					$send['user_groups'] = 1;
				}
			} else {
				$send['user_groups'] = 1;
			}
		}

		if ($_FILES['img']['error'] == 0) {
			Common::Upload('img', 'uploads/market/cat', array('.png', '.gif', '.jpg', '.jpeg', '.ico', '.bmp'));
			$send['img'] = '/uploads/market/cat/'.$_FILES['img']['name'];
		}

		// SQL UPDATE
		$sql = New BDD();
		$sql->table('TABLE_MARKET_CAT');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->update($send);
		// SQL RETURN NB UPDATE == 1
		if ($sql->rowCount == true) {
			$return = array(
				'type' => 'success',
				'text' => constant('EDIT_PARAM_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('SEND_BDD_PARTIEL')
			);
		}

		return $return;
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['NB_BUY']       = (int) $data['NB_BUY'];
			$opt                  = array('NB_BUY' => $data['NB_BUY']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'market'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_PARAM_SUCCESS')
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
				'text' => constant('DEL_BDD_ERROR')
			);
		}
		return $return;
	}

	public function getDiscount ()
	{
		$sql = New BDD();
		$sql->table('TABLE_MARKET_SOLD');
		$sql->queryAll();
		return $sql->data;
	}

	public function sendaddDiscount ($data)
	{
		if (empty($data['code']) and empty($data['auto_code'])) {
			$return = array(
				'type' => 'warning',
				'text' => constant('CODE_ERROR')
			);
			return $return;
		}
		if (!empty($data['code']) or !empty($data['auto_code'])) {
			$update['price'] = !empty($data['code']) ? $data['price'] : 0;
		}
		$update['code'] = empty($data['auto_code']) ? $data['code'] : $data['auto_code'];
		if (!empty($data['date_of_finish'])) {
			$update['date_of_finish'] = $data['date_of_finish']; 
		}
		$update['number'] = (int) $data['number'];
		$update['infinite_date'] = $data['infinite_date'];
		$update['comments'] = Common::VarSecure($data['comments'], null);

		$sql = New BDD();
		$sql->table('TABLE_MARKET_SOLD');
		$sql->insert($update);
		if ($sql->rowCount == 1) {
			$return = array(
				'type' => 'success',
				'text' => constant('SEND_SOLD_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('SEND_SOLD_ERROR')
			);
		}
		return $return;
	}

	public function editDiscount ($id = null)
	{
		if ($id != null and is_int($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_MARKET_SOLD');
			$sql->where($where);
			$sql->queryOne();
			return $sql->data;	
		}
	}

	public function sendEditDiscount ($data = null)
	{
		if (is_array($data)) {
			if (empty($data['code']) and empty($data['auto_code'])) {
				$return = array(
					'type' => 'warning',
					'text' => constant('CODE_ERROR')
				);
				return $return;
			}	
			if (!empty($data['code']) or !empty($data['auto_code'])) {
				$update['price'] = !empty($data['code']) ? $data['price'] : 0;
			}
			$update['code'] = empty($data['auto_code']) ? $data['code'] : $data['auto_code'];
			if (!empty($data['date_of_finish'])) {
				$update['date_of_finish'] = $data['date_of_finish']; 
			}
			$update['number'] = (int) $data['number'];
			$update['infinite_date'] = $data['infinite_date'];
			$update['comments'] = Common::VarSecure($data['comments'], null);

			$where = array('name' => 'id', 'value' => $data['id']);
			$sql = New BDD();
			$sql->table('TABLE_MARKET_SOLD');
			$sql->where($where);
			$sql->update($update);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SOLD_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_SOLD_ERROR')
				);
			}
			return $return;
		}
	}

	public function sendDelDiscount ($id = null)
	{
		if ($id !== null && is_numeric($id)) {
			// SECURE DATA
			$delete = (int) $id;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_MARKET_SOLD');
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

	public function getPayment ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PURCHASE');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryAll();
		return $sql->data;
	}
}