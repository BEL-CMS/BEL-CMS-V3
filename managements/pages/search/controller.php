<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Search extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd = 'ModelsSearch';
	#####################################
	# liste de A à Z
	#####################################
	public function index ()
	{
		$menu[] = array(constant('HOME')   => array('href'=>'Search?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')    => array('href'=>'Search/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'Search/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));

        $set['data'] = $this->models->getLetter ();
        $this->set($set);
		$this->render('index', $menu);
	}
	#####################################
	# Ajouter un descriptif à une lettre
	##################################### 
    public function add ()
    {
		$menu[] = array(constant('HOME')   => array('href'=>'Search?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'Search/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
        $this->render('new', $menu);
    }
    public function sendadd()
    {
        $data['title']   = Common::VarSecure($_POST['title']);
        $data['letter']  = Common::VarSecure($_POST['letter']);
        $data['content'] = Common::VarSecure($_POST['content'], 'html');
        $return = $this->models->sendNewLetter ($data);
        $this->redirect('Search?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
    }
	#####################################
	# Supprimer une lettre avec sa définition
	##################################### 
    public function del ()
    {
        $id = (int) $this->id;
        $return = $this->models->RemoveLetter ($id);
        $this->redirect('Search?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
    }
	#####################################
	# Parametre
	##################################### 
	public function parameter ()
	{
        $menu[] = array(constant('HOME')   => array('href'=>'Search?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter', $menu);
	}
	#####################################
	# Envoi les paramètre à la BDD
	##################################### 
	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Search?management&option=pages', 2);
	}
}