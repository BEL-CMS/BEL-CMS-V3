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

class Comments extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsComments';

	public function index ()
	{
		$var = $this->models->getAllComments();
		if (!empty($var)):
			$data['comments'] = $var;
		else:
			$data['comments'] = null;
		endif;
		$this->set($data);
		$this->render('index');
	}

	public function edit ()
	{
		$data['comments'] = $this->models->getComment($this->id);
		$this->set($data);
		$this->render('edit');
	}

	public function sendedit ()
	{
		$return = $this->models->sendedit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/comments?management&option=pages', 2);
	}

	public function del ($id)
	{
		$return = $this->models->del($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/comments?management&option=pages', 2);
	}
}