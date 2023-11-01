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

class Gallery extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsGallery';

	public function index ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/gallery?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/gallery/add?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array('Câtegories'=> array('href'=>'/gallery/cat?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array('Configuration'=> array('href'=>'/gallery/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('index', $menu);
	}

	public function add ()
	{
		$this->render('add');
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/gallery?management&pages', 2);
	}

	public function parameter ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/gallery?management&pages','icon'=>'fa fa-home'));
		$data['groups'] = BelCMSConfig::getGroups();
		$data['config'] = BelCMSConfig::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/gallery?management&pages', 2);
	}

	public function cat ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/gallery?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/gallery/add?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array('Configuration'=> array('href'=>'/gallery/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('cat', $menu);
	}

}