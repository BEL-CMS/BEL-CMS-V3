<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD;

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
# cat_4, cat_5
#####################################
# TABLE_PRICING_SALES
# author, date_insert, plan, sales, type, verif 
final class Pricing
{
	#####################################
	# Récupère les plan
	#####################################
    public function getPlan ($id = null)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING');
        if (is_numeric($id)) {
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->queryOne();
        } else {
            $sql->orderby('ORDER BY `'.TABLE_PRICING.'`.`sort_asc` ASC', true);
            $sql->queryAll();
        }
        $return = $sql->data;
        return $return;
    }
	#####################################
	# Récupère la liste
	#####################################
    public function getListing ($id)
    {
        if (is_numeric($id)) {
            $sql = new BDD;
            $sql->table('TABLE_PRICING_LIST');
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->queryOne();
            $return = $sql->data;
        } else {
            
        }
        return $return;
    }

	public function bank ()
	{
		$sql  = New BDD;
		$sql->table('TABLE_DONATIONS');
		$sql->where(array('name' => 'id', 'value' => 1));
		$sql->queryOne();
		return $sql->data;
	}

    public function preorder ($id, $price)
    {
        $insert['author'] = $_SESSION['USER']->user->hash_key;
        $insert['plan']   = $id;
        $insert['sales']  = $price;
        $sql = new BDD;
        $sql->table('TABLE_PRICING_SALES');
        $sql->insert($insert);
		if ($sql->rowCount == 1) {
			$return['text']  = constant('PREORDER_SUCCESS');
			$return['type']  = 'success';
		} else {
			$return['text']  = constant('PREORDER_ERROR');
			$return['type']  = 'error';
		}
		return $return;
    }
}