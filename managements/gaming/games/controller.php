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

use BelCMS\Core\Config;

class Games extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsGames';

	function __construct()
	{
		parent::__construct();
		$dir = 'uploads/games/';
		if (!file_exists($dir)) {
			if (!mkdir($dir, 0777, true)) {
				throw new Exception('Failed to create directory');
			} else {
				$fopen  = fopen($dir.'/index.html', 'a+');
				fclose($fopen);
			}
		}
	}
	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'games?management&option=gaming','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'games/add?management&option=gaming','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'games/parameter?management&option=gaming','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data']  = $this->models->getGames();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function add ()
	{
		$this->render('add');
	}

	public function addGame ()
	{
		$return = $this->models->addGame ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect('games?management&option=gaming', 2);
	}

	public function edit ()
	{
		$id = (int) $this->data[2];
		$menu[] = array(constant('HOME') => array('href'=>'games?management&option=gaming','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['data'] = $this->models->getGames($id);
		$this->set($data);
		$this->render('edit', $menu);
	}

	public function editGame ()
	{
		$return = $this->models->editGame ($_POST);
		$this->error(get_class($this), $return['msg'], $return['type']);
		$this->redirect('games?management&option=gaming', 2);
	}

	public function delGame ()
	{
		$id = (int) $this->data[2];
		if ($id && is_numeric($id)) {
			$return = $this->models->delGame($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('games?management&option=gaming', 2);
		}
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$menu[] = array(constant('HOME') => array('href'=>'games?management&option=gaming','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->set($data);
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('games?management&option=gaming', 2);
	}
}