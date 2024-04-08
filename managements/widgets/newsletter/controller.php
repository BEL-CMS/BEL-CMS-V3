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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Newsletter extends AdminPages
{
	var $active    = true;
	var $bdd       = 'ModelsNewsletter';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'newsletter?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('TPL') => array('href'=>'newsletter/tpl?management&option=widgets','icon'=>'mgc_baby_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'newsletter/parameter?management&option=widgets','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data']  = $this->models->getAllUsers();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function tpl ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'newsletter?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADDTPL') => array('href'=>'newsletter/addtpl?management&option=widgets','icon'=>'mgc_baby_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'newsletter/parameter?management&option=widgets','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data']  = $this->models->getAllTpl();
		$this->set($data);
		$this->render('tpl', $menu);
	}

	public function addtpl ()
	{
		$this->render('addtpl');
	}

	public function sendNewTpl ()
	{
		$this->models->sendtpl ($_POST);
	}
}