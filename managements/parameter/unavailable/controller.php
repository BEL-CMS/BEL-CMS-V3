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

class Unavailable extends AdminPages
{
	var $admin     = true; // Admin suprême uniquement (Groupe 1);
	var $active    = true;
	var $models    = 'ModelsUnavailable';

	public function index ()
	{
		$data['data'] = $this->models->getMaintenance();
		$this->set($data);
		$this->render('index');
	}

	public function sendpostOpen ()
	{
		$return = $this->models->openClose($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('unavailable?management&option=parameter', 0);
	}

	public function sendpost ()
	{
		$return = $this->models->sendpost($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('unavailable?management&option=parameter', 2);
	}

}