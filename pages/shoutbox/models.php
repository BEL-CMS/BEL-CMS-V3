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

namespace Belcms\Pages\Models;

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Shoutbox
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
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			$return['text'] = 'Erreur HashKey';
			$return['type'] = 'danger';
			return $return;
		} else {
			$data['hash_key'] = $_SESSION['USER']->user->hash_key;
		}

		$sql = new BDD;
		$sql->table('TABLE_USERS');
		$sql->where(array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key));
		$sql->queryOne();
		$user = $sql->data;

		if (empty($user->avatar) OR !is_file($user->avatar)) {
			$data['avatar'] = constant('DEFAULT_AVATAR');
		} else {
			$data['avatar'] = $_SESSION['user']->profils->avatar;
		}

		if (empty($_POST['text'])) {
			$return['text'] = 'Erreur Message Vide';
			$return['type'] = 'warning';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($_REQUEST['text'], '<a><b><p><strong>');
		}

		if (isset($_FILES['file']) and !empty($_FILES['file'])) {
			if (constant('UPLOAD_FILE_SUCCESS') == Common::Upload('file', 'uploads/shoutbox', false)) {
				$data['file'] = 'uploads/shoutbox/'.$_FILES['file']['name'];
			}
		}

		if (isset($_FILES['img']) and !empty($_FILES['img'])) {
			if (constant('UPLOAD_FILE_SUCCESS') == Common::Upload('img', 'uploads/shoutbox', false)) {
				$data['image'] = 'uploads/shoutbox/'.$_FILES['img']['name'];
			}
		}

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->insert($data);
		if ($sql->rowCount == true) {
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
				$sql->data[$k]->username = user::getInfosUserAll($v->hash_key)->user->username;
				unset($sql->data[$k]->hash_key);
			}
			$return = $sql->data;
		}

		$this->typeMime = 'application/json';
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

		$data['avatar'] = User::getInfosUserAll($hash_key)->profils->avatar;

		if (empty($text)) {
			$return['text'] = 'Aucun texte transmis';
			return $return;
		} else {
			$data['msg'] = Common::VarSecure($text, '<a><b><p><strong><i>');
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
