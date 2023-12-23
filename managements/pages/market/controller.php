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
use BelCMS\Requires\Common;

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
	# __construct crée le dossier uploads/market
	# s'il n'existe pas
	#########################################
	public function __construct()
	{
		parent::__construct();
		$dir = 'uploads/market';
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('Failed to create directory');
			} else {
				$fopen  = fopen($dir.'/index.html', 'a+');
				fclose($fopen);
			}
		}
		$dirCat = 'uploads/market/cat';
		if (!file_exists($dirCat)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('Failed to create directory');
			} else {
				$fopen  = fopen($dir.'/index.html', 'a+');
				fclose($fopen);
			}
		}
	}
	#########################################
	# Premiere page avec le rendu de la page index.php
	#########################################
	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('PAYMENT') => array('href'=>'market/payment?management&option=pages','icon'=>'mgc_currency_euro_2_fill', 'color' => 'btn bg-info text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'market/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'market/categories?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('DISCOUNT_COUPON') => array('href'=>'market/discount?management&option=pages','icon'=>'mgc_barcode_line', 'color' => 'bg-danger/25 text-danger'));
		$menu[] = array(constant('CONFIG') => array('href'=>'market/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getBuy();
		$this->set($data);
		$this->render('index', $menu);
	}
	#########################################
	# Page Ajouter un objet / une vente
	#########################################
	public function add ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['cat'] = $this->models->getAllCat();
		$this->set($data);
		$this->render('add', $menu);
	}
	#########################################
	# Page Ajouter un objet,
	# une vente enregistrement en BDD.
	#########################################
	public function sendadd ()
	{
		$return = $this->models->sendBuy ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market?management&option=pages', 2);
	}
	#########################################
	# Page Ajouter des images à une vente.
	#########################################
	public function addImgBuy ()
	{
		$set['id'] = (int) $this->data['2'];
		$this->set($set);
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('img', $menu);
	}
	#########################################
	# Ajouter en BDD et UPLOADS les images.
	#########################################
	public function sendimg ()
	{
		$id = (int) $_GET['id'];
		return json_encode($this->models->sendImg ($id));
	}
	#########################################
	# Supprime une catégorie
	#########################################
	public function delcat ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delcat ($id);
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
			$v->groups_name = explode('|', $v->user_groups);
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
		$this->redirect('market/categories?management&option=pages', 2);
	}
	#########################################
	# Editer une vente
	#########################################
	public function editbuy ()
	{
		$id = (int) $this->data[2];
		$data['data'] = $this->models->getBuy($id);
		$data['img']  = $this->models->getImg($id);
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
		$this->redirect('market?management&option=pages', 2);	
	}
	#########################################
	# Liste des payement
	#########################################
	public function payment ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'market/categories?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'market/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getPayment ();
		$this->set($data);
		$this->render('payment', $menu);
	}
	#########################################
	# Paramètre de la page
	#########################################
	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}
	#########################################
	# Enregistrer les paramètres
	#########################################
	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market?management&option=pages', 2);
	}
	#########################################
	# Get Coupon
	#########################################
	public function discount ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD_DISCOUNT') => array('href'=>'market/addDiscnount?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-warning text-white'));
		$return['discount'] = $this->models->getDiscount();
		$this->set($return);
		$this->render('discount', $menu);
	}
	#########################################
	# ajouter un coupon de réduction
	#########################################
	public function addDiscnount ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market/discount?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addDiscount', $menu);
	}
	#########################################
	# Ajouter en BDD la réduction
	#########################################
	public function sendaddDiscount ()
	{
		$return = $this->models->sendaddDiscount($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/discount?management&option=pages', 2);
	}
	#########################################
	# Editer le coupon de réduction
	#########################################
	public function editDiscount ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market/discount?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$id = (int) $this->data[2];
		$return['discount'] = $this->models->editDiscount($id);
		$this->set($return);
		$this->render('editDiscount', $menu);
	}
	#########################################
	# Update la BDD le coupon de réduction
	#########################################
	public function sendEditDiscount ()
	{
		$return = $this->models->sendEditDiscount($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/discount?management&option=pages', 2);
	}
	#########################################
	# Supprime le coupon de réduction par ID
	#########################################
	public function delDiscount ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDelDiscount($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/discount?management&option=pages', 2);
	}
	#########################################
	# Change le status de livraison en Attente
	#########################################
	public function attLivriason ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendAttLivraison($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/payment?management&option=pages', 2);
	}
	#########################################
	# Change le status de livraison en Attente
	#########################################
	public function livraisonOk ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendLivraisonOk($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/payment?management&option=pages', 2);
	}

	public function delInvoice ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delLivraison($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('market/payment?management&option=pages', 2);
	}

	public function detail ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'market/payment?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$id = (int) $this->data[2];
		$return['detail'] = $this->models->detail($id);
		$this->set($return);
		$this->render('detail', $menu);
	}
}
