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

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Registration extends AdminPages
{
	var $admin     = true; // Admin suprême uniquement (Groupe 1);
	var $active    = true;
	var $bdd       = 'ModelsUsers';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'registration?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('VALIDATION') => array('href'=>'registration/validation?management&option=users','icon'=>'mgc_department_fill', 'color' => 'bg-warning text-white'));
		$data['user'] = $this->models->getAllUsers();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function validation()
	{
		$menu[] = array(constant('HOME') => array('href'=>'registration?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['user'] = $this->models->getAllUsersValid();
		$this->set($data);
		$this->render('valid', $menu);
	}

	public function Ban ()
	{
		$id      = Common::hash_key($this->data['2']) ? $this->data['2'] : false;
		$user    = User::getInfosUserAll($id);
		$author  = $id;
		$ipBan   = $user->user->ip;
		$reason  = constant('FALSE_USER');
		$email   = $user->user->mail;

		$data = array(
			'author' => $author,
			'ip_ban' => $ipBan,
			'date'   => 'P99Y',
			'reason' => $reason,
			'email'  => $email
		);

		$return = $this->models->sendaddBan ($data);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/validation?management&option=users', 3);
	}

	public function edit ()
	{
		$data['user'] = User::getInfosUserAll($this->id);
		$this->set($data);
		$this->render('edition');
	}

	public function del ($id)
	{
		if (Common::hash_key($id)) {
			if ($id == $_SESSION['USER']->user->hash_key) {
				$this->error(get_class($this), 'Vous ne pouvez pas vous efacer vous même', 'error');
				return;
			}
		}
	}

	public function sendPrivate ($id = null)
	{
		$return = $this->models->sendPrivate($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/?management&option=users', 2);
	}

	public function sendMainGroup ()
	{
		$return = $this->models->sendMainGroup($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/?management&option=users', 2);
	}

	public function sendSecondGroup ()
	{
		$return = $this->models->sendSecondGroup($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/?management&option=users', 2);
	}

	public function sendSocial ()
	{
		$return = $this->models->sendSocial($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/?management&option=users', 2);
	}

	public function sendInfoPublic ()
	{
		$return = $this->models->sendInfoPublic($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('registration/?management&option=users', 2);
	}
}