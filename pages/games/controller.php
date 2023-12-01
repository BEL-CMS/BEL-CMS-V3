<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;
use BelCMS\Core\Config;
use Belcms\Pages\Pages;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Games extends Pages
{
	var $useModels = 'Games';

	public function index ()
	{
		$config =  Config::GetConfigPage('games');
		$set['pagination'] = $this->pagination($config->config['MAX_GAMING_PAGE'], 'games', constant('TABLE_PAGES_GAMES'));
		$data = $this->models->GetGames();
        foreach ($data as $key => $value) {
            $data->$key->count = count((array)$value->user);
        }
        $set['data'] = $data;
		$this->set($set);
		$this->render('index');
	}
}