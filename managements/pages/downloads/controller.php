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

class Downloads extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $models = 'ModelsDownloads';

	public function index ()
	{
		$d['data']  = $this->models->getAllDl();
		$d['count'] = count($d['data']);
		$this->set($d);
		$menu[] = array('Accueil'=> array('href'=>'/downloads?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter'=> array('href'=>'/downloads/add?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array('Catégories'=> array('href'=>'/downloads/cat?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array('Configuration'=> array('href'=>'/downloads/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('index', $menu);
	}

	public function add ()
	{
		$cat = $this->models->getCat();
		$countCat = count($cat);

		if ($countCat == 0):
			$this->error(get_class($this), 'Une catégorie est obligatoire', 'warning');
			$this->redirect('/downloads/addcat?management&pages', 2);
		else:
			$d['cat'] = $cat;
			$this->set($d);
			$this->render('add');
		endif;
	}

	public function edit ($id = null)
	{
		$cat = $this->models->getCat();
		$countCat = count($cat);
		if ($countCat == 0):
			$this->error(get_class($this), 'Une catégorie est obligatoire', 'warning');
			$this->redirect('/downloads/addcat?management&pages', 2);

		else:
			$d['data'] = $this->models->getDL($id);
			$d['cat']  = $cat;
			$this->set($d);
			$this->render('edit');
		endif;
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/downloads?management&pages', 2);
	}

	public function del ($id)
	{
		$id = (int) $id;
		$return = $this->models->del($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/downloads?management&pages', 2);
	}

	public function cat ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/downloads?management&pages','icon'=>'fa fa-home'));
		$menu[] = array('Ajouter Catégorie'=> array('href'=>'/downloads/addcat?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array('Catégories'=> array('href'=>'/downloads/cat?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array('Configuration'=> array('href'=>'/downloads/parameter?management&pages','icon'=>'fa fa-cubes'));

		$d['data']  = $this->models->getCat();
		$d['count'] = count($d['data']);
		$this->set($d);
		$this->render('cat', $menu);
	}

	public function addcat ()
	{
		$d['groups'] = BelCMSConfig::getGroups();
		$this->set($d);
		$this->render('addcat');
	}

	public function sendnewcat ()
	{
		if ($this->models->testName($_POST['name'])):
			$return = $this->models->sendnewcat($_POST);
			$this->error(get_class($this), $return['text'], $return['type']);
		else:
			$this->error(get_class($this), 'Le nom de la catégorie à déjà été pris', 'warning');
		endif;
		$this->redirect('/downloads/cat?management&pages', 2);
	}

	public function editcat ($id)
	{
		$d['data']   = current($this->models->getCat($id));
		$d['groups'] = BelCMSConfig::getGroups();
		$this->set($d);
		$this->render('editcat');
	}

	public function sendeditcat ()
	{
		$return = $this->models->sendeditcat($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/downloads/cat?management&pages', 2);
	}

	public function delcat ($id)
	{
		$return = $this->models->delcat($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/downloads/cat?management&pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = BelCMSConfig::getGroups();
		$data['config'] = BelCMSConfig::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array('Accueil'=> array('href'=>'/downloads?management&pages','icon'=>'fa fa-home'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/downloads?management&pages', 2);
	}

}