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

class Ban extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $models = 'ModelsBan';

	public function index ()
	{
		$menu[] = array('Accueil'=> array('href'=>'ban?management&option=users','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'ban/add?management&option=users','icon'=>'fa fa-plus'));
		$data['ban'] = $this->models->getUsersBan();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$data['author'] = $this->models->getUsers();
		$menu[]         = array('Accueil'=> array('href'=>'ban?management&option=users','icon'=>'fa fa-home'));
		$this->set($data);
		$this->render('add', $menu);
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('ban?management&option=users', 3);
	}

	public function del ($id)
	{
		$return = $this->models->del($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('ban?management&option=users', 3);
	}
}