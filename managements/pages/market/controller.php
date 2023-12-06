<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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

class Market extends AdminPages
{
	#########################################
	# Variables
	#########################################
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd    = 'ModelsMarket';
	#########################################
	# Premiere page avec le rendu de la page index.php
	#########################################
	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('PAYMENT') => array('href'=>'market/payment?management&option=pages','icon'=>'mgc_currency_euro_2_fill', 'color' => 'btn bg-info text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'market/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'market/categories?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'market/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
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
		$cat = $this->models->getAllCat();
		if (!empty($cat)) {
			$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$data['cat'] = $this->models->getAllCat();
			$this->set($data);
			$this->render('add', $menu);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('NO_CAT')
			);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('market/addcat?management&option=pages', 2);
		}
	}
	#########################################
	# Page Ajouter un objet / une vente enregistrement en BDD
	#########################################
	public function sendadd ()
	{
		$return = $this->models->sendBuy ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market?management&option=pages', 2);
	}
	#########################################
	# Supprime une catégorie
	#########################################
	public function delcat ($data)
	{
		$return = $this->models->delcat ($data);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/categories?management&option=pages', 2);
	}

	#########################################
	# Page vu des Catégorie
	#########################################
	public function categories ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD_CAT') => array('href'=>'market/addcat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-warning text-white'));
		$groups = config::getGroups();
		$data['cat'] = $this->models->getAllCat();
		foreach ($data['cat'] as $k => $v) {
			$v->groups_name = explode('|', $v->groups);
			foreach ($v->groups_name as $k2 => $v2) {
				$g = Config::getGroupsForID($v2);
				$v->groups_name[$k2] = defined($g->name) ? constant($g->name) : $g->name;
			}
		}
		$this->set($data);
		$this->render('cat', $menu);
	}
	#########################################
	# Page Ajouter une Catégorie
	#########################################
	public function addcat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$d['groups'] = Config::getGroups();
		$this->set($d);
		$this->render('addcat', $menu);
	}
	#########################################
	# Editer une Catégorie
	#########################################
	public function editcat ()
	{
		$id = (int) $this->data[2];
		$d['data']   = $this->models->getCat($id);
		debug($d);
		$d['groups'] = Config::getGroups();
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
		$this->redirect('market/categories?management&option=pages', 2);
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
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'market/categories?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'market/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('payment', $menu);
	}
}