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

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsLinks
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_LINKS
	# TABLE_LINKS_CAT
	#####################################
    public function getCat($id = null) {
        $sql = New BDD;
        $sql->table('TABLE_LINKS_CAT');
        if (is_numeric($id)) {
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->queryOne();
        } else {
            $sql->queryAll();  
        }
        return $sql->data;
    }

    public function newCat ($data)
    {
        if (is_array($data)) {
            $insert['name']  = Common::VarSecure($data['name'], null);
            $insert['color'] = Common::VarSecure($data['color']);
            $insert['description'] = Common::VarSecure($data['description'], 'html');
            $sql = New BDD;
            $sql->table('TABLE_LINKS_CAT');
            $sql->insert($insert);
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
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('DEL_BDD_ERROR')
            );  
        }
        return $return;
    }

    public function neweditCat ($data = null)
    {
        if (is_array($data)) {
            $insert['name']  = Common::VarSecure($data['name'], null);
            $insert['color'] = Common::VarSecure($data['color']);
            $insert['description'] = Common::VarSecure($data['description'], 'html');
            $id              = (int) $data['id'];
            $sql = New BDD;
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->table('TABLE_LINKS_CAT');
            $sql->update($insert);
            if ($sql->rowCount == true) {
                $return = array(
                    'type' => 'success',
                    'text' => constant('EDITING_SUCCESS')
                );
            } else {
                $return = array(
                    'type' => 'warning',
                    'text' => constant('SEND_BDD_PARTIEL')
                );
            }
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('EDIT_BDD_ERROR')
            );  
        }
        return $return;
    }

    public function delCat ($id = null)
    {
        if (is_numeric($id)) {
            $sql = New BDD;
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->table('TABLE_LINKS_CAT');
            $sql->delete();
            if ($sql->rowCount == true) {
                $return = array(
                    'type' => 'success',
                    'text' => constant('DEL_SUCCESS')
                );
            } else {
                $return = array(
                    'type' => 'error',
                    'text' => constant('DEL_ERROR')
                );
            }
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('ID_ERROR')
            );   
        }
        return $return;
    }

    public function sendadd ($data)
    {
        if (is_array($data)) {
            $insert['name'] = Common::VarSecure($data['name'], null);
            $insert['link'] = Common::VarSecure($data['link'], null);
            $insert['description'] = Common::VarSecure($data['description'], 'html');
            $insert['cat'] = is_int($data['cat']) ? $data['cat'] : 0;
            $sql = New BDD;
            $sql->table('TABLE_LINKS');
            $sql->insert($insert);
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
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('ID_ERROR')
            );   
        }
        return $return; 
    }

    public function getLinks ($id = null)
    {
        $sql = New BDD;
        $sql->table('TABLE_LINKS');
        if ($id !== null and is_numeric($id)) {
            $where = array(array('name' => 'id', 'value' => $id));
            $sql->where($where);
            $sql->queryOne();
            $return = $sql->data;
        } else {
            if ($id === true) {
                $where[] = array(array('name' => 'valid', 'value' => 0)); 
            } else {
                $where[] = array(array('name' => 'valid', 'value' => 1)); 
            }
            $sql->where($where);
            $sql->queryAll(); 
            $return = $sql->data;
        }
        return $return;
    }

    public function sendedit ($data = null)
    {
        if (is_array($data) and is_array($data)) {
            $insert['name'] = Common::VarSecure($data['name'], null);
            $insert['link'] = Common::VarSecure($data['link'], null);
            $insert['description'] = Common::VarSecure($data['description'], 'html');
            $insert['cat']   = (int) $data['cat'];
            $insert['valid'] = 1;
            $id = (int) $data['id'];
            $sql = New BDD;
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->table('TABLE_LINKS');
            $sql->update($insert);
            if ($sql->rowCount == true) {
                $return = array(
                    'type' => 'success',
                    'text' => constant('EDITING_SUCCESS')
                );
            } else {
                $return = array(
                    'type' => 'warning',
                    'text' => constant('SEND_BDD_PARTIEL')
                );
            }
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('EDIT_BDD_ERROR')
            );  
        }
        return $return;
    }

    public function del ($id = null)
    {
        if (is_numeric($id)) {
            $sql = New BDD;
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->table('TABLE_LINKS');
            $sql->delete();
            if ($sql->rowCount == true) {
                $return = array(
                    'type' => 'success',
                    'text' => constant('DEL_SUCCESS')
                );
            } else {
                $return = array(
                    'type' => 'error',
                    'text' => constant('DEL_ERROR')
                );
            }
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('ID_ERROR')
            );   
        }
        return $return;
    }

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
            $opt                  = array('MAX_LINKS' => $data['MAX_LINKS']);
            $upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'links'));
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