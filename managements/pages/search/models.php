<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
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
# TABLE_SEARCH
#####################################
#####################################
#     id, letter, title, content
#####################################
final class ModelsSearch
{
	#####################################
	# Récupère le template depuis la BDD
	#####################################
    public function getLetter ()
    {
        $sql = new BDD;
        $sql->table('TABLE_SEARCH');
        $sql->queryAll();
        $return = $sql->data;
        return $return;
    }
	#####################################
	# Envoie les données en BDD
	#####################################
    public function sendNewLetter ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_SEARCH');
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
	# Supprime une lettre
	#####################################
    public function RemoveLetter ($id)
    {
        $sql = new BDD;
        $sql->table('TABLE_SEARCH');
        $sql->where(array('name' => 'id', 'value' => $id));
        $sql->delete();
        if ($sql->rowCount == true) {
            $return = array(
                'type' => 'success',
                'text' => constant('DEL_FILE_SUCCESS')
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
	# Enregistre les paramètre
	#####################################
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
			$sql->where(array('name' => 'name', 'value' => 'search'));
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