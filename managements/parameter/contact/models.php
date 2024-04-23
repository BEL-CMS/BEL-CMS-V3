<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
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

final class ModelsContact
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_TABLE_CONTACT
	#####################################
    # TABLE_CONTACT_REPLY
    ####################################
	public function getAllEmail () : array
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_CONTACT');
		$sql->queryAll();

		if ($sql->data) {
			$return = $sql->data;
            foreach ($return as $key => $value) {
                $return[$key]->reply = self::getMailReply($value->id);
            }
		}

		return $return;
	}
	public function getEmail ($id) : object
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_CONTACT');
        $sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();

		if ($sql->data) {
			$return = $sql->data;
		}

		return $return;
	}

    private function getMailReply ($id = false) : bool
    {
        $return = array();
    
        if ($id !== false and is_numeric($id)) {
            $get = new BDD;
            $get->table('TABLE_CONTACT_REPLY'); 
            $get->where(array('name' => 'id_msg', 'value' => $id));
            $get->queryOne();
			if ($get->data !== false) {
				return true;
			} else {
				return false;
			}
        }
    }

	public function viewreply ($id)
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_CONTACT');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();

			if (!empty($sql->data)) {
				$get = new BDD;
				$get->table('TABLE_CONTACT_REPLY');	
				$get->where(array('name' => 'id_msg', 'value' => $id));
				$get->queryAll();
				$data = $get->data;
				foreach ($data as $value) {
					$sql->data->reply[] = $value;
				}
			}

			return $sql->data;
		}
	}

    public function saveReply($data) : array
    {
        $return = array();

        if (is_numeric($data['id'])) {
            $dataInert['message'] = Common::VarSecure($data['content'], 'html');
            $dataInert['id_msg']  = (int) $data['id'];
            $dataInert['author']  = $_SESSION['USER']->user->hash_key;
            $dataInert['reply']   = (bool) true;

            $insert = new BDD;
            $insert->table('TABLE_CONTACT_REPLY');
            $insert->insert($dataInert);
			// SQL RETURN NB INSERT
			if ($insert->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_REPLY_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_REPLY_ERROR')
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
}