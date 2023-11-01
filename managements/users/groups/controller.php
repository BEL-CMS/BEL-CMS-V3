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

class Groups extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $models = 'ModelGroups';

	public function index ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/groups?management&users','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/groups/add?management&users','icon'=>'fa fa-plus'));
		$this->render('index', $menu);
	}

	public function add ()
	{
		$menu[] = array('Accueil'=> array('href'=>'groups?management&users','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/groups/add?management&users','icon'=>'fa fa-plus'));
		$this->render('new', $menu);
	}

	public function sendnew ()
	{
		$return = $this->models->sendnew($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/groups?management&users', '2');
	}

	public function detele ($id)
	{
		$id = (int) $id;
		if ($id == 1 or $id == 2) {
			$this->error(get_class($this), 'Impossible de supprimer ce groupe', 'error');
			$this->redirect('/groups?management&users', '1');
		} else {
			$return = $this->models->delete($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('/groups?management&users', '1');
			return $return;	
		}
	}

	public function edit ($id)
	{
		$id = (int) $id;
		$data['data'] = $this->models->edit($id);
		$this->set($data);
		$this->render('edit');
	}

	public function sendedit ()
	{
		if (isset($POST['id']) and $_POST == 1 or isset($POST['id']) and $_POST == 2) {
			$this->error(get_class($this), 'Impossible d\'editer ce groupe', 'warning');
			$return = $this->models->sendedit($_POST);
			$this->redirect('/groups?management&users', '1');
		} else {
			$return = $this->models->sendedit($_POST);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('/groups?management&users', '1');
		}
		return $return;
	}
}