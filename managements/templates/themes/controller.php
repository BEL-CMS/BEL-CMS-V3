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

class Themes extends AdminPages
{
	var $admin     = true; // Admin suprême uniquement (Groupe 1);
	var $active    = true;
	var $models    = 'ModelsThemes';

	public function index ()
	{
		$menu[] = array('Accueil'=> array('href'=>'/themes?management&option=templates','icon'=>'fa fa-home'));
		$menu[] = array('Dimension'=> array('href'=>'/themes/dim?management&option=templates','icon'=>'fa fa-solid fa-arrows-left-right-to-line'));

		$actual = $this->models->getTplActive();
		$actual = $actual->value;
		$screen = $this->models->getTplImg();

		$return = array();

		$data = $this->models->getTpl();
		foreach ($data as $k => $n) {
			$return[$n] = array();
		}
		foreach ($return as $name => $value):

			$return[$name]['name'] = $name;

			if (array_key_exists($name, $screen)):
				$return[$name]['screen'] = $screen[$name];
			endif;

			if (strtolower($name) == strtolower($actual)):
				$return[$name]['active'] = true;
			else:
				$return[$name]['active'] = 0;
			endif;

			$d = $this->models->getInfos($name);
			if ($d):
				$return[$name]['creator']     = $d['creator'];
				$return[$name]['description'] = $d['description'];
				$return[$name]['version']     = $d['version'];
				$return[$name]['date']        = $d['date'];
			else:
				$return[$name]['creator']     = null;
				$return[$name]['description'] = null;
				$return[$name]['version']     = null;
				$return[$name]['date']        = null;	
			endif;

		endforeach;

		$data['themes'] = $return;

		$this->set($data);
		$this->render('index', $menu);
	}

	public function send ($data)
	{
		$return = $this->models->sendTpl($data);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('themes?management&option=templates', 2);
	}

	public function dim ()
	{
		foreach ($this->models->searchPages() as $k => $v) {
			$p[] = trim($v);
		}
		$data['pages']  = $p;
		$scan           = Common::ScanDirectory('pages', true);
		foreach ($scan as $a) {
			if ($a != 'managements') {
				$d[] = trim($a);
			}
		}
		$data['scan']   = $d;
		$this->set($data);
		$this->render('dim');
	}

	public function sendpages ()
	{
		$return = $this->models->sendPages($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('themes/dim?management&option=templates', 2);	
	}
}