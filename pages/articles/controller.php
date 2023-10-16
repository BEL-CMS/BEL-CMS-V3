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

namespace BELCMS\Controller;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Articles
{
	var $models = 'ModelsArticles';

	function index ()
	{
		$config =  GetConfigPage('articles');
		$set['pagination'] = $this->pagination($config->config['MAX_ARTICLES'], 'articles', TABLE_PAGES_ARTICLES);
		$set['articles'] = $this->models->getArticles();
		$this->set($set);
		$this->render('index');
	}

	function readmore ($name = false, $page = null, $id = false)
	{
		$set = array();
		$set['articles'] = $this->models->getArticles($id);

		if (!is_object($set['articles']) && $set['articles'] == 0) {
			$this->error(get_class($this), NAME_OF_THE_UNKNOW, 'error');
			return;
		} else {
			$this->models->NewView($id);
		}
		$this->set($set);
		$this->render('readmore');
	}

	function json ($api_key)
	{
		if (defined('API_KEY')) {
			if (!empty($api_key) && $api_key == constant('API_KEY')) {
				$data = $this->models->getLastArticles();
				echo json_encode($data);
			}
		} else {
			echo json_encode(null);
		}
	}
}
