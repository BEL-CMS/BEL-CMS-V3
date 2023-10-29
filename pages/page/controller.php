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

class Page extends Pages
{
	var $models  = 'ModelsPage';

	public function index ($page = false)
	{	
		$set['data'] = $this->models->getPage();
		foreach ($set['data'] as $k => $v) {
			if (Secures::IsAcess($v->groups) == false) {
				unset($set['data'][$k]);
			}
		}
		$page = Common::ScanFiles(ROOT.'pages/page/sub-page');
		if (!empty($page)) {
			$set['sub'] = str_replace(".php", "", $page);
		}
		$this->set($set);
		$this->render('index');
	}

	public function read ($id = null)
	{
		if (!is_null($id) && is_numeric($id)) {
			$set['data'] = $this->models->getPageContentId($id);
			$get = $this->models->getPageId($set['data']->number);
			if (Secures::IsAcess($get->groups) == false) {
				$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
			} else {
				$this->set($set);
				$this->render('read');	
			}
		} else {
			$this->error(get_class($this), 'Aucun ID', 'warning');
		}
	}

	public function subpage ($id)
	{
		if (!is_null($id) && is_numeric($id)) {
			$set['data'] = $this->models->getPages($id);
			if (empty($set['data'])) {
				Notification::warning('Aucune page dans la BDD');
			} else {
				$get = $this->models->getPageId(current($set['data'])->number);
				if (Secures::IsAcess($get->groups) == false) {
					$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
				} else {
					$this->set($set);
					$this->render('subpage');
				}
			}
		} else {
			$this->error(get_class($this), 'Aucun ID', 'warning');
		}
	}

	public function intern ($name = null)
	{
		$page = Common::ScanFiles(ROOT.'pages/page/sub-page');
		if (!empty($page)) {
			$page = str_replace(".php", "", $page);
		}
		$full = Common::ScanFiles(ROOT.'pages/page/sub-page', true, true);
		if (in_array(strtolower($name), $page)) {
			require_once(ROOT.'pages/page/sub-page'.DS.$name.'.php');
		} else {
			$this->error(get_class($this), 'La page ('.$name.') demander n\'existe pas !', 'warning');
		}
	}
}
