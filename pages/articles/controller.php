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
use BelCMS\Core\Notification;
use BelCMS\Core\Secures;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Articles extends Pages
{
	var $useModels  = 'Articles';

	public function index ()
	{	
		$set['data'] = $this->models->getPage();
		foreach ($set['data'] as $k => $v) {
			if (Secures::IsAcess($v->groups) == false) {
				unset($set['data'][$k]);
			}
		}
		$page = Common::ScanFiles(ROOT.'/pages/page/uploads');
		if (!empty($page)) {
			$set['sub'] = str_replace(".php", "", $page);
		}
		$this->set($set);
		$this->render('index');
	}

	public function read ($id = null)
	{
		$id = $this->data[2];
		if (!is_null($id) && is_numeric($id)) {
			$set['data'] = $this->models->getArticlesContentId($id);
			$get = $this->models->getArticlesId($set['data']->number);
			if (Secures::IsAcess($get->groups) == false) {
				$this->error = true;
				$this->errorInfos = array('error', constant('NO_ACCESS_GROUP_PAGE'), constant('INFO'), false);
			} else {
				$this->set($set);
				$this->render('read');	
			}
		} else {
			$this->error = true;
			$this->errorInfos = array('error', 'Aucun ID', constant('INFO'), false);
		}
	}

	public function subpage ()
	{
		$id = $this->data[2];
		if (!is_null($id) && is_numeric($id)) {
			$set['data'] = $this->models->getArticles($id);
			if (empty($set['data'])) {
				Notification::warning('Aucune page dans la BDD');
			} else {
				$get = $this->models->getArticlesId(current($set['data'])->number);
				if (Secures::IsAcess($get->groups) == false) {
					$this->error = true;
					$this->errorInfos = array('warning', constant('NO_ACCESS_GROUP_PAGE'), constant('INFO'), false);
				} else {
					$this->set($set);
					$this->render('subpage');
				}
			}
		} else {
			$this->error = true;
			$this->errorInfos = array('warning', 'Aucun ID', constant('INFO'), false);
		}
	}

	public function intern ($name = null)
	{
		$page = Common::ScanFiles(ROOT.'pages/articles/uploads');
		if (!empty($page)) {
			$page = str_replace(".php", "", $page);
		}
		$full = Common::ScanFiles(ROOT.'pages/articles/uploads', true, true);
		if (in_array(strtolower($name), $page)) {
			require_once(ROOT.'pages/articles/uploads'.DS.$name.'.php');
		} else {
			$this->error = true;
			$this->errorInfos = array('warning','La page ('.$name.') demander n\'existe pas !', constant('INFO'), false);
		}
	}
}
