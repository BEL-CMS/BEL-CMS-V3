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

use BelCMS\Core\Config;
use BelCMS\Core\Secures;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Articles extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd = 'ModelsArticles';

	public function index ()
	{
		$set['data'] = $this->models->getPages();
		foreach ($set['data'] as $key => $value) {
			if (Secures::IsAcess($value->groups) == false) {
				unset($set['data'][$key]);
			}
		}
		$this->set($set);
		$menu[] = array(constant('HOME') => array('href'=>'Articles?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'Articles/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'Articles/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
	}

	public function getpage ()
	{
		$id = (int) $this->id;
		$menu[] = array(constant('HOME') => array('href'=>'Articles?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'Articles/addsubpage/'.$id.'/?management&option=pages', 'icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('DEL_ALL') => array('href'=>'Articles/deleteAll/'.$id.'/?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$set['data'] = $this->models->getPagecontent($id);
		$set['name'] = $this->models->getPage($id)->name;
		$set['id']   = (int) $id;
 		$this->set($set);
		$this->render('page', $menu);
	}

	public function add ()
	{
		$data['groups'] = Config::getGroups();
		$this->set($data);
		$this->render('addpage');
	}

	public function edit ()
	{
		$id = (int) $this->id;
		$set['groups'] = Config::getGroups();
		$set['data']   = $this->models->getPage($id);
		$menu[] = array('Accueil'=> array('href'=>'Articles?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Configuration'=> array('href'=>'Articles/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('edit', $menu);
	}

	public function sendnew ()
	{
		if (empty($_POST['name'])) {
			$this->error(get_class($this), 'Aucun nom', 'error');
			$this->redirect('Articles?management&option=pages', 2);
		} else {
			$return = $this->models->addNewPage($_POST);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('Articles?management&option=pages', 2);			
		}
	}

	public function sendedit ()
	{
		$return = $this->models->sendedit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}

	public function addsubpage ()
	{
		$id = (int) $this->id;
		$set['data'] = $this->models->getPage($id);
		$this->set($set);
		$this->render('subpage');
	}

	public function sendnewsub ()
	{
		$return = $this->models->sendnewsub ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}

	public function subpageedit ()
	{
		$id = (int) $this->id;
		$set['data'] = $this->models->getPagecontentId($id);
		$this->set($set);
		$this->render('subpageedit');
	}

	public function sendeditsub ()
	{	
		$return = $this->models->sendeditsub ($_POST);		
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}

	public function delsubpage ()
	{
		$id = (int) $this->id;
		$return = $this->models->deletesub($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}

	public function deleteAll ()
	{
		$id = (int) $this->id;
		$return = $this->models->deleteAll($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter');
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Articles?management&option=pages', 2);
	}
}