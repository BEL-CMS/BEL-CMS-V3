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

namespace Belcms\Widgets\Controller\Stats;
use BelCMS\Widgets\Widgets as BaseWidget;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Stats extends BaseWidget
{
	var $useModels = 'Stats';

	public function index ($var)
	{
		$data['active']   = $this->models->getActive();
		$data['page']     = $this->models->getNbPageView();
		$data['users']    = $this->models->getNbUsers();
		$data['news']     = $this->models->getNbNews();
		$data['articles'] = $this->models->getNbArticles();
		$data['comments'] = $this->models->getNbComments();
		$data['files']    = $this->models->getNbDownloads();
		$data['links']    = $this->models->getNbLinks();
		$data['img']      = $this->models->getNbImg();

		$this->set($data);

		$this->name  = $var->name;
		$this->title = $var->title;
		$this->pos   = $var->pos;
		$this->render();
	}
}
