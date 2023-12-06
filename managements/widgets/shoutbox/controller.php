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

use BelCMS\Core\Config;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Shoutbox extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd    = 'ModelsShoutbox';
	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'shoutbox?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('EMOTICONS') => array('href'=>'shoutbox/emoticone?management&option=widgets','icon'=>'mgc_baby_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'shoutbox/parameter?management&option=widgets','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$menu[] = array(constant('DELETE_ALL_MSG') => array('href'=>'shoutbox/deleteall?management&option=widgets','icon'=>'mgc_delete_2_fill', 'color' => 'text-white bg-danger'));
		$data['data']  = $this->models->getAllMsg();
		$data['count'] = $this->models->getNbMsg();
		$this->set($data);
		$this->render('index', $menu);
	}

	public function emoticone ()
	{	
		$data['imo'] = $this->models->getImo();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'shoutbox?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));;
		$this->render('emoticone', $menu);
	}

	public function sendemo ()
	{
		$return = $this->models->sendemo ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('shoutbox/emoticone?management&option=widgets', 2);
	}

	public function delimo ()
	{
		$id = (int) $this->data['2'];
		if ($id > 0) {
			$return = $this->models->deleteImo($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('shoutbox/emoticone?management&option=widgets', 2);
		} else {
			$this->redirect('shoutbox/emoticone?management&option=widgets', 1);
		}
	}

	public function edit ()
	{
		$id = (int) $this->data['2'];
		$data['data'] = $this->models->getMsg($id);
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'shoutbox?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('edit', $menu);
	}

	public function sendedit ()
	{
		$return = $this->models->sendEdit($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Shoutbox?management&option=widgets', 2);
	}

	public function delete ($id)
	{
		$return = $this->models->delete($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Shoutbox?management&option=widgets', 2);
	}

	public function deleteall ()
	{
		$return = $this->models->deleteAll();
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Shoutbox?management&option=widgets', 2);
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigWidgets(get_class($this));
		$data['pages']  = Common::ScanDirectory(constant('DIR_PAGES'));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'shoutbox?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('EMOTICONS') => array('href'=>'shoutbox/emoticone?management&option=widgets','icon'=>'mgc_baby_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('DELETE_ALL_MSG') => array('href'=>'shoutbox/deleteall?management&option=widgets','icon'=>'mgc_delete_2_fill', 'color' => 'text-white bg-danger'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Shoutbox?management&option=widgets', 2);
	}

}