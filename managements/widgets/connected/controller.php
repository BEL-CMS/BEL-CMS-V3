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

use BelCMS\Config\Config;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Connected extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd    = 'ModelsConnected';

	public function index ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'connected?management&option=widgets','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'connected/parameter?management&option=widgets','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data']     = Config::getConfigWidgets('shoutbox');
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
		$this->render('index', $menu);
	}

	public function disabled ()
	{
		$name  = Common::VarSecure($_POST['id'], false);
		$value = Common::VarSecure($_POST['status'], false);
		$this->models->sendOptions($name, $value);
	}
}