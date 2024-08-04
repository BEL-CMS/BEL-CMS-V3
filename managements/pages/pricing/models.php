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
final class ModelsPricing
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
	# Ajouter une liste
	##################################### 
    public function sendList ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_LIST');
        $sql->insert($data);
        if ($sql->rowCount == true) {
            $return = array(
                'type' => 'success',
                'text' => constant('SEND_SUCCESS')
            );
        } else {
            $return = array(
                'type' => 'warning',
                'text' => constant('SEND_BDD_PARTIEL')
            );
        }
        return $return; 
    }
	#####################################
	# Récupère les listes
	##################################### 
    public function getList ()
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_LIST');
        $sql->queryAll();
        $return = $sql->data;
        return $return;    
    }
	#####################################
	# Récupère une liste par ID
	##################################### 
    public function getListingName ($id)
    {
        $id  = (int) $id;
        $sql = new BDD;
        $sql->table('TABLE_PRICING_LIST');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->queryOne();
        if ($sql->data == false) {
            $return = constant('UNKNOWN');
        } else {
            $return = $sql->data->name;
        }
        return $return;    
    }
	#####################################
	# Enregistre un Plan
	##################################### 
    public function sendPlan ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING');
        $sql->insert($data);
        if ($sql->rowCount == true) {
            $return = array(
                'type' => 'success',
                'text' => constant('SEND_SUCCESS')
            );
        } else {
            $return = array(
                'type' => 'warning',
                'text' => constant('SEND_BDD_PARTIEL')
            );
        }
        return $return; 
    }
	#####################################
	# Supprime un Plan
	##################################### 
	public function sendDelPlan ($id)
	{
		$sql = New BDD();
		$sql->table('TABLE_PRICING');
		$sql->where(array('name'=>'id','value' => $id));
		$sql->delete();
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
	#####################################
	# Editer un Plan
	##################################### 
	public function sendEdit ($data, $id)
	{
		$sql = New BDD();
		$sql->table('TABLE_PRICING');
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
        return $return;
    }
	#####################################
	# Supprime un Plan
	##################################### 
	public function sendDelList ($id)
	{
		$sql = New BDD();
		$sql->table('TABLE_PRICING_LIST');
		$sql->where(array('name'=>'id','value' => $id));
		$sql->delete();
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
}