<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2027 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Interaction;
use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsNewsletter
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_NEWSLETTER
	# TABLE_NEWSLETTER_SEND
	# TABLE_NEWSLETTER_TPL
	#####################################
	public function getUsers ()
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère le template depuis la BDD
	#####################################
	public function getTpl ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_TPL');
		if (is_numeric($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
		} else {
			$sql->queryAll();
		}
		return $sql->data;
	}
	#####################################
	# Enregistre le template en BDD
	#####################################
	public function sendNewTpl ($data) : array
	{
		if (is_array($data)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->insert($data);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('ADD_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('ADD_TPL_ERROR')
				);
			}
		} else {
			new Interaction ('error', 'Erreur d\'array', constant('ADD_TPL_ERROR_ARRAY'));
			$return = array(
				'type' => 'error',
				'text' => constant('ADD_TPL_ERROR_ARRAY')
			);
		}
		return $return;
	}
	#####################################
	# Edition du TPL en BDD
	#####################################
	public function sendeditpl ($data, $id) : array
	{
		if (is_array($data)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($data);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('EDIT_TPL_ERROR')
				);
			}
		} else {
			new Interaction ('error', 'Erreur d\'array', constant('ADD_TPL_ERROR_ARRAY'));
			$return = array(
				'type' => 'error',
				'text' => constant('ADD_TPL_ERROR_ARRAY')
			);
		}
		return $return;
	}
	#####################################
	# Suppression du TPL
	#####################################
	public function deltpl ($id = null) : array
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->delete();
			if ($sql->data === true) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('DEL_TPL_ERROR')
				);
			}
		} else {
			$return = array (
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);
		}
		return $return;
	}
	#####################################
	# Récupère les information des envoies
	#####################################
	public function getAdd ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_SEND');
		if (is_numeric($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
			$sql->data->nametpl = self::getTpl($sql->data->template);
		} else {
			$sql->queryAll();
			foreach ($sql->data as $key => $value) {
				$sql->data[$key]->nametpl = self::getTpl($value->template);
			}
		}
		return $sql->data;
	}
	#####################################
	# Enregistre dans la BDD
	# la préparation d'envoie
	#####################################
	public function sendppreparation ($data = null) : array
	{
		if (is_array($data)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_SEND');
			$sql->insert($data);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('PREPA_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('PREPA_TPL_ERROR')
				);
			}
		} else {
			$return = array (
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
		return $return;
	}
	#####################################
	# Récupère la présentation du template
	#####################################
	public function getPreapa ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_SEND');
		$sql->where(array('name' => 'id', 'value' => $id ));
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère tout les utilisateurs
	#####################################
	public function getAllUsers ()
	{
		$sql = new BDD;
		$sql->table('TABLE_USERS');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère tout les utilisateurs
	# par groupe
	#####################################
	public function getAllUserGroup ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_USERS_GROUPS');
		$sql->where(array('name' => 'user_group', 'value' => $id));
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère le template selection par ID
	#####################################
	public function getTemplate ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_TPL');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Enregistrer les parametres
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
			$sql->where(array('name' => 'name', 'value' => 'newsletter'));
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