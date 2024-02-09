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

class Links extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd    = 'ModelsLinks';

	#########################################
	# index de la page recupere les liens
	#########################################
	public function index ()
	{
		$data['data'] = $this->models->getLinks();
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'links/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'links/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('VALIDATED') => array('href'=>'links/valid?management&option=pages','icon'=>'mgc_anticlockwise_alt_fill', 'color' => 'bg-yellow-100 text-yellow-500'));
		$menu[] = array(constant('CONFIG') => array('href'=>'links/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->set($data);
		$this->render('index', $menu);
	}
	#########################################
	# Ajoute des liens
	#########################################
	public function add ()
	{
		$data['cat'] = $this->models->getCat();
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'links/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'links/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->set($data);
		$this->render('add', $menu);
	}
	#########################################
	# Envoie les liens vers la BDD
	#########################################
	public function sendadd ()
	{
		$return = $this->models->sendadd($_POST);
        $this->redirect('links?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
	}
	#########################################
	# Vu des câtégories
	#########################################
	public function cat ()
	{
		$data['cat'] = $this->models->getCat();
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD_CAT') => array('href'=>'links/addCat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'links/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->set($data);
		$this->render('cat', $menu); 
    }
	#########################################
	# Ajouter une catégorie
	#########################################
    public function addCat ()
    {
		$menu[] = array(constant('HOME') => array('href'=>'links/cat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addcat', $menu);
    }
	#########################################
	# Editer une catégorie
	#########################################
	public function editcat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'links/cat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$id = (int) $this->data[2];
		$data['cat'] = $this->models->getCat($id);
		$this->set($data);
		$this->render('editcat', $menu);
	}
	#########################################
	# Enregistre la catégorie
	#########################################
	public function sendeditcat ()
	{
        $return = $this->models->neweditCat($_POST);
        $this->redirect('links/cat?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
	}
	#########################################
	# Enregistre la catégorie en BDD
	#########################################
    public function sendaddcat ()
    {
        $return = $this->models->newCat($_POST);
        $this->redirect('links/cat?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
    }
	#########################################
	# Efface une catégorie
	#########################################
	public function delcat ()
	{
		$id = (int) $this->data[2];
        $return = $this->models->delCat($id);
        $this->redirect('links?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
	}
	#########################################
	# Editer un lien
	#########################################
	public function edit ()
	{
		$id = (int) $this->data[2];
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['cat']  = $this->models->getCat();
		$data['data'] = $this->models->getLinks($id);
		$this->set($data);
		$this->render('edit', $menu);
	}
	#########################################
	# Efface une catégorie dans la BDD
	#########################################
	public function sendedit ()
	{
        $return = $this->models->sendedit($_POST);
        $this->redirect('links?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
	}
	#########################################
	# Efface un lien
	#########################################
	public function del ()
	{
		$id = (int) $this->data[2];
        $return = $this->models->del($id);
        $this->redirect('links?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
	}

	public function valid ()
	{
		$data['data'] = $this->models->getLinks(true);
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->set($data);
		$this->render('index', $menu);	
	}
	#########################################
	# Les parametres
	#########################################
	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'links?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}
	#########################################
	# Enregistre les parametre
	#########################################
	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('links?management&option=pages', 2);
	}
}