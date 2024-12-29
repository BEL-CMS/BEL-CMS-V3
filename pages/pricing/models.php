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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
#####################################
# TABLE_PRICING
#####################################
#####################################
# id, name, price, per, description, 
# listing, created_date, sort_asc 
#####################################
# TABLE_PRICING_LIST
#####################################
# id, name, cat_1, cat_2, cat_3 
# cat_4, cat_5, cat_6, cat_7, cat_8 
# cat_9, cat_10
#####################################
# TABLE_PRICING_SALES
# author, date_insert, plan, sales, type, verif 
final class Pricing
{
	#####################################
	# Récupère les plan
	#####################################
    public function getPlan () {
        $sql = new BDD;
        $sql->table('TABLE_PRICING');
        $sql->queryAll();
        return $sql->data;
    }

    public function listing ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_LIST');
        $sql->where(array('name' => 'id', 'value' => $data));
        $sql->fields(array('cat_1','cat_2','cat_3','cat_4','cat_5','cat_6','cat_7','cat_8','cat_9','cat_10'));
        $sql->queryOne();
        return $sql->data;
    }

	#####################################
	# Récupère le plan choisis
	#####################################
    public function getPlanChoise ($id) {
        $sql = new BDD;
        $sql->table('TABLE_PRICING');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->queryOne();
        return $sql->data;
    }

    public function getOrder ()
    {
        $where[] = array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key);
        $sql = new BDD;
        $sql->table('TABLE_PRICING_SALES');
        $sql->where($where);
        $sql->queryAll();
        return $sql->data;
    }

    public function addValidSales ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_SALES');
        $sql->insert($data);
    }

    public function addValidSalesPaypal ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_SALES');
        $sql->insert($data);
    }


    public function getAll ($id)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_SALES');
        $where[] = array('name' => 'id_order', 'value' => $id);
        $where[] = array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key);
        $sql->where($where);
        $sql->queryOne();
        return $sql->data;
    }

    public function verifPaypal ($data = null)
    {
        if ($data['status'] == 'COMPLETED') {
            $dataVerif = $data['purchase_units']['0']['custom_id'];
            $purchase  = $data['purchase_units'][0];
            $totalPay  = $purchase['amount']['value'];

            if ($dataVerif == $_SESSION['PRICING']['ID_ORDER']) { 
                $where[] = array('name' => 'id_order', 'value' => $dataVerif);
                $update['verif'] = 1;
                $sql = New BDD();
                $sql->table('TABLE_PRICING_SALES');
                $sql->where($where);
                $sql->update($update);
            }
        }
    }

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
}