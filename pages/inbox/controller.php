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

class Inbox extends Pages
{
	#####################################
	# Declaration variables
	#####################################
	var $models = 'ModelsInbox';
	#####################################
	# Get Index page for inbox
	#####################################
	public function index ()
	{
		if (Users::isLogged() === true) {
			$set['inbox'] = $this->models->getMessages();
			$this->set($set);
			$this->render('index');
		}
	}
	#####################################
	# Get message for inbox
	#####################################
	public function showMessage($id)
	{
		if (!is_numeric($id)) {
			$this->error(INBOX, ERROR_NO_ID, 'error');
		} else {
			$set = $this->models->showMessage($id);
			if (array_key_exists('type', $set) && array_key_exists('text', $set)) {
				$this->error(INBOX, $set['text'], $set['type']);
			} else {
				if (count($set) == 0) {
					$this->error(INBOX, ERROR_NO_MESSAGE_EXIST, 'error');
				} else {
					$set['inbox'] = $this->models->showMessage($id);
					$this->set($set);
					$this->render('show');
				}
			}
		}
	}
	#####################################
	# Get Users for new message
	#####################################
	public function getUsers ()
	{
		$search = $_GET['term'];
		echo json_encode(array('username' => $this->ModelsInbox->getUsers($search)));
	}
	#####################################
	# Send
	#####################################
	public function send ()
	{
		if (Users::isLogged() === true) {
			if ($this->data['send'] == 'new') {
				self::sendNewMessage();
			} else if ($this->data['send'] == 'reponse') {
				self::sendReponse();
			}
		}
	}
	#####################################
	# Send new message
	#####################################
	private function sendNewMessage ()
	{
		$return = $this->models->sendNewMessage($this->data['username'], $this->data['message']);
		$this->error(INBOX, $return['text'], $return['type']);
		$this->redirect('Inbox', 2);
	}
	#####################################
	# Send reponse message
	#####################################
	private function sendReponse ()
	{
		$return = $this->models->sendReponse($this->data['id'], $this->data['message']);
		$this->error(INBOX, $return['text'], $return['type']);
		$redirect = 'Inbox/ShowMessage/'.$return['id'];
		$this->redirect($redirect, 2);
	}
	#####################################
	# Get count message
	#####################################
	public function countUnreadMessage()
	{
		if (Users::isLogged() === true) {
			echo json_encode($this->models->countUnreadMessage());
		}
	}
}
