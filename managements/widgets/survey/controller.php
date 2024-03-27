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

class Survey extends AdminPages
{
	var $active    = true;
	var $bdd       = 'ModelsSurvey';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'survey?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'survey/add?management&option=widgets','icon'=>'mgc_baby_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'survey/parameter?management&option=widgets','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$d['data'] = $this->models->getSurvey();
		$this->set($d);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'survey?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('add', $menu);
	}

	public function sendNew ()
	{
		$return = $this->models->sendNew ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('survey?management&option=widgets', 2);
	}
}