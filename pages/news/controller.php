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
use BelCMS\Core\Config as Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class News extends Pages
{
	var $useModels = 'News';

	function index ()
	{
		$config =  Config::GetConfigPage('news');
		$set['pagination'] = $this->pagination($config->config['MAX_NEWS'], 'news', constant('TABLE_PAGES_NEWS'));
		$set['news'] = $this->models->getNews();
		$this->set($set);
		$this->render('index');
	}

	function readmore ($page = false, $subpage = null, $name = false, $id = 0)
	{
		if (strlen($id) == 0) {
			$this->error = true;
			$this->errorInfos = array('warning', constant('NAME_OF_THE_UNKNOW'), constant('INFO'), false);
		} else {
			$set = array();
			$set['news'] = $this->models->getNews($id);
			if (!is_object($set['news']) && $set['news'] == 0) {
				$this->error = true;
				$this->errorInfos = array('warning', constant('NAME_OF_THE_UNKNOW'), constant('INFO'), false);
				return;
			} else {
				$this->models->NewView($id);
			}
			$this->set($set);
			$this->render('readmore');
		}
	}

	function json ($api_key)
	{
		if (defined('API_KEY')) {
			if (!empty($api_key) && $api_key == constant('API_KEY')) {
				$data = $this->models->getLastNews();
				echo json_encode($data);
			}
		} else {
			echo json_encode(null);
		}
	}
}
