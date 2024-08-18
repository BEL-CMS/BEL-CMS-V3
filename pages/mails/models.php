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
use function PHPSTORM_META\map;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_MAILS_STATUS
# id, mail_id, author, read_msg, receive, archive, close
# TABLE_MAIL_MSG 
#  	id, mail_id , author, message, upload , object , time_msg
final class Mails
{
	#########################################
	# Récupère les messages
	#########################################
	public function getAllMsg ()
	{
		#########################################
		$where[] = array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key);
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAILS_STATUS');
		$sql->where($where);
		$sql->queryAll();
		$data = $sql->data;
		unset($sql);
		#########################################
		foreach ($data as $k => $v) {
			if ($v->author != $_SESSION['USER']->user->hash_key) {
				unset($data[$k]);
			}
		}
		#########################################
		foreach ($data as $k => $v) {
			$data[$k]->msg = self::getMailsMsg($v->mail_id);
		}
		#########################################
		$return = $data;
		#########################################
		return $return;
		#########################################	
	}
	private function getMailsMsg ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_MAIL_MSG');
		$sql->where(array('name' => 'mail_id', 'value' => $id));
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#########################################
	# Récupère le status des messages par ID
	#########################################
	public function getStatus ($id)
	{
		#########################################
		$getAllMails = new BDD;
		$getAllMails->table('TABLE_MAILS_STATUS');
		$getAllMails->where(array('name' => 'mail_id', 'value' => $id));
		$getAllMails->queryOne();
		$return = $getAllMails->data;
		#########################################
		return $return;
		#########################################
	}
	#########################################
	# Envoie le message en BDD
	#########################################
	public function sendNew ($data)
	{
		#########################################
		$dir = constant('DIR_UPLOADS_MAILS');
		#########################################
		$insertMsg['mail_id'] = Common::randomString(32);
		$insertMsg['author']  = $_SESSION['USER']->user->hash_key;
		$insertMsg['message'] = Common::crypt($data['message'], $insertMsg['mail_id']);
		$insertMsg['subject'] = Common::VarSecure($data['subject'], null);
		if ($_FILES['upload']['error'] != 4) {
			Common::Upload ('upload', $dir);
			$insertMsg['upload'] = '/uploads/mails/'.$_FILES['upload']['name'];
		} else {
			$insertMsg['upload'] = '';
		}
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAIL_MSG');
		$sql->insert($insertMsg);
		unset($sql);
		#########################################
		$insertStatus['mail_id']     = $insertMsg['mail_id'];
		$insertStatus['author']      = $_SESSION['USER']->user->hash_key;
		$insertStatus['author_send'] = $data['author']->hash_key;
		$insertStatus['read_msg']    = 1;
		$insertStatus['archive']     = 1;
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAILS_STATUS');
		$sql->insert($insertStatus);
		unset($sql);
		#########################################
		$insertReveice['mail_id']     = $insertMsg['mail_id'];
		$insertReveice['author']      = $data['author']->hash_key;
		$insertReveice['author_send'] = $_SESSION['USER']->user->hash_key;
		$insertReveice['subject']     = Common::VarSecure($data['subject'], null);
		$insertReveice['read_msg']    = 0;
		$insertReveice['receive']     = 1;
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAILS_STATUS');
		$sql->insert($insertReveice);
		unset($sql);
		#########################################
		$return['text']	= constant('MESSAGE_SUCCESS');
		$return['type']	= 'success';
		#########################################
		return $return;
		#########################################
	}
	#########################################
	# Réponse mis en BDD
	#########################################
	public function reply ($data)
	{
		#########################################
		$dir = constant('DIR_UPLOADS_MAILS');
		#########################################
		$insertMsg['mail_id'] = $data['mail_id'];
		$insertMsg['author']  = $_SESSION['USER']->user->hash_key;
		$insertMsg['message'] = $data['message'];
		$insertMsg['subject'] = $data['subject'];
		if ($_FILES['upload']['error'] != 4) {
			Common::Upload ('upload', $dir);
			$insertMsg['upload'] = '/uploads/mails/'.$_FILES['upload']['name'];
		} else {
			$insertMsg['upload'] = '';
		}
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAIL_MSG');
		$sql->insert($insertMsg);
		unset($sql);
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAILS_STATUS');
		$sql->where(array('name' => 'mail_id', 'value' => $data['mail_id']));
		$sql->queryAll();
		
		foreach ($sql->data as $k => $v) {
			if ($v->author == $_SESSION['USER']->user->hash_key) {
				$update['read_msg'] = 1;
				$update['receive']  = 1;
				$update['archive']  = 1;
				$update['close']    = 0;
			} else {
				$update['read_msg'] = 0;
				$update['receive']  = 0;
				$update['archive']  = 0;
				$update['close']    = 0;
			}
			$sql = new BDD;
			$sql->table('TABLE_MAILS_STATUS');
			$where[] = array('name' => 'mail_id', 'value' => $data['mail_id']);
			$where[] = array('name' => 'author', 'value' => $v->author);
			$sql->where($where);
			$sql->update($update);
			unset($update, $sql, $where);
		}
		#########################################
		$return['text']	= constant('MESSAGE_SUCCESS');
		$return['type']	= 'success';
		#########################################
		return $return;
	}
	#########################################
	# Recherche un utilisateur par nom 
	# 3 lettre minimum
	#########################################
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
			#########################################
			$sql->whereLike($where);
			$sql->queryAll();
			$result = $sql->data;
			#########################################
			foreach ($result as $k => $v) {
				$user = User::getInfosUserAll($v->username);
				if ($v->username != $_SESSION['USER']->user->username) {
					$return[] = $v->username;
				}
			}
			#########################################
		}
		return $return;
	}
	#########################################
	# Récupere hash_key depuis username
	#########################################
	public function getHashKeyUser ($user = null)
	{
		$return = false;
		if ($user == null) {
			$return = false;
		} else {
			#########################################
			$user  = Common::VarSecure($user, null);
			$where = array(
				'name'  => 'username',
				'value' => $user
			);
			#########################################
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where($where);
			$sql->fields(array('hash_key'));
			$sql->queryOne();
			#########################################
			if (!empty($sql->data)) {
				$return = $sql->data;
			} else {
				$return = false;
			}
			#########################################
		}
		return $return;
	}
	#########################################
	# Récupere tous les messages par ID
	#########################################
	public function getAllMailfromID ($id)
	{
		#########################################
		$sql = new BDD;
		$sql->table('TABLE_MAIL_MSG');
		$sql->where(array('name' => 'mail_id', 'value' => $id));
		$sql->queryAll();
		$return = $sql->data;
		#########################################
		return $return;
		#########################################
	}
}