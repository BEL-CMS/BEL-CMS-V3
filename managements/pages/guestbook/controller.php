<?php
use BelCMS\Core\Config;
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

class guestbook extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd    = 'ModelsGuestbook';

    public function index ()
    {
        $data['data'] = $this->models->getUser();
        $this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'guestbook?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'guestbook/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
    }

    public function edit ()
    {
        $d['data'] = $this->models->getEdit($this->id);
        $this->set($d);
        $this->render('edit');
    }

    public function sendedit ()
    {
        $return = $this->models->sendEdit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Guestbook?management&option=pages', 2);
    }

	public function del ()
	{
		$return = $this->models->sendDel($this->data[2]);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Guestbook?management&option=pages', 2);
	}

	#########################################
	# Paramètre de la page
	#########################################
	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'guestbook?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}
	#########################################
	# Enregistrer les paramètres
	#########################################
	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('guestbook?management&option=pages', 2);
	}
}