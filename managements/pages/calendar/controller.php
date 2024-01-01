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

class Calendar extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd = 'ModelsCalendar';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'calendar?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'calendar/add?management&option=pages','icon'=>'mgc_add_circle_line', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CATEGORY') => array('href'=>'calendar/addcat?management&option=pages','icon'=>'mgc_codepen_line', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'calendar/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getEvents();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'calendar?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CATEGORY') => array('href'=>'calendar/addcat?management&option=pages','icon'=>'mgc_codepen_line', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'calendar/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('add', $menu);
	}

	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('calendar?management&option=pages', 2);
	}

	public function addcat ()
	{
		$this->render('cat');
	}

	public function sendnewcat()
	{
		$return = $this->models->sendnewcat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('calendar?management&option=pages', 2);
	}

	public function getEvents ()
	{
		$return = $this->models->getEvents();
		echo json_encode($return);
	}
}