<?php
/**
 * Bel-CMS [Content management system]
 * @version 2.1.0
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2022 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Team extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsTeam';

	public function index ()
	{
		$data['data'] = $this->models->getTeam ();
		$data['count'] = count($data['data']);
		$this->set($data);
		$menu[] = array('Accueil'=> array('href'=>'team?management&gaming=true','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'Team/addTeam?management&gaming=true','icon'=>'fa fa-plus'));
		$this->render('index', $menu);
	}

	public function addTeam ()
	{
		$data['game'] = $this->models->getGames ();
		$this->set($data);
		$this->render('add');
	}

	public function edit ($id)
	{
		if ($id && is_numeric($id)) {
			$data['data'] = $this->models->getTeam ($id);
			$data['game'] = $this->models->getGames ();
			$this->set($data);
			$this->render('edit');
		}
	}

	public function sendEdit ()
	{
		$return = $this->models->SendEdit ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect('team?management&gaming=true', 2);
	}

	public function sendAdd ()
	{
		if (empty($_POST)) {
			$this->error(get_class($this), 'Champ vide', 'warning');
		} else {
			$return = $this->models->SendAdd ($_POST);
			$this->error(get_class($this), $return['msg'], $return['type']);
			$this->redirect('team?management&gaming=true', 2);
		}
	}

	public function player ($id)
	{
		if ($id && is_numeric($id)) {
			$data['team'] = $this->models->getTeam ($id);
			$data['user'] = $this->models->getUsers ();
			$userTeam = $this->models->getUsersTeam ($id);
			foreach ($userTeam as $k => $v) {
				$data['userTeam'][] = $v->author;
			}
			if (empty($userTeam)) {
				$data['userTeam'] = array();
			}
			$this->set($data);
			$menu[] = array('Accueil'=> array('href'=>'/team?management&gaming=true','icon'=>'fa fa-home'));
			$menu[] = array('Configurations'=> array('href'=>'/Team/cobfig?management&gaming=true','icon'=>'fa fas fa-plus'));
			$this->render('player', $menu);
		}
	}

	public function playerEdit ()
	{
		$return = $this->models->sendPlayerEdit ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect(true, 0);
	}

	public function del ($id)
	{
		if ($id && is_numeric($id)) {
			$return = $this->models->del ($id);
			$this->error(get_class($this), $return['msg'], $return['type']);
			$this->redirect('team?management&gaming=true', 2);
		}
	}
}