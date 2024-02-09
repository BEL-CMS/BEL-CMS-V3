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

# TABLE_MAILS
# TABLE_MAILS_MSG
final class Mails
{
	public function getMessages ($archive = false)
	{
		$return = array();
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			return false;
		} else {
			$hash_key = $_SESSION['USER']->user->hash_key;
			if ($archive === true) {
				$whereMail = 'WHERE `author_send` = "'.$hash_key.'" OR `author_receives` = "'.$hash_key.'" AND `read_msg_send` = 1';
			} else {
				$whereMail = 'WHERE `author_send` = "'.$hash_key.'" OR `author_receives` = "'.$hash_key.'"';
			}
			$sql   = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryAll();
			$mail = $sql->data;
			foreach ($mail as $key => $value) {
				$whereRead = array('name' => 'mail_id', 'value' => $value->mail_id);
				$read   = New BDD();
				$read->table('TABLE_MAILS_MSG');
				$read->orderby(array(array('name' => 'id', 'type' => 'DESC')));
				$read->where($whereRead);
				$read->isObject(true);
				$read->queryOne();
				$return[$key]['data'] = $value;
				$return[$key]['read'] = $read->data;
			}
		}
		return $return;
	}

	public function testNewMSG () : bool
	{
		if (empty($_SESSION['USER'])) {
			return false;
		}
		$hash_key = $_SESSION['USER']->user->hash_key;
		$whereMail = 'WHERE `author_send` = "'.$hash_key.'" OR `author_receives` = "'.$hash_key.'"';
		$sql   = New BDD();
		$sql->table('TABLE_MAILS');
		$sql->where($whereMail);
		$sql->isObject(true);
		$sql->queryAll();
		$mail = $sql->data;
		if (!empty($mail)) {
			foreach ($mail as $a) {
				if ($a->author_send == $hash_key) {
					if ($a->read_msg_send == 0) {
						return true;
					}
				}
				if ($a->author_receives == $hash_key) {
					if ($a->read_msg_receives == 0) {
						return true;
					}
				}
			}
		} else {
			return false;
		}
	}

	public function getMessagesClose ()
	{
		$return = array();
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			return false;
		} else {
			$hash_key  = $_SESSION['USER']->user->hash_key;
			$whereMail = 'WHERE `author_send` = "'.$hash_key.'" OR `author_receives` = "'.$hash_key.'"';
			$sql = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryAll();
			$mail = $sql->data;
		}
		return $return;
	}
	public function getMessagesRead ($mail_id)
	{
		$return = array();
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			return false;
		} else {
			$mail_id   = Common::VarSecure($mail_id, null);
			$whereMail = array('name' => 'mail_id', 'value' => $mail_id);
			$sql   = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryAll();
			$mail = $sql->data;
			foreach ($mail as $key => $value) {
				$whereRead = array('name' => 'mail_id', 'value' => $mail_id);
				$read   = New BDD();
				$read->table('TABLE_MAILS_MSG');
				$read->orderby(array(array('name' => 'id', 'type' => 'ASC')));
				$read->where($whereRead);
				$read->isObject(true);
				$read->queryAll();
				$return[$key]['data'] = $value;
				$return[$key]['read'] = $read->data;
			}
			self::read($mail_id);
		}
		return $return;
	}

	public function read ($mail_id)
	{
		if (strlen($_SESSION['USER']->user->hash_key) == 32) {
			$whereMail[] = array('name' => 'mail_id', 'value' => $mail_id);
			$whereMail[] = array('name'=> 'author_send', 'value' => $_SESSION['USER']->user->hash_key);
			$sql = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryAll();
			$mail = $sql->data;
			if (!empty($mail)) {
				// Variables update
				$updateRead = array(
					'read_msg_send' => 1,
				);
				// Mise à jour de la BDD
				$update = new BDD();
				$update->table('TABLE_MAILS');
				$update->where($whereMail);
				$update->update($updateRead);
			} else {
				$whereUpdate[] = array('name' => 'mail_id', 'value' => $mail_id);
				$whereUpdate[] = array('name'=> 'author_receives', 'value' => $_SESSION['USER']->user->hash_key);
				// Variables dataInsert
				$updateRead = array(
					'read_msg_receives' => 1,
				);
				$update = new BDD();
				$update->table('TABLE_MAILS');
				$update->where($whereUpdate);
				$update->update($updateRead);
			}
		}
	}

	public function readArchive ($mail_id)
	{
		if (strlen($_SESSION['USER']->user->hash_key) == 32) {
			$whereMail = array('name' => 'mail_id', 'value' => $mail_id);
			$sql = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryOne();
			$mail = $sql->data;
			$whereRead = array('name' => 'mail_id', 'value' => $mail_id);
			$read = New BDD();
			$read->table('TABLE_MAILS_MSG');
			$read->orderby(array(array('name' => 'id', 'type' => 'ASC')));
			$read->where($whereRead);
			$read->isObject(true);
			$read->queryAll();
			$return['data'] = $mail;
			$return['read'] = $read->data;
			return $return;
		}
	}

	public function getTestReply ($mail_id)
	{
		if (strlen($_SESSION['USER']->user->hash_key) == 32) {
			$whereMail = array('name' => 'mail_id', 'value' => $mail_id);
			$sql = New BDD();
			$sql->table('TABLE_MAILS');
			$sql->fields(array('archive_receives', 'archive_send', 'close_send', 'close_receives'));
			$sql->where($whereMail);
			$sql->isObject(true);
			$sql->queryOne();
			$mail = $sql->data;
			return $mail;
		}
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
			$fclose = fclose($fopen);
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

	public function sendReply ($data = null)
	{
		$return = array();
		if ($data == null) {  
			$return['text']	= constant('ERROR_NO_DATA');
			$return['type']	= 'error';
		} else {
			$whereAuthorSend[] = array(
				'name'  => 'author_send',
				'value' => $_SESSION['USER']->user->hash_key
			);
			$whereAuthorSend[] = array(
				'name'  => 'mail_id',
				'value' => $data['mail_id']
			);
			$getAuthorSend = New BDD();
			$getAuthorSend->table('TABLE_MAILS');
			$getAuthorSend->where($whereAuthorSend);
			$getAuthorSend->queryOne();
			$getAuthorSend = $getAuthorSend->data;

			if ($getAuthorSend == false) {
				$whereAuthorReveive[] = array(
					'name'  => 'author_receives',
					'value' => $_SESSION['USER']->user->hash_key
				);
				$whereAuthorReveive[] = array(
					'name'  => 'mail_id',
					'value' => $data['mail_id']
				);
				$getAuthorReveive = New BDD();
				$getAuthorReveive->table('TABLE_MAILS');
				$getAuthorReveive->where($whereAuthorReveive);
				$getAuthorReveive->queryOne();
				$getAuthorReveive = $getAuthorReveive->data;
				if ($getAuthorReveive != false) {
					// Variable et sécurisation
					$crypt           = $data['mail_id'];
					$author_send     = $_SESSION['USER']->user->hash_key;
					$author_receives = $getAuthorReveive->author_send;
					$message         = Common::VarSecure($data['message'], 'html');
					$message         = Common::crypt($message, $crypt);
					// Variable à entrer en BDD (Message)
					$insertMailsMsg = array(
						'mail_id'         => $crypt,
						'author_send'     => $author_send,
						'author_receives' => $author_receives,
						'message'         => $message
					);
					// Envoie les données en BDD MSG;
					$sqlMailsMsg = New BDD();
					$sqlMailsMsg->table('TABLE_MAILS_MSG');
					$sqlMailsMsg->insert($insertMailsMsg);
					// Change read_msg_receives = 0
					// Variables dataInsert
					$insertMailsMsg = array(
						'read_msg_send'     => 0,
						'read_msg_receives' => 1
					);
					$insert = new BDD();
					$insert->table('TABLE_MAILS');
					$insert->where($whereAuthorReveive);
					$insert->update($insertMailsMsg);
				}
			} else {
				$whereAuthorReveive[] = array(
					'name'  => 'author_send',
					'value' => $_SESSION['USER']->user->hash_key
				);
				$whereAuthorReveive[] = array(
					'name'  => 'mail_id',
					'value' => $data['mail_id']
				);
				$getAuthorReveive = New BDD();
				$getAuthorReveive->table('TABLE_MAILS');
				$getAuthorReveive->where($whereAuthorReveive);
				$getAuthorReveive->queryOne();
				$getAuthorReveive = $getAuthorReveive->data;
				if ($getAuthorReveive != false) {
					// Variable et sécurisation
					$crypt           = $data['mail_id'];
					$author_send     = $_SESSION['USER']->user->hash_key;
					$author_receives = $getAuthorReveive->author_send;
					$message         = Common::VarSecure($data['message'], 'html');
					$message         = Common::crypt($message, $crypt);
					// Variable à entrer en BDD (Message)
					$insertMailsMsg = array(
						'mail_id'         => $crypt,
						'author_send'     => $author_send,
						'author_receives' => $author_receives,
						'message'         => $message
					);
					// Envoie les données en BDD MSG;
					$sqlMailsMsg = New BDD();
					$sqlMailsMsg->table('TABLE_MAILS_MSG');
					$sqlMailsMsg->insert($insertMailsMsg);
					// Change read_msg_receives = 0
					// Variables dataInsert
					$insertMailsMsg = array(
						'read_msg_send'     => 1,
						'read_msg_receives' => 0
					);
					$insert = new BDD();
					$insert->table('TABLE_MAILS');
					$insert->where($whereAuthorReveive);
					$insert->update($insertMailsMsg);
				}
			}
		}
		$return['text']	= constant('MESSAGE_SUCCESS');
		$return['type']	= 'success';
		return $return;
	}

	public function sendArchive($data)
	{
		$return = array();
		if ($data == null) {  
			$return['text']	= constant('ERROR_NO_DATA');
			$return['type']	= 'error';
		} else {
			$data = Common::VarSecure($data, null);
			$whereAuthorSend[] = array(
				'name'  => 'author_send',
				'value' => $_SESSION['USER']->user->hash_key
			);
			$whereAuthorSend[] = array(
				'name'  => 'mail_id',
				'value' => $data
			);
			$whereAuthorReceives[] = array(
				'name'  => 'author_receives',
				'value' => $_SESSION['USER']->user->hash_key
			);
			$whereAuthorReceives[] = array(
				'name'  => 'mail_id',
				'value' => $data
			);
			$getAuthorSend = New BDD();
			$getAuthorSend->table('TABLE_MAILS');
			$getAuthorSend->where($whereAuthorSend);
			$getAuthorSend->queryOne();
			$getAuthorSend = $getAuthorSend->data;
			if (!empty($getAuthorSend)) {
				$update = array(
					'archive_send' => 1,
				);
				$insert = new BDD();
				$insert->table('TABLE_MAILS');
				$insert->where($whereAuthorSend);
				$insert->update($update);
			} else {
				$update = array(
					'archive_receives' => 1,
				);
				$insert = new BDD();
				$insert->table('TABLE_MAILS');
				$insert->where($whereAuthorReceives);
				$insert->update($update);
			}
		}
		$return['text']	= constant('MESSAGE_ARCHIVE_SUCCESS');
		$return['type']	= 'success';
		return $return;
	}

	public function sendRemove ($data)
	{
		$return = array();
		if ($data == null) {  
			$return['text']	= constant('ERROR_NO_DATA');
			$return['type']	= 'error';
		} else {
			$data = Common::VarSecure($data, null);
			$whereAuthorSend[] = array(
				'name'  => 'author_send',
				'value' => $_SESSION['USER']->user->hash_key
			);
			$whereAuthorSend[] = array(
				'name'  => 'mail_id',
				'value' => $data
			);
			$getAuthorSend = New BDD();
			$getAuthorSend->table('TABLE_MAILS');
			$getAuthorSend->where($whereAuthorSend);
			$getAuthorSend->queryOne();
			$getAuthorSend = $getAuthorSend->data;
			if ($getAuthorSend != false and $getAuthorSend->author_send == $_SESSION['USER']->user->hash_key) {
				$update = array(
					'close_send' => 1,
				);
				$sql = new BDD();
				$sql->table('TABLE_MAILS');
				$sql->where($whereAuthorSend);
				$sql->update($update);
			} else {
				$whereAuthorReceives[] = array(
					'name'  => 'author_receives',
					'value' => $_SESSION['USER']->user->hash_key
				);
				$whereAuthorReceives[] = array(
					'name'  => 'mail_id',
					'value' => $data
				);
				$updateReceives = array(
					'close_receives' => 1,
				);
				$sql = new BDD();
				$sql->table('TABLE_MAILS');
				$sql->where($whereAuthorReceives);
				$sql->update($updateReceives);
			}
			self::deleteAll($data);
			$return['text']	= constant('MESSAGE_DELETE_SUCCESS');
			$return['type']	= 'success';
			return $return;
		}
	}

	public function deleteAll ($mail_id = null)
	{
		if ($mail_id == null) {  
			$return['text']	= constant('ERROR_NO_DATA');
			$return['type']	= 'error';
		} else {
			$data = Common::VarSecure($mail_id, null);
			$user = $_SESSION['USER']->user->hash_key;
			$whereMail = 'WHERE `mail_id` = "'.$data.'" AND `close_send` = 1 AND `close_receives` = 1';
			$getAuthorSend = New BDD();
			$getAuthorSend->table('TABLE_MAILS');
			$getAuthorSend->where($whereMail);
			$getAuthorSend->queryOne();
			$getAuthorSend = $getAuthorSend->data;
			if ($getAuthorSend != false) {
				$whereMail = 'WHERE `mail_id` = "'.$data.'"';
				$sql = new BDD();
				$sql->table('TABLE_MAILS');
				$sql->where($whereMail);
				$sql->delete(); unset($sql);
				$sql = new BDD();
				$sql->table('TABLE_MAILS_MSG');
				$sql->where($whereMail);
				$sql->delete();
			}
		}
	}
}