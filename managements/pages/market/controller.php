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

class Market extends AdminPages
{
	#########################################
	# Variables
	#########################################
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $models = 'ModelsMarket';
	#########################################
	# Premiere page avec le rendu de la page index.php
	#########################################
	public function index ()
	{
		$menu[] = array(HOME       => array('href'=>'/market?management&pages','icon'=>'fa fa-home'));
		$menu[] = array(PAYMENT    => array('href'=>'/market/payment?management&pages','icon'=>'fa fa-solid fa-comment-dollar'));
		$menu[] = array(ADD        => array('href'=>'/market/add?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array(CATEGORIES => array('href'=>'/market/categories?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array(CONFIG     => array('href'=>'/market/parameter?management&pages','icon'=>'fa fa-cubes'));
		$data['data'] = $this->models->getBuy();
		foreach ($data['data'] as $key => $value):
			$data['data'][$key]->cat = $this->models->getCat($value->id);
		endforeach;
		$this->set($data);
		$this->render('index', $menu);
	}
	#########################################
	# Page Ajouter un objet / une vente
	#########################################
	public function add ()
	{
		$menu[] = array(HOME       => array('href'=>'/market?management&pages','icon'=>'fa fa-home'));
		$menu[] = array(CATEGORIES => array('href'=>'/market/categories?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array(CONFIG     => array('href'=>'/market/parameter?management&pages','icon'=>'fa fa-cubes'));
		$data['cat'] = $this->models->getAllCat();
		$this->set($data);
		$this->render('add', $menu);
	}
	#########################################
	# Page Ajouter un objet / une vente enregistrement en BDD
	#########################################
	public function sendadd ()
	{
		$return = $this->models->sendBuy ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/market?management&pages', 2);
	}
	#########################################
	# Supprime une catégorie
	#########################################
	public function delcat ($data)
	{
		$return = $this->models->delcat ($data);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/market/categories?management&pages', 2);
	}

	#########################################
	# Page vu des Catégorie
	#########################################
	public function categories ()
	{
		$menu[] = array(HOME   => array('href'=>'/market?management&pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'/market/addcat?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'/market/parameter?management&pages','icon'=>'fa fa-cubes'));
		$data['cat'] = $this->models->getAllCat();
		$this->set($data);
		$this->render('cat', $menu);
	}
	#########################################
	# Page Ajouter une Catégorie
	#########################################
	public function addcat ()
	{
		$menu[] = array(HOME   => array('href'=>'/market?management&pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD    => array('href'=>'/add/addcat?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array(CONFIG => array('href'=>'/market/parameter?management&pages','icon'=>'fa fa-cubes'));
		$d['groups'] = BelCMSConfig::getGroups();
		$this->set($d);
		$this->render('addcat', $menu);
	}
	#########################################
	# Editer une Catégorie
	#########################################
	public function editcat ($id)
	{
		$d['data']   = current($this->models->getCat($id));
		$d['groups'] = BelCMSConfig::getGroups();
		$this->set($d);
		$this->render('editcat');
	}
	#########################################
	# Editer une Catégorie - Insert en BDD
	#########################################
	public function sendEditCat ()
	{
		$return = $this->models->sendeditcat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/market?management&pages', 2);
	}
	#########################################
	# Ajouter une Catégorie en BDD
	#########################################
	public function sendCategorie ()
	{
		$return = $this->models->sendaddCat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/market?management&pages', 2);
	}
	#########################################
	# Editer une vente
	#########################################
	public function editbuy ($id)
	{
		$data['data'] = $this->models->getBuy($id);
		$data['cat']  = $this->models->getAllCat();
		$this->set($data);
		$this->render('editbuy');	
	}
	#########################################
	# Envoye une edition en BDD
	#########################################
	public function sendEditbuy ()
	{
		$return = $this->models->sendEditBuy ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('/market?management&pages', 2);	
	}
	#########################################
	# Liste des payement
	#########################################
	public function payment ()
	{
		$menu[] = array(HOME       => array('href'=>'/market?management&pages','icon'=>'fa fa-home'));
		$menu[] = array(ADD        => array('href'=>'/market/add?management&pages','icon'=>'fa fa-plus'));
		$menu[] = array(CATEGORIES => array('href'=>'/market/categories?management&pages','icon'=>'fa fa-cogs'));
		$menu[] = array(CONFIG     => array('href'=>'/market/parameter?management&pages','icon'=>'fa fa-cubes'));
		$this->render('payment', $menu);
	}
}