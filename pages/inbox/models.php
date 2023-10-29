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

final class ModelsInbox
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_INBOX
	# TABLE_INBOX_MSG
	#####################################
	# Get Users min letter >= 2
	#####################################
	public function getUsers($user = null)
	{
		$return = array();
		# check if user >= 2 letter
		if (strlen($user) >= 2) {
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
				$username = Users::hashkeyToUsernameAvatar($_SESSION['USER']['HASH_KEY']);
				if ($v->username != $username) {
					$return[] = $v->username;
				}
			}

		}

		return $return;
	}
	#####################################
	# Get User if exist
	#####################################
	private function isExistUser ($username) {

		$return = false;
		# check if username not empty
		if ($username !== null) {
			# check if username exist and return hash_key
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->fields(array('hash_key'));
			$where = array(
				'name' => 'username',
				'value' => $username
			);
			$sql->where($where);
			$sql->queryOne();
			$count = $sql->rowCount;

			if ($count == 1) {
				$return = $sql->data;
				$return = $return->hash_key;
			}

		}

		return $return;
	}
	#####################################
	# Send new message
	#####################################
	public function sendNewMessage ($username = null, $message = null)
	{

		$return = false;
		# check if user exist
		$isExistUser = self::isExistUser($username);
		# check if hash_key 32 letter
		if ($isExistUser && strlen($isExistUser) == 32) {
			# check user != yourself
			if ($isExistUser == $_SESSION['USER']['HASH_KEY']) {
				$return['text']	= ERROR_BE_SAME;
				$return['type']	= 'error';
				return $return;
			}
			# insert main BDD
			# data
			$dataInbox = array(
				'username' => $_SESSION['USER']['HASH_KEY'],
				'usersend' => $isExistUser,
			);
			$sqlInbox = New BDD();
			$sqlInbox->table('TABLE_INBOX');
			$sqlInbox->insert($dataInbox);
			# get id insert
			$idInsert = $sqlInbox->lastId;
			# insert msg BDD
			# data
			$dataMsg = array(
				'id_msg' => (int) $idInsert,
				'username' => $isExistUser,
				'message' => Common::VarSecure($message, 'html'),
				'status' => (int) 0
			);
			$sqlMsg = New BDD();
			$sqlMsg->table('TABLE_INBOX_MSG');
			$sqlMsg->insert($dataMsg);
			# check insert BDD INBOX and INBOX MSG
			if ($sqlInbox->rowCount == 1 && $sqlMsg->rowCount == 1) {
				$return['text']	= MESSAGE_SUCCESS;
				$return['type']	= 'success';
			} else {
				$return['text']	= ERROR_INSERT_BDD;
				$return['type']	= 'error';
			}

		} else {
			$return['text']	= ERROR_NO_USER;
			$return['type']	= 'error';
		}
		# return
		return $return;
	}
	#####################################
	# get message yourself
	#####################################
	public function getMessages()
	{
		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_INBOX');
		if (strlen($_SESSION['USER']['HASH_KEY']) != 32) {
			return array();
		}
		$where = 'WHERE username = "'.$_SESSION['USER']['HASH_KEY'].'" OR usersend = "'.$_SESSION['USER']['HASH_KEY'].'"';
		$sql->where($where);
		$sql->queryAll();

		foreach ($sql->data as $k => $v) {
			$v->username = Users::hashkeyToUsernameAvatar($v->username);
			$v->usersend = Users::hashkeyToUsernameAvatar($v->usersend);
			$sqlLastMessage = New BDD();
			$sqlLastMessage->table('TABLE_INBOX_MSG');
			$sqlLastMessage->where(
				array(
					'name'  => 'id_msg',
					'value' => (int) $v->id
				)
			);
			$sqlLastMessage->orderby(
				array(
					array(
						'name' => 'date_msg',
						'type' => 'DESC'
					)
				)
			);
			$sqlLastMessage->limit(1);
			$sqlLastMessage->queryOne();
			$return[$k] = $v;
			$sqlLastMessage->data->message = Common::VarSecure($sqlLastMessage->data->message, null);
			$sqlLastMessage->data->username = Users::hashkeyToUsernameAvatar($sqlLastMessage->data->username);
			$return[$k]->lastmessage = $sqlLastMessage->data;
		}

		return $return;
	}
	#####################################
	# get all message for id
	#####################################
	public function showMessage($id = false)
	{
		$return = array();
		$id     = Common::SecureRequest($id);
		# check hash_key valid
		if (strlen($_SESSION['USER']['HASH_KEY']) != 32) {
			return array();
		}
		# get id user and usersend
		$get = New BDD();
		$get->table('TABLE_INBOX');
		$get->fields(array('username', 'usersend'));
		$get->where(
			array(
				'name'  => 'id',
				'value' => $id
			)
		);
		$get->queryOne();
		$getId = array();
		$getId[] = $get->data->username;
		$getId[] = $get->data->usersend;
		# check user in username and usersend
		if (!in_array($_SESSION['USER']['HASH_KEY'], $getId)) {
			$return['text']	= ERROR_HASH_KEY_MSG;
			$return['type']	= 'error';
			return $return;
			# @todo include BDD : intrusion unauthorized
		}
		# get message for id
		$sql = New BDD();
		$sql->table('TABLE_INBOX_MSG');
		$sql->where(
			array(
				'name'  => 'id_msg',
				'value' => $id
			)
		);
		$sql->orderby(
			array(
				array(
					'name' => 'date_msg',
					'type' => 'ASC'
				)
			)
		);
		$sql->queryAll();
		foreach ($sql->data as $k => $v) {
			if ($k <= 0) {
				$user = (object) array();
				$user->username = Users::hashkeyToUsernameAvatar($get->data->usersend);
				$user->avatar = Users::hashkeyToUsernameAvatar($get->data->usersend, 'avatar');
				$sql->data[$k]->origin = $user;
				$sql->data[$k]->to = Users::hashkeyToUsernameAvatar($get->data->username);
			}
		}
		self::changeStatus($id);
		$return = $sql->data;

		return $return;
	}
	#####################################
	# send reponse message
	#####################################
	public function sendReponse($id = null, $message = null)
	{
		$return = array();
		$id     = Common::SecureRequest($id);
		# check message empty
		if (empty($message)) {
			$return['text']	= ERROR_EMPTY_MSG;
			$return['type']	= 'error';
			return $return;
		}
		# insert msg BDD
		# data
		$data = array(
			'id_msg' => (int) $id,
			'username' => $_SESSION['USER']['HASH_KEY'],
			'message' => Common::VarSecure($message, 'html'),
			'status' => (int) 0
		);
		$sql = New BDD();
		$sql->table('TABLE_INBOX_MSG');
		$sql->insert($data);
		# check insert INBOX MSG
		if ($sql->rowCount == 1) {
			$return['text']	= MESSAGE_SUCCESS;
			$return['type']	= 'success';
		} else {
			$return['text']	= ERROR_INSERT_BDD;
			$return['type']	= 'error';
		}

		$return['id'] = $id;

		return $return;
	}
	#####################################
	# change status for message
	#####################################
	private function changeStatus($id)
	{
		$id = Common::SecureRequest($id);
		$sql = New BDD();
		$sql->table('TABLE_INBOX_MSG');
		$where[] = array(
			'name'  => 'id_msg',
			'value' => $id
		);
		$where[] = array(
			'name'  => 'username',
			'value' => $_SESSION['USER']['HASH_KEY']
		);
		$sql->where($where);
		$sql->update(array('status' => 1));
	}
	#####################################
	# Get count message
	#####################################
	public function countUnreadMessage ()
	{
		$return = (int) 0;

		$sql = New BDD();
		$sql->table('TABLE_INBOX_MSG');
		$where[] = array(
			'name'  => 'username',
			'value' => $_SESSION['USER']['HASH_KEY']
		);
		$where[] = array(
			'name'  => 'status',
			'value' => 0
		);
		$sql->where($where);
		$sql->count();

		$return = (int) $sql->data;

		return $return;
	}

}
