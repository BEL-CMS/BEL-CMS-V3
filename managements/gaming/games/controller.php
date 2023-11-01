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

class Games extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsGames';

	public function index ()
	{
		$data['data'] = $this->models->getGames();
		$data['count'] = count($data['data']);
		$this->set($data);
		$menu[] = array('Accueil'=> array('href'=>'/games?management&gaming=true','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/games/add?management&gaming=true','icon'=>'fa fa-plus'));
		$this->render('index', $menu);;
	}

	public function add ()
	{
		$this->render('add');
	}

	public function addGame ()
	{
		$return = $this->models->addGame ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect('games?management&gaming=true', 2);
	}

	public function edit ($id)
	{
		$data['data'] = $this->models->getGames($id);
		$this->set($data);
		$this->render('edit');
	}

	public function editGame ()
	{
		$return = $this->models->editGame ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect('games?management&gaming=true', 2);
	}

	public function delGame ($id = null)
	{
		if ($id && is_numeric($id)) {
			$return = $this->models->delGame($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('games?management&gaming=true', 2);
		}
	}
}