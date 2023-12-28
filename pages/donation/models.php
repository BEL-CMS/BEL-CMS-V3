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

namespace Belcms\Pages\Models;
use BelCMS\Core\Secure;
use BelCMS\PDO\BDD as BDD;
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
final class Donation
{
	public function getPayPal ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAYPAL');
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $key => $value) {
				Common::Constant($value->name, $value->value);
			}
		}
	}

	public function receiptValidate ($data = null)
	{
		$unique_id = $_SESSION['DONS']['UNIQUE_ID'];
		$dataVerif = $data['purchase_units']['0']['custom_id'];
		$sold      = $data['purchase_units']['0']['amount']['value']. '&nbsp;' .$data['purchase_units']['0']['amount']['currency_code'];
		if ($data['status'] == 'COMPLETED') {
			$insert['name']        = $_SESSION['DONATE']['user'];
			$insert['surname']     = $_SESSION['DONATE']['last_name'];
			$insert['mail']        = Secure::isMail($_SESSION['DONATE']['mail']);
			$insert['msg']         = Common::VarSecure($_SESSION['DONATE']['msg'], null);
			$insert['id_purchase'] = $data['id']; 
			$insert['sold']        = $sold;
			$insert['valid']       = 1;
			$insert['type']        = 'PayPal';
		}
		if ($unique_id == $dataVerif) {
			if ($data['status'] == 'COMPLETED') {
				$sql  = New BDD();
				$sql->table('TABLE_DONATIONS_REVEIVE');
				$sql->insert($insert);
				if ($sql->rowCount == true) {
					return true;
				}
			}
		}
	}

	public function validPledge ($data): bool
	{
		$insert['name']        = $_SESSION['DONATE']['user'];
		$insert['surname']     = $_SESSION['DONATE']['last_name'];
		$insert['mail']        = Secure::isMail($data['mail']);
		$insert['msg']         = Common::VarSecure($_SESSION['DONATE']['msg'], null);
		$insert['id_purchase'] = $_SESSION['DONS']['UNIQUE_ID']; 
		$insert['sold']        = $data['donate']. '&nbsp;' .constant('PAYPAL_CURRENCY');
		$insert['valid']       = 0;
		$insert['type']        = constant('PAYMENT');
		$sql  = New BDD();
		$sql->table('TABLE_DONATIONS_REVEIVE');
		$sql->insert($insert);
		if ($sql->rowCount == true) {
			return true;
		}
	}

	public function bank ()
	{
		$sql  = New BDD();
		$sql->table('TABLE_DONATIONS');
		$sql->where(array('name' => 'id', 'value' => 1));
		$sql->queryOne();
		return $sql->data;
	}

}