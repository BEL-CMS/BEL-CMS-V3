<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
#####################################
# TABLE_TICKETS
# TABLE_TICKETS_CAT
#####################################
final class ModelsTickets
{
    #####################################
    # Récupère les tickets et la categorie
    #####################################
    public function getTickets ($id = false)
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS');
        if ($id !== false and is_numeric($id)) {
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->queryOne();
            $return = $sql->data;
            $cat = new BDD;
            $cat->table('TABLE_TICKETS_CAT');
            $cat->where(array('name' => 'id', 'value' => $return->cat));
            $cat->queryOne();
            $return->cat = $cat->data;
        } else {
            $sql->queryAll();
            $return = $sql->data;
            foreach ($return as $key => $value) {
                $cat = new BDD;
                $cat->table('TABLE_TICKETS_CAT');
                $cat->where(array('name' => 'id', 'value' => $value->cat));
                $cat->queryOne();
                $return[$key]->cat = $cat->data;
            }
        }
        return $return;
    }
    public function edit ($id) : object
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->queryOne();
        return $sql->data;
    }
    public function close ($id)
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->update(array('close'=> 1));
        if ($sql->rowCount == true) {
            $return['text'] = constant('EDITING_SUCCESS');
            $return['type'] = 'success';
        } else {
            $return['text'] = constant('EDIT_ERROR');
            $return['type'] = 'error'; 
        }
        return $return;
    }
    public function sendedit ($data, $id) : array
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->update($data);
        if ($sql->rowCount == true) {
            $return['text'] = constant('EDITING_SUCCESS');
            $return['type'] = 'success';
        } else {
            $return['text'] = constant('EDIT_ERROR');
            $return['type'] = 'error'; 
        }
        return $return;
    }
    public function getCat ($where = false) : array
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS_CAT');
        if ($where !== false) {
            $sql->where(array('name' => 'id', 'value' => $where));
            $sql->queryOne();
        } else {
            $sql->queryAll();
        }
        $return = $sql->data;
        return $return;
    }
    public function sendAddCat ($name) :  array
    {
        $insert['name_cat'] = $name;
        $sql = new BDD;
        $sql->table('TABLE_TICKETS_CAT');
        $sql->insert($insert);
        if ($sql->rowCount == true) {
            $return['text'] = constant('ADD_CAT_OK');
            $return['type'] = 'success';
        } else {
            $return['text'] = constant('ADD_CAT_NOK');
            $return['type'] = 'error'; 
        }
        return $return;
    }
    public function editCat ($id) : object
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS_CAT');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->queryOne();
        return $sql->data;
    }
    public function sendeditcat ($data) : array
    {
        $update['name_cat'] = Common::MakeConstant($data['name']);
        $sql = new BDD;
        $sql->table('TABLE_TICKETS_CAT');
        $sql->where(array('name' => 'id', 'value' => $data['id']));
        $sql->update($update);
        if ($sql->rowCount == true) {
            $return['text'] = constant('EDITING_SUCCESS');
            $return['type'] = 'success';
        } else {
            $return['text'] = constant('EDIT_ERROR');
            $return['type'] = 'error'; 
        }
        return $return;
    }
    public function delcat ($id) : array
    {
        $sql = new BDD;
        $sql->table('TABLE_TICKETS_CAT');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->delete();
        if ($sql->rowCount == true) {
            $return['text'] = constant('DEL_SUCCESS');
            $return['type'] = 'success';
        } else {
            $return['text'] = constant('DEL_ERROR');
            $return['type'] = 'error'; 
        }
        return $return;
    }

    public function GetUser () : array
    {
        $sql = new BDD;
        $sql->table('TABLE_USERS');
        $sql->queryAll();
        return $sql->data;
    }
	#####################################
	# Enregistre les paramètre
	#####################################
	public function sendparameter($data = null) : array
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
			$sql->where(array('name' => 'name', 'value' => 'tickets'));
			$sql->update($upd);
			if ($sql->rowCount == true) {
				$return = array(
					'type' => 'success',
					'text' => constant('PARAMETER_EDITING_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_PAGE_PARAM_ERROR')
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