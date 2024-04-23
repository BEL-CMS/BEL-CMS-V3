<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Contact extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsContact';

	public function index ()
	{
		$data['contact'] = $this->models->getAllEmail ();
		$this->set($data);
		$this->render('index');
	}

	public function view ()
	{
		$id = (int) $this->id;
		$data['mail'] = $this->models->getEmail ($id);
		$this->set($data);
		$this->render('view');
	}

	public function replySend ()
	{
		$return = $this->models->saveReply ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News?management&option=pages', 2);
		$this->redirect('Contact?management&option=parameter', 2);
	}

	public function viewreply ()
	{
		$id = (int) $this->id;
		$data['reply'] = $this->models->viewreply ($id);
		$this->set($data);
		$this->render('savereply');
	}
}