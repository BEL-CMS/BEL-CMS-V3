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

class Page extends AdminPages
{
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsPage';

	public function index ()
	{
		$set['data'] = $this->models->getPages();
		foreach ($set['data'] as $key => $value) {
			if (Secures::IsAcess($value->groups) == false) {
				unset($set['data'][$key]);
			}
		}
		$this->set($set);
		$menu[] = array('Accueil'=> array('href'=>'/page?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Configuration'=> array('href'=>'/page/parameter?management&pages','icon'=>'fa fa-cubes'));
		$menu[] = array(ADD=> array('href'=>'/page/add?management&pages','icon'=>'fa fa-plus'));
		$this->render('index', $menu);
	}

	public function getpage ($id = false)
	{
		$set['data'] = $this->models->getPagecontent($id);
		$set['name'] = $this->models->getPage($id)->name;
		$set['id']   = (int) $id;
 		$this->set($set);
		$this->render('page');
	}

	public function add ()
	{
		$data['groups'] = BelCMSConfig::getGroups();
		$this->set($data);
		$this->render('addpage');
	}

	public function edit ($id)
	{
		$id = (int) $id;
		$set['groups'] = BelCMSConfig::getGroups();
		$set['data']   = $this->models->getPage($id);
		$this->set($set);
		$menu[] = array('Accueil'=> array('href'=>'/page?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Configuration'=> array('href'=>'page/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('edit', $menu);
	}

	public function sendnew ()
	{
		if (empty($_POST['name'])) {
			$this->error(get_class($this), 'Aucun nom', 'error');
			$this->redirect('page?management&page', 2);
		} else {
			$return = $this->models->addNewPage($_POST);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('page?management&pages', 2);			
		}
	}

	public function sendedit ()
	{
		$return = $this->models->sendedit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('page?management&pages', 2);
	}

	public function addsubpage ($id)
	{
		$set['data'] = $this->models->getPage($id);
		$this->set($set);
		$this->render('subpage');
	}

	public function sendnewsub ()
	{
		$return = $this->models->sendnewsub ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('page?management&pages', 2);
	}

	public function subpageedit ($id)
	{
		$id = (int) $id;
		$set['data'] = $this->models->getPagecontentId($id);
		$this->set($set);
		$this->render('subpageedit');
	}

	public function sendeditsub ()
	{	
		$return = $this->models->sendeditsub ($_POST);		
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('page?management&pages', 2);
	}

	public function delsubpage ($id = false)
	{
		$id = (int) $id;
		$return = $this->models->deletesub($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('page?management&pages', 2);
	}

	public function deleteAll ($id)
	{
		$id  = (int) $id;
		$return = $this->models->deleteAll($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('page?management&pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = BelCMSConfig::getGroups();
		$data['config'] = BelCMSConfig::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter');
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Page?management&page=true', 2);
	}
}