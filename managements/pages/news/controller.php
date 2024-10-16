<?php
/**
 * Bel-CMS [Content management system]
 * @version 4.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license MIT License
 * @copyright 2015-2025 Bel-CMS
 * @author as Stive - stive@determe.be
*/

use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class News extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsNews';

	public function index ()
	{
		$data['data'] = $this->models->getAllNews();
		$this->set($data);
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT')    => array('href'=>'News/Cat?management&option=pages','icon'=>'mgc_align_horizontal_center_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
	}

	public function edit ($id)
	{
		$id = (int) $this->data[2];
		$data['data'] = $this->models->getNews($id);
		$data['cat'] = $this->models->getCat();
		$this->set($data);
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT')    => array('href'=>'News/Cat?management&option=pages','icon'=>'mgc_align_horizontal_center_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('edit', $menu);
	}
	

	public function sendedit ()
	{
		$return = $this->models->sendEdit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News?management&option=pages', 2);
	}

	public function Cat ()
	{
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/addcat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getCat();
		$this->set($data);
		$this->render('cat', $menu);
	}

	public function addcat ()
	{
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT')    => array('href'=>'News/Cat?management&option=pages','icon'=>'mgc_align_horizontal_center_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('sendcat', $menu);
	}

	public function sendnewcat ()
	{
		$return = $this->models->sendnewcat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News/Cat?management&option=pages', 2);
	}

	public function editcat ()
	{
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CAT')    => array('href'=>'News/Cat?management&option=pages','icon'=>'mgc_align_horizontal_center_fill', 'color' => 'bg-warning text-white'));
		$id = (int) $this->id;
		$data['cat'] = $this->models->getcatId ($id);
		$this->set($data);
		$this->render('editcat', $menu);	
	}

	public function sendeditcat ()
	{
		$return = $this->models->sendeditcat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News/Cat?management&option=pages', 2);
	}

	public function delcat ()
	{
		$id = (int) $this->id;
		$return = $this->models->senddelcat ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News/Cat?management&option=pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News/parameter?management&option=pages', 2);
	}

	public function add ()
	{
		$data['cat'] = $this->models->getCat();
		$this->set($data);
		$menu[] = array(constant('HOME')   => array('href'=>'News?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'News/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'News/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('new',$menu);
	}

	public function sendnew ()
	{
		$return = $this->models->sendnew($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News?management&option=pages', 2);
	}

	public function del ()
	{
		$return = $this->models->delete($this->data[2]);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('News?management&option=pages', 2);
	}
}