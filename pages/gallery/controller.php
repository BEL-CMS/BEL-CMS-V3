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

class Gallery extends Pages
{
	var $useModels = 'Gallery';

	public function index ()
	{
        $cat['category']['cat'] = $this->models->getCat();
        $this->set($cat);
        $img['img']['img'] = $this->models->getImg();
        $this->set($img);
        $this->render('index');
    }

    public function category ()
    {
        $id = (int) $this->data[2];
		$config =  Config::GetConfigPage('gallery');
		$set['pagination'] = $this->pagination($config->config['MAX_IMG'], 'gallery/Category/'.$id, constant('TABLE_GALLERY'), array('name' => 'cat', 'value' => $id));
        $this->set($set);
        $cat['category']['cat'] = $this->models->getCat();
        $this->set($cat);
        $img['img']['img'] = $this->models->getImgCat($id);
        $this->set($img);
        $this->render('cat');
    }
}