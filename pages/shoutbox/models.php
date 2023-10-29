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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class ModelsShoutbox
{
	public function getMsg($id = false)
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		if (is_numeric($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
		} else {
			$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
			$sql->queryAll();
		}
		if (!empty($sql->data)) {
			$return = $sql->data;
		}
		return $return;
	}

	public function insertMsg()
	{
		if (strlen($_SESSION['USER']['HASH_KEY']) != 32) {
			$return['text'] = 'Erreur HashKey';
			$return['type'] = 'danger';
			return $return;
		} else {
			$data['hash_key'] = $_SESSION['USER']['HASH_KEY'];
		}

		$sql = new BDD;
		$sql->table('TABLE_USERS');
		$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']['HASH_KEY']));
		$sql->queryOne();
		$user = $sql->data;

		if (empty($user->avatar) OR !is_file($user->avatar)) {
			$data['avatar'] = DEFAULT_AVATAR;
		} else {
			$data['avatar'] = $_SESSION['user']->avatar;
		}

		if (empty($_REQUEST['text'])) {
			$return['text'] = 'Erreur Message Vide';
			$return['type'] = 'warning';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($_REQUEST['text'], '<a><b><p><strong>');
		}

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->insert($data);
		if ($rowCount == 1) {
			$return['text']	= 'Message envoyer avec succès';
			$return['type']	= 'success';
		} else {
			$return['text']	= 'Problème d\'accès à la BDD';
			$return['type']	= 'error';
		}

		return $return;
	}

	public function getMsgJson($id = false)
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');

		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit(15);
		$sql->fields(array('hash_key', 'avatar', 'date_msg', 'msg'));
		$sql->queryAll();

		if (!empty($sql->data)) {
			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->username = Users::hashkeyToUsernameAvatar($v->hash_key);
				unset($sql->data[$k]->hash_key);
			}
			$return = $sql->data;
		}

		return $return;
	}

	public function insertMsgJson($hash_key = null, $text = null)
	{
		if (strlen($hash_key) != 32) {
			$return['text'] = 'Erreur HashKey';
			return $return;
		} else {
			$data['hash_key'] = $hash_key;
		}

		$data['avatar'] = Users::hashkeyToUsernameAvatar($hash_key, 'avatar');

		if (empty($text)) {
			$return['text'] = 'Aucun texte transmis';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($text, '<a><b><p><strong>');
		}

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->insert($data);
		if ($sql->rowCount == 1) {
			$return['text']	= 'Votre message a été envoyé avec succès';
		} else {
			$return['text']	= 'Problème d\'accès à la BDD';
		}

		return $return;

	}
}
