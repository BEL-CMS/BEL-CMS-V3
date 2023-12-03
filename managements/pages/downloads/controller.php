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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Downloads extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsDownloads';

	public function __construct()
	{
		parent::__construct();
		$dir = 'uploads/downloads';
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('Failed to create directory');
			} else {
				$fopen  = fopen($dir.'/index.html', 'a+');
				fclose($fopen);
			}
		}
	}
	public function index ()
	{
		$d['data']  = $this->models->getAllDl();
		$d['count'] = count($d['data']);
		$this->set($d);
		$menu[] = array(constant('HOME') => array('href'=>'downloads?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'downloads/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'downloads/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'downloads/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
	}

	public function add ()
	{
		$cat = $this->models->getCat();
		$countCat = count($cat);

		if ($countCat == 0):
			$this->error(get_class($this), 'Une catégorie est obligatoire', 'warning');
			$this->redirect('downloads/addcat?management&option=pages', 2);
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
			$this->redirect('downloads?management&option=pages', 2);

		else:
			$d['data'] = $this->models->getDL($this->id);
			$d['cat']  = $cat;
			$this->set($d);
			$this->render('edit');
		endif;
	}

	public function sendedit ()
	{
		$return = $this->models->sendedit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads?management&option=pages', 2);
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads?management&option=pages', 2);
	}

	public function del ($id)
	{
		$id = (int) $this->id;
		$return = $this->models->del($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads?management&option=pages', 2);
	}

	public function cat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'downloads?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADDCAT') => array('href'=>'downloads/addcat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'downloads/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));

		$d['data']  = $this->models->getCat();
		$d['count'] = count($d['data']);
		$this->set($d);
		$this->render('cat', $menu);
	}

	public function addcat ()
	{
		$d['groups'] = Config::getGroups();
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
		$this->redirect('downloads/cat?management&option=pages', 2);
	}

	public function editcat ($id)
	{
		$d['data']   = current($this->models->getCat($id));
		$d['groups'] = Config::getGroups();
		$this->set($d);
		$this->render('editcat');
	}

	public function sendeditcat ()
	{
		$return = $this->models->sendeditcat($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads/cat?management&pages', 2);
	}

	public function delcat ()
	{
		$return = $this->models->delcat($this->id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads/cat?management&option=pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'downloads?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('downloads?management&option=pages', 2);
	}

}