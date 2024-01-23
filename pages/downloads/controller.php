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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Core\Secures;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Downloads extends Pages
{
	var $useModels = 'Downloads';

	public function index ()
	{	
		// Déclaration des variables.
		$get['data'] = array();
		$data = (object) array();
		$i    = 0;
		// Récupère-les données des catégories.
		$data = $this->models->getCat();
		// Tableau, liste les catégories et supprime ceux que l'utilisateur n'a pas accès.
		foreach ($data as $a => $b) {
			$i++;
			if (Secures::isAcess($b->id_groups) == false) {
				unset($data[$a]);
			} else {
				$get['data'][$i] = (object) array();
				$get['data'][$i]->id     = $b->id;
				$get['data'][$i]->name   = $b->name;
				$get['data'][$i]->banner = $b->banner;
				$get['data'][$i]->ico    = $b->ico;
				$get['data'][$i]->description = $b->description;
				$get['data'][$i]->dl = $this->models->getDls($b->id);
			}
		}
		$this->set($get);
		$this->render('index');
	}

	public function category ()
	{
		$a = $this->models->getCat($this->data[2]);
		$c['name'] = $a->name;
		if (Secures::isAcess($a->id_groups) == true) {
			$config =  Config::GetConfigPage('downloads');
			$c['pagination'] = $this->pagination($config->config['MAX_DL'], 'downloads/category/'.$this->data[2], constant('TABLE_DOWNLOADS'));
			$c['data'] = $this->models->getDls($this->data[2]);
		} else {
			$c['data'] = array();
		}
		$this->set($c);
		$this->render('category');
	}

	public function detail ()
	{
		$c['data'] = $this->models->getDlsDetail($this->data[2]);
		if ($c['data'] === false) {
			$this->error = true;
			$this->errorInfos = array('alert', constant('NO_DL'), constant('DOWNLOAD'), false);
			$this->redirect('Downloads', 3);
		} else if (empty($c['data'])) {
			$this->redirect('Downloads', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('INVALID_ID'), constant('DOWNLOAD'), false);
		} else {
			$this->models->NewView($this->data[2]);
			$this->set($c);
			$this->render('detail');
		}
	}

	public function getDl ()
	{
		$id = $this->data[2];
		if ($id != null && is_numeric($id)) {
			if ($this->models->ifAccess($id) == true) {
				$download = $this->models->getDownloads($id);
				if (stristr($download, 'http') === true or stristr($download, 'https')) {
					$this->link($download, 0);
				} else {
					$this->redirect($download, 0);
				}
				$this->error = true;
				$this->errorInfos = array('success', constant('DOWNLOADING'), constant('INFO'), false);
				$c['data'] = current($this->models->getDlsDetail($id));
				$this->set($c);
				$this->render('detail');
			} else {
				$this->error = true;
				$this->errorInfos = array('warning', constant('NO_DL'), constant('INFO'), false);
			}
		}
	}
}
