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

use BelCMS\Core\Interaction;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Newsletter extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd = 'ModelsNewsletter';
	#####################################
	# liste des utilisateurs inscrit
	#####################################
	public function index ()
	{
		$set['data'] = $this->models->getUsersNewsletter ();
		$menu[] = array(constant('HOME')   => array('href'=>'newsletter?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'newsletter/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('TPL')    => array('href'=>'newsletter/tpl?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'newsletter/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
	}
	#####################################
	# Liste des templates
	#####################################
	public function tpl ()
	{
		$set['data'] = $this->models->getTpl();
		$menu[] = array(constant('HOME')   => array('href'=>'newsletter?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'newsletter/addtpl?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$this->set($set);
		$this->render('tpl', $menu);
	}
	#####################################
	# Création d'un template
	#####################################
	public function addtpl ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'newsletter/tpl?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addtpl', $menu);
	}
	#####################################
	# Edition du template
	#####################################
	public function edittpl ()
	{
		$id = $this->data[2];
		if (is_numeric($id)) {
			$menu[] = array(constant('HOME') => array('href'=>'newsletter/tpl?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$set['data'] = $this->models->getTpl ($id);
			$this->set($set);
			$this->render('edittpl', $menu);
		} else {
			$this->error(get_class($this), constant('ID_ERROR'), 'ERROR');
			$this->redirect('newsletter?management&option=pages', 2);
			new Interaction ('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
	}
	#####################################
	# Enregistrement en BDD du template
	#####################################
	public function sendnewtpl ()
	{
		$return = $this->models->sendNewTpl ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('newsletter/tpl?management&option=pages', 2);
	}
	#####################################
	# Edition du TPL en BDD
	#####################################
	public function sendeditpl ()
	{
		$return = $this->models->sendeditpl($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('newsletter/tpl?management&option=pages', 2);
	}
	#####################################
	# Suppression du TPL
	#####################################
	public function deltpl ()
	{
		if (is_numeric($this->data[2])) {
			$return = $this->models->deltpl($this->data[2]);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('newsletter/tpl?management&option=pages', 2);
		} else {
			$this->error(get_class($this), constant('ID_ERROR'), 'ERROR');
			$this->redirect('newsletter/tpl?management&option=pages', 2);
			new Interaction ('error'), constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
	}
	#####################################
	# Voir le template uniquement !
	#####################################
	public function viewtpl ()
	{
		$id = $this->id;
		if (is_numeric($id)) {
			$menu[] = array(constant('HOME') => array('href'=>'newsletter/tpl?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$return['data'] = $this->models->getTpl($id);
			$this->set($return);
			$this->render('viewtpl', $menu);
		} else {
			$this->error(get_class($this), constant('ID_ERROR'), 'ERROR');
			$this->redirect('newsletter/tpl?management&option=pages', 2);
			new Interaction ('error'), constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
	}
	#####################################
	# Voir les envoies
	#####################################
	public function add ()
	{
		$menu[] = array(constant('HOME_NEWSLETTER') => array('href'=>'newsletter?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('HOME') => array('href'=>'newsletter/add?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('PREPA') => array('href'=>'newsletter/prepa?management&option=pages','icon'=>'mgc_mail_send_fill', 'color' => 'btn bg-secondary text-white'));
		$return['data'] = $this->models->getAdd();
		$this->set($return);
		$this->render('add', $menu);
	}
	#####################################
	# Préparation du e-mail
	#####################################
	public function prepa ()
	{
		if (!isset($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE']) or empty($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'])) {
			$this->error(get_class($this), 'Aucun é-mail d\'envoie définit', constant('WARNING'));
			$this->redirect('prefgen?management&option=parameter', 2);	
		} else {
			$set['groups'] = Config::getGroups();
			$set['tpl']    = $this->models->getTpl();
			$menu[] = array(constant('HOME') => array('href'=>'newsletter/add?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$this->set($set);
			$this->render('prepa', $menu);
		}
	}
	#####################################
	# Préparation du e-mail en BDD
	#####################################
	public function sendprepa ()
	{
		$return = $this->models->sendPrepa($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('newsletter/add?management&option=pages', 2);
	}
	#####################################
	# Envoie les e-mails
	#####################################
	public function sendMails ()
	{
		$id = $this->id;
		if (is_numeric($id)) {
			$return = $this->models->sendMails ($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('newsletter/add?management&option=pages', 2);
		} else {
			$this->error(get_class($this), constant('ID_ERROR'), 'ERROR');
			$this->redirect('newsletter/add?management&option=pages', 2);
			new Interaction ('error'), constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
	}
	#####################################
	# Affiche-les paramètre
	#####################################
	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME')   => array('href'=>'newsletter?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'newsletter/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('parameter', $menu);
	}
	#####################################
	# Sauvegarde les paramètres
	#####################################
	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('newsletter?management&option=pages', 2);
	}
}