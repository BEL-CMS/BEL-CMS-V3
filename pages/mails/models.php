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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_MAILS
# TABLE_MAILS_MSG
final class Mails
{
	public function getMailsAlll ()
	{
		$user = $_SESSION['USER']->user->hash_key;
		$where = 'WHERE `author_send` = "'.$user.'" OR `author_receives` = "'.$user.'"';
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->last_msg = self::getMsgMails($value->mail_id);
		}
		return $return;
	}
	public function getMails()
	{
		$where[] = array('name' => 'author_receives', 'value' => $_SESSION['USER']->user->hash_key);
		$where[] = array('name' => 'close_receives', 'value' => '0');
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->last_msg = self::getMsgMails($value->mail_id);
		}
		return $return;
	}

	public function getMailsSend ()
	{
		$where = 'WHERE `author_send` = "'.$_SESSION['USER']->user->hash_key.'"';
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->last_msg = self::getMsgMails($value->mail_id);
		}
		return $return;
	}

	public function getMailsArchive ()
	{
		$where[] = array('name' => 'author_send', 'value' => $_SESSION['USER']->user->hash_key);
		$where[] = array('name' => 'archive_send', 'value' => '1');
		$where[] = array('name' => 'close_receives', 'value' => '0');
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->last_msg = self::getMsgMails($value->mail_id);
		}
		return $return;
	}

	public function getMailTrach ()
	{
		$where = 'WHERE `author_send` = "'.$_SESSION['USER']->user->hash_key.'"';
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->last_msg = self::getMsgMails($value->mail_id);
		}
		return $return;
	}

	public function getMsgMails ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_MAILS_MSG');
		$sql->where(array('name' => 'mail_id', 'value' => $id));
		$sql->orderby('ORDER BY `'.TABLE_MAILS_MSG.'`.`id` DESC', true);
		$sql->limit(1);
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}

	public function getUsers ($user = null)
	{
		$return = array();
		# check if user >= 2 letter
		if (strlen($user) >= 3) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->fields(array('username'));

			$where = array(
				'name'  => 'username',
				'value' => $user
			);

			$sql->whereLike($where);
			$sql->queryAll();
			$result = $sql->data;

			foreach ($result as $k => $v) {
				$user = User::getInfosUserAll($v->username);
				if ($v->username != $_SESSION['USER']->user->username) {
					$return[] = $v->username;
				}
			}
		}
		return $return;
	}
	public function getUser ($user = null) : bool
	{
		$return = false;
		if ($user == null) {
			$return = false;
		} else {
			$user  = Common::VarSecure($user, null);
			$where = array(
				'name'  => 'username',
				'value' => $user
			);
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where($where);
			$sql->fields(array('username'));
			$sql->count();
			if ($sql->data == 1) {
				$return = true;
			} else {
				$return = false;
			}
		}
		return $return;
	}

	public function getHashKeyUser ($user = null)
	{
		$return = false;
		if ($user == null) {
			$return = false;
		} else {
			$user  = Common::VarSecure($user, null);
			$where = array(
				'name'  => 'username',
				'value' => $user
			);
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where($where);
			$sql->fields(array('hash_key'));
			$sql->queryOne();
			if (!empty($sql->data)) {
				$return = $sql->data;
			} else {
				$return = false;
			}
		}
		return $return;
	}

	public function sendNew ($data = null) : array
	{
		$return = array();
		if ($data == null) {  
			$return['text']	= constant('ERROR_NO_DATA');
			$return['type']	= 'error';
		} else {
			$dir = constant('DIR_UPLOADS_MAILS');
			if (!is_dir($dir)) {
			    mkdir($dir, 0777, true);
			}
			$fopen  = fopen($dir.'/index.html', 'a+');
			fclose($fopen);
			// Variable et sécurisation
			$crypt           = Common::randomString(32);
			$user            = Common::VarSecure($data['author'], null);
			$author_send     = $_SESSION['USER']->user->hash_key;
			$author_receives = self::getHashKeyUser($user)->hash_key;
			$subject         = Common::VarSecure($data['subject'], null);
			$message         = Common::VarSecure($data['message'], 'html');
			$message         = Common::crypt($message, $crypt);
			if ($_FILES['upload']['error'] != 4) {
				Common::Upload ('upload', $dir);
				$upload = '/uploads/mails/'.$_FILES['upload']['name'];
			} else {
				$upload = '';
			}
			// Envoie du message dans la boîtes de messagerie
			// Variable à entrer en BDD (author_send)
			$insertMailsSend = array(
				'mail_id'         => $crypt,
				'author_send'     => $author_send,
				'author_receives' => $author_receives,
				'subject'         => $subject
			);
			// Envoie les données en BDD Mail;
			$sqlMailsSend = New BDD();
			$sqlMailsSend->table('TABLE_MAILS');
			$sqlMailsSend->insert($insertMailsSend);
			// Variable à entrer en BDD (Message)
			$insertMailsMsg = array(
				'mail_id'         => $crypt,
				'author_send'     => $author_send,
				'author_receives' => $author_receives,
				'message'         => $message,
				'upload'          => $upload
			);
			// Envoie les données en BDD MSG;
			$sqlMailsMsg = New BDD();
			$sqlMailsMsg->table('TABLE_MAILS_MSG');
			$sqlMailsMsg->insert($insertMailsMsg);
			// Teste si les deux inserts en BDD a bien fonctionné
			if ($sqlMailsSend->rowCount == true and $sqlMailsMsg->rowCount == true) {
				$return['text']	= constant('MESSAGE_SUCCESS');
				$return['type']	= 'success';
			} else {
				$return['text']	= constant('ERROR_INSERT_BDD');
				$return['type']	= 'error';
			}
		}
		return $return;
	}

	public function deleteAll ()
	{
		$where[] = array('name' => 'author_receives', 'value' => $_SESSION['USER']->user->hash_key);
		$where[] = array('name' => 'author_send', 'value' => $_SESSION['USER']->user->hash_key);
		$update['close_receives'] = 1;
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->update($update);
	}

	public function deleteAllMsg ()
	{
		$where = 'WHERE `close_receives` = "1" AND `close_send` = "1"';
		$sql = new BDD;
		$sql->table('TABLE_MAILS');
		$sql->where($where);
		$sql->queryAll();
		foreach ($sql->data as $value) {
			if ($value->author_receives == $_SESSION['USER']->user->hash_key or $value->author_send == $_SESSION['USER']->user->hash_key) {
				$del = new BDD;
				$del->table('TABLE_MAILS');
				$del->where(array('name' => 'mail_id', 'value' => $value->mail_id));
				$del->delete();

				$del2 = new BDD;
				$del2->table('TABLE_MAILS_MSG');
				$del2->where(array('name' => 'mail_id', 'value' => $value->mail_id));
				$del2->delete();
			}
		}
	}
}