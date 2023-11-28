<?php
use BelCMS\Core\Config;
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

class Groups extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd = 'ModelGroups';

	public function index ()
	{
		$data['groups'] = Config::getGroups();
		$menu[] = array(constant('HOME') => array('href'=>'groups?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'groups/add?management&option=users','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'groups?management&option=users','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('new', $menu);
	}

	public function sendnew ()
	{
		$return = $this->models->sendnew($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('groups?management&option=users', '2');
	}

	public function detele ()
	{
		$id = (int) $this->data[2];
		if ($id == 1 or $id == 2) {
			$this->error(get_class($this), constant('NO_POSSIBLE_GROUPS'), 'error');
			$this->redirect('groups?management&option=users', '1');
		} else {
			$return = $this->models->delete($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('groups?management&option=users', '1');
			return $return;	
		}
	}

	public function edit ()
	{
		$id = (int) $this->data[2];
		$data['data'] = $this->models->edit($id);
		$this->set($data);
		$this->render('edit');
	}

	public function sendedit ()
	{
		$return = $this->models->sendedit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('groups?management&option=users', '1');
		return $return;
	}
}