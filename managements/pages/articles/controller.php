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

class Articles extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsArticles';

	public function index ()
	{
		$data['data'] = $this->models->getAllArticles();
		$this->set($data);
		$menu[] = array(HOME   => array('href'=>'/Articles?management&option=pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'/articles/add?management&option=pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'Articles/parameter?management&option=pages','icon'=>'fa fa-cubes'));
		$this->render('index', $menu);
	}

	public function edit ($id)
	{
		$data['data'] = $this->models->getArticles($id);
		$this->set($data);
		$menu[] = array(HOME   => array('href'=>'articles?management&option=pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'articles/add?management&option=pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'Articles/parameter?management&option=pages','icon'=>'fa fa-cubes'));
		$this->render('edit', $menu);
	}

	public function sendedit ()
	{
		$return = $this->models->sendEdit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('articles?management&option=pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = BelCMSConfig::getGroups();
		$data['config'] = BelCMSConfig::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(HOME   => array('href'=>'articles?management&option=pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'articles/add?management&option=pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'Articles/parameter?management&option=pages','icon'=>'fa fa-cubes'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles/parameter?management&option=pages', 2);
	}

	public function add ()
	{
		$menu[] = array(HOME   => array('href'=>'articles?management&option=pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'articles/add?management&option=pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'articles/parameter?management&option=pages','icon'=>'fa fa-cubes'));
		$this->render('new',$menu);
	}

	public function sendnew ()
	{
		$return = $this->models->sendnew($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('articles?management&option=pages', 2);
	}

	public function del ($id)
	{
		$return = $this->models->delete($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('articles?management&option=pages', 2);
	}
}