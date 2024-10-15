<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
# TABLE_DONATIONS
# TABLE_DONATIONS_REVEIVE
# TABLE_PAYPAL
#####################################
final class ModelsDonations
{
	public function getDonates ()
	{
		$sql = New BDD();
		$sql->table('TABLE_DONATIONS_REVEIVE');
		$sql->queryAll();
		return $sql->data;
	}

	public function getEdit ($data)
	{
		$id = (int) $data;
		$sql = New BDD();
		$sql->table('TABLE_DONATIONS_REVEIVE');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		return $sql->data;
	}

	public function sendedit ($data)
	{
		$paypal = self::getPayPal();
		$number = is_numeric($data['number']) ? $data['number'].'&nbsp;'.$paypal[5]->value : $data['number'];
		$update['sold']  = $number;
		$update['valid'] = isset($data['active']) ? 1 : 0;
		$id = (int) $data['id'];
		$sql = New BDD();
		$sql->table('TABLE_DONATIONS_REVEIVE');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->update($update);
		if ($sql->rowCount == true) {
			$return = array(
				'type' => 'success',
				'text' => constant('EDIT_DON_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('EDIT_DON_WARNING')
			);	
		}
		return $return;
	}

	private function getPayPal ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAYPAL');
		$sql->queryAll();
		if (!empty($sql->data)) {
			return $sql->data;
		}
	}

	public function del ($id)
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_DONATIONS_REVEIVE');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->delete();
		if ($sql->rowCount == true) {
			$return = array(
				'type' => 'success',
				'text' => constant('DEL_DON_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('DEL_DON_WARNING')
			);	
		}
		return $return;
	}

	public function getAdress ()
	{
		$sql = New BDD();
		$sql->table('TABLE_DONATIONS');
		$sql->where(array('name' => 'id', 'value' => 1));
		$sql->queryOne();
		return $sql->data;
	}

	public function sendAdress ($data)
	{
		$update['name']      = Common::VarSecure($data['name'], null);
		$update['last_name'] = Common::VarSecure($data['last_name'], null);
		$update['adress']    = Common::VarSecure($data['adress'], null);
		$update['iban']      = Common::VarSecure($data['iban'], null); 
		$update['bic']       = Common::VarSecure($data['bic'], null);

		$sql = New BDD();
		$sql->table('TABLE_DONATIONS');
		$sql->where(array('name' => 'id', 'value' => 1));
		$sql->update($update);

		if ($sql->rowCount == true) {
			$return = array(
				'type' => 'success',
				'text' => constant('SEND_ADRESS_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('SEND_ADRESS_WARNING')
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
			$sql->where(array('name' => 'name', 'value' => 'donations'));
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