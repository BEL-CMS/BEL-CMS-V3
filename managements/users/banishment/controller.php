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

class Banishment extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd    = 'ModelsBan';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'banishment?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'banishment/add?management&option=users','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$data['ban'] = $this->models->getUsersBan();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'banishment?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['author'] = $this->models->getUsers();
		$this->set($data);
		$this->render('add', $menu);
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('banishment?management&option=users', 3);
	}

	public function del ($id)
	{
		$id = (int) $this->data[2];
		$return = $this->models->del($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('banishment?management&option=users', 3);
	}
}