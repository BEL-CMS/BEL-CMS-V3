<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;

use BelCMS\Core\Config;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Search extends Pages
{
	var $useModels = 'Search';

    public function index ()
    {

        $this->render('index');
    }

    public function search ()
    {
		$config =  Config::GetConfigPage('search');
        $letter = Common::VarSecure($this->data[2], null);
		$set['pagination'] = $this->pagination($config->config['MAX_SEARCH'], 'Search/search/'.$letter.'/', constant('TABLE_SEARCH'));
        $this->set($set);
        $data['data'] = $this->models->search($letter);
        $data['letter'] = $letter;
        $this->set($data);
        $this->render('search');
    }

    public function options ()
    {
        $data['search'] = Common::VarSecure($this->data['search'], null);
        $data['cat']    = Common::VarSecure($this->data['cat'], null);
        $data['data']   = $this->models->searchOption($data);
        $data['read']   = self::readTitle($data['cat']);
        $this->set($data);
        $this->render('options');
    }

    public function content ()
    {
        $name = Common::VarSecure($this->data[2], null);
        $data['data']  = $this->models->searchContent($name);
        $this->set($data);
        $this->render('content');
    }

    private function readTitle ($data)
    {
        $return[0] = $data;
		switch ($data) {
			case 'news':
				$return[1] = 'name';
			break;

			case 'articles':
				$return[1] = 'name';
			break;

			case 'downloads':
				$return[1] = 'name';
			break;

			case 'members':
				$return[1] = 'username';
			break;

			case 'guestbook':
				$return[1] = 'author';
			break;

			case 'gallery':
				$return[1] = 'name';
			break;

			case 'links':
				$return[1] = 'name';
			break;

			case 'market':
				$return[1] = 'name';
			break;
		}
        return $return;
    }
}