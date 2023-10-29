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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Core\Secures;

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
			if (Secures::isAcess($b->groups) == false) {
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
		// Si le tableau est vide, affiche une attention.
		if (empty($get['data'])) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('NO_DATA_AVAILABLE'), constant('INFO'), false);
		} else {
			$this->set($get);
			$this->render('index');
		}
	}

	public function category ()
	{
		$a = $this->models->getCat($this->data[2]);
		$c['name'] = $a->name;
		if (Secures::isAcess($a->groups) == true) {
			$c['data'] = $this->models->getDls($this->data[2]);
		} else {
			$c['data'] = array();
		}
		$this->set($c);
		$this->render('category');
	}

	public function detail ()
	{
		$c['data'] = current($this->models->getDlsDetail($this->data[2]));
		if (empty($c['data'])) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('INVALID_ID'), constant('INFO'), false);
		} else {
			$this->models->NewView($this->data[2]);
			$this->set($c);
			$this->render('detail');
		}
	}

	public function getDl ($id)
	{
		if ($id != null && is_numeric($id)) {
			if ($this->models->ifAccess($id) == true) {
				if (stristr($this->models->getDownloads($id), 'http') === true or stristr($this->models->getDownloads($id), 'https')) {
					$this->link($this->models->getDownloads($id), 0);
				} else {
					$this->redirect($this->models->getDownloads($id), 0);
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
