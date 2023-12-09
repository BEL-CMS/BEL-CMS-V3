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
use Belcms\Pages\Pages;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Market extends Pages
{
	var $useModels = 'Market';
	public function index ()
	{
		$data['cat'] = $this->models->getCat();
		$data['buy'] = $this->models->getBuy();
		$this->set($data);
		$this->render('index');
	}

	public function buy ()
	{
		$id = (int) $this->data[2];
		$data['buy'] = $this->models->getBuy($id);
		$this->set($data);
		$this->render('buy');
	}

	public function buyconfirm ()
	{
		$id = (int) $this->data[2];
		$this->render('buyconfirm');
	}

	public function adress ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$data['adress'] = $this->models->getAdress();
			$this->set($data);
			$this->render('adress');
		}
	}

	public function sendadress ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			//$this->render('adress');
		}
	}
}