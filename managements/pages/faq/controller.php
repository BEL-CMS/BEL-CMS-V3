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

class FAQ extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsFAQ';

	public function index ()
	{
		$data['faq'] = $this->models->getFAQ();
		$menu[] = array(constant('HOME') => array('href'=>'faq?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'faq/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'faq/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'faq/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->set($data);
		$this->render('index', $menu);
	}

	public function cat ()
	{
		$data['cat'] = $this->models->getCat();
		$menu[] = array(constant('HOME') => array('href'=>'faq?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'faq/addCat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$this->set($data);
		$this->render('cat', $menu);
	}

	public function add ()
	{
		$cat = $this->models->getCat();
		$countCat = count($cat);
		if ($countCat == 0) {
			$this->error(get_class($this), constant('CAT_IS_REQUIRED'), 'warning');
			$this->redirect('faq/addcat?management&option=pages', 2);
		} else {
			$data['cat'] = $cat;
			$this->set($data);
			$menu[] = array(constant('HOME') => array('href'=>'faq?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$this->render('add', $menu);
		}
	}

	public function sendadd ()
	{
		$return = $this->models->sendQuest ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq?management&option=pages', 2);
	}

	public function edit ()
	{
		$cat = $this->models->getCat();
		$countCat = count($cat);
		if ($countCat == 0) {
			$this->error(get_class($this), constant('CAT_IS_REQUIRED'), 'warning');
			$this->redirect('faq/addcat?management&option=pages', 2);
		} else {
			$id = (int) $this->data['2'];
			$data['faq'] = $this->models->getFAQ($id);
			$data['cat'] = $cat;
			$this->set($data);
			$menu[] = array(constant('HOME') => array('href'=>'faq?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$this->render('edit', $menu);
		}
	}

	public function del ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDel ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq?management&option=pages', 2);	
	}

	public function editadd ()
	{
		$return = $this->models->sendEdit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq?management&option=pages', 2);
	}

	public function addCat()
	{
		$menu[] = array(constant('HOME') => array('href'=>'faq/cat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addcat', $menu);
	}

	public function sendaddcat ()
	{
		$return = $this->models->sendAddCat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq/cat?management&option=pages', 2);	
	}

	public function editcat ()
	{
		$id = (int) $this->data['2'];
		$data['cat'] = $this->models->getCat($id);
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'faq/cat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('editcat', $menu);
	}

	public function sendeditcat ()
	{
		$return = $this->models->sendEditCat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq/cat?management&option=pages', 2);	
	}

	public function delcat ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDelCat ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq/cat?management&option=pages', 2);	
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'faq?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('faq?management&option=pages', 2);
	}
}