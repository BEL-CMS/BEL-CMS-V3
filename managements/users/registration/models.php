<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\PDO\BDD;
use BelCMS\User\User;
use BelCMS\Core\Secure;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsUsers
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_USERS
	# TABLE_USERS_PROFILS
	# TABLE_USERS_SOCIAL
	#####################################
	public function getAllUsers ($id = null)
	{
		$sql = New BDD;
		$sql->table('TABLE_USERS');
		$sql->queryAll();
		$data = $sql->data;

		foreach ($sql->data as $key => $value) {
			$return[$value->id] = User::getInfosUserAll($value->hash_key);
		}
		return $return;
	}
	public function getAllUsersProfils ($id = null)
	{
		$sql = New BDD;
		$sql->table('TABLE_USERS_PROFILS');
		if ($id != null && is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
		}
		$sql->queryAll();
		$return = $sql->data;

		return $return;
	}
	public function getAllUsersSocial ($id = null)
	{
		$sql = New BDD;
		$sql->table('TABLE_USERS_SOCIAL');
		if ($id != null && is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
		}
		$sql->queryAll();
		$return = $sql->data;

		return $return;
	}

	public function sendPrivate ($data)
	{
		$sql = New BDD;
		$sql->table('TABLE_USERS');
		$sql->where(array('name' => 'hash_key', 'value' => $data['hash_key']));
		$insert['mail'] = Secure::isMail($data['mail']);
		$sql->update($insert);
		$return = array('type' => 'success', 'text' => 'le e-mail privé à été changé', 'title' => 'Paramètre privé');
		return $return;
	}

	public function sendMainGroup ($data = null)
	{
		$update['user_group'] = (int) $data['main'];
		$sql = New BDD;
		$sql->table('TABLE_USERS_GROUPS');
		$sql->where(array('name' => 'hash_key', 'value' => $data['hash_key']));
		$sql->update($update);
		$return = array('type' => 'success', 'text' => 'le groupe principal à été changer', 'title' => 'Groupe primaire');
		return $return;
	}

	public function sendSecondGroup ($data = null)
	{
		$update['user_groups'] = null;
		if (!empty($data)) {
			foreach ($data['second'] as $key => $value) {
				if ($value != '2') { /* auto members */
					$update['user_groups'] .= $value.'|';
				}
			}
		}

		if (!strpos($update['user_groups'], 2)) {
			$update['user_groups'] .= 2; // membres obligatoire
		}

		$sql = New BDD;
		$sql->table('TABLE_USERS_GROUPS');
		$sql->where(array('name' => 'hash_key', 'value' => $data['hash_key']));
		$sql->update($update);
		$return = array('type' => 'success', 'text' => 'les groupes secondaire ont été changer', 'title' => 'Groupe seconaire');
		return $return;
	}

	public function sendSocial ($data = null)
	{
		if ($data != null) {
			$update = New BDD();
			$update->table('TABLE_USERS_SOCIAL');
			$update->where(array('name' => 'hash_key', 'value' => $data['hash_key']));
			$update->update($data);
			$returnSql = $update->data;
			$resultsCount = $returnSql;

			if ($resultsCount != null) {
				$return['text']     = 'Vos informations ont été sauvegardées avec succès';
				$return['type']     = 'success';
				$return['rowcount'] = $resultsCount;
			} else {
				$return['text']  = 'Aucune informations a été sauvegardées';
				$return['type']  = 'danger';
				$return['rowcount'] = $resultsCount;
			}
			return $return;
		}
	}

	public function sendInfoPublic ($data)
	{
		if ($data && is_array($data)) {
			$update = New BDD();
			$update->table('TABLE_USERS_PROFILS');
			$update->where(array('name' => 'hash_key', 'value' => $data['hash_key']));
			$update->update($data);
			$returnSql = $update->data;
			$resultsCount = $returnSql;

			if ($resultsCount != null) {
				$return['text']     = 'Vos informations ont été sauvegardées avec succès';
				$return['type']     = 'success';
				$return['rowcount'] = $resultsCount;
			} else {
				$return['text']  = 'Aucune informations a été sauvegardées';
				$return['type']  = 'danger';
				$return['rowcount'] = $resultsCount;
			}
			return $return;
		}
	}
}