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
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Calendar extends Pages
{
	var $useModels = 'Calendar';

	public function index ()
	{
		$this->render('index');
	}
	public function get() {
		$this->typeMime = 'application/json';
		$return = $this->models->get();
		echo json_encode($return);
	}

	public function list ()
	{
		$data['data'] = $this->models->getList();
		$config = Config::GetConfigPage('calendar');
		$set['pagination'] = $this->pagination($config->config['MAX_LIST'], 'calendar/list', constant('TABLE_EVENTS'));
		$this->set($set);
		$this->set($data);
		$this->render('list');
	}
}