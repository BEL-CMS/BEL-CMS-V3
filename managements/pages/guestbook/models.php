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
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsGuestbook
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_GUESTBOOK
	#####################################
	function getUser ()
	{
		$sql = new BDD();
		$sql->table('TABLE_GUESTBOOK');
		$sql->orderby('ORDER BY `'.TABLE_GUESTBOOK.'`.`id` DESC', true);
		$sql->queryAll();
		$data = $sql->data;
		foreach ($data as $key => $value) {
			if (User::ifUserExist($value->author) == true) {
				$user = User::getInfosUserAll($value->author);
				$username = $user->user->username;
				$data[$key]->author = $username;
				$data[$key]->avatar = is_file(ROOT.DS.$user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
			} else {
				$data[$key]->author = Common::VarSecure($value->author, null);
				$data[$key]->avatar = constant('DEFAULT_AVATAR');
			}
			$data[$key]->date_msg = Common::TransformDate($value->date_msg, 'FULL', 'MEDIUM');
			$data[$key]->message  = Common::VarSecure($value->message, null);
			$data[$key]->message  = Common::getSmiley($value->message);
		}
		return $data;
	}

    public function getEdit ($id)
    {
        $id = (int) $id;
		$sql = new BDD();
		$sql->table('TABLE_GUESTBOOK');
        $sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$data = $sql->data;
		$data->message  = Common::VarSecure($sql->data->message, null);
		$data->message  = Common::getSmiley($sql->data->message);
		return $data;
    }

    public function sendEdit ($data)
    {
        if (is_array($data) && is_string($data['id'])) {
            $update['message']  = Common::VarSecure($data['message']);
            $id = (int) $data['id'];
            $sql = New BDD();
            $sql->table('TABLE_GUESTBOOK');
            $sql->where(array('name' => 'id', 'value' => $id));
            $sql->update($update);
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
        } else {
            $return = array(
                'type' => 'error',
                'text' => constant('ID_ERROR')
            );
        }
        return $return;
    }

    public function sendDel ($id)
    {
        $id = (int) $id;
        $sql = New BDD();
        $sql->table('TABLE_GUESTBOOK');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->delete();
        if ($sql->rowCount == true) {
            $return = array(
                'type' => 'success',
                'text' => constant('DEL_SUCCESS')
            );    
        } else {
            $return = array(
                'type' => 'success',
                'text' => constant('DEL_ERROR')
            ); 
        }
        return $return;
    }

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['MAX_USER']     = (int) $data['MAX_USER'];
			$opt                  = array('MAX_USER' => $data['MAX_USER']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'guestbook'));
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
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
}