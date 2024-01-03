<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Gallery extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd    = 'ModelsGallery';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'gallery/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'gallery/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getImg();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$data['cat'] = $this->models->GetNameCat(null);
		$this->set($data);
		$this->render('add');
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}

	public function edit ()
	{
		$id = (int) $this->data[2];
		$data['data'] = $this->models->getImg($id);
		$data['cat'] = $this->models->GetNameCat(null);
		$this->set($data);
		$this->render('edit');
	}

	public function sendEdit ()
	{
		$return = $this->models->sendEdit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}

	public function del ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDel ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}

	public function parameter ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}

	public function cat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'gallery/addCat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->GetNameCat(null);
		$this->set($data);
		$this->render('cat', $menu);
	}

	public function addCat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addcat', $menu);
	}

	public function sendaddcat ()
	{
		$return = $this->models->sendAddCat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}

	public function editCat ()
	{
		$id = (int) $this->data[2];
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$d['data'] = $this->models->GetNameCat($id);
		$this->set($d);
		$this->render('editcat', $menu);
	}

	public function sendEditCat ()
	{
		$return = $this->models->sendEditCat($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}

	public function delcat ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delcat($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}
}