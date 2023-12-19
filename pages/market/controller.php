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
use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Market extends Pages
{
	public function __construct()
	{
		parent::__construct();
		$this->models->getPayPal();
	}
	var $useModels = 'Market';
	public function index ()
	{
		$config =  Config::GetConfigPage('market');
		$data['pagination'] = $this->pagination($config->config['NB_BUY'], 'market', constant('TABLE_MARKET'));
		$data['cat'] = $this->models->getCat();
		$data['buy'] = $this->models->getBuy();
		$this->set($data);
		$this->render('index');
	}

	public function buy ()
	{
		$id = (int) $this->data[2];
		$data['buy'] = $this->models->getBuy($id);
		if (!empty($data['buy'])) {
			$this->models->buyViewPlusOne($id);
		}
		$this->set($data);
		$this->render('buy');
	}

	public function buyconfirm ()
	{
		if (!isset($_SESSION['PAYPAL']['UNIQUE_ID']) or empty($_SESSION['PAYPAL']['UNIQUE_ID'])) {
			$_SESSION['PAYPAL']['UNIQUE_ID'] = md5(uniqid(rand(), true));
		}

		if (isset($this->data[2]) and !empty($this->data[2])) {
			$id = (int) $this->data[2];
			if (isset($_GET['add']) and $_GET['add'] == 'true') {
				$this->models->buyAdd($id);
			}
		} else {
			$get = $this->models->getSales();
			if (empty($get)) {
				$this->redirect('Market', 5);
				$this->error = true;
				$this->errorInfos = array('warning', constant('EMPTY_SHOPPING_CAT'), constant('INFO'), false);
				return false;
			}
		}
		$get['order']    = $this->models->getSales();
		foreach ($get['order'] as $key => $value) {
			if ($value->infos->tva == 1) {
				$adress = $this->models->getAdress();
				if (!isset($adress) and empty($adress)) {
					if (User::isLogged() === false) {
						$this->redirect('User/login&echo', 3);
						$this->error = true;
						$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
					} else {
						$this->redirect('Market/adress', 5);
						$this->error = true;
						$this->errorInfos = array('warning', constant('ADRESS_REQUIRE'), constant('ALERT_INFOS'), false);
					}	
				} else {
					$country = $adress->country;
					if (empty($country)) {
						$this->redirect('Market/adress', 5);
						$this->error = true;
						$this->errorInfos = array('warning', constant('COUNTRY_REQUIRE'), constant('ALERT_INFOS'), false);
					} else {
						$country = Common::decrypt($country, $_SESSION['USER']->user->hash_key);
						$tva = $this->models->getTva($country);
						$get['order'][$key]->tva = $tva;
					}
				}
			} else {
				$get['order'][$key]->tva = 0;
			}
		}
		$this->set($get);
		$this->render('buyconfirm');
	}

	public function adress ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$this->redirect('Market/buyconfirm', 0);
		}
	}

	public function sendadress ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$return = $this->models->updateAdress($_POST);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('SHOP'), false);
			$this->redirect('Market/buyconfirm', 3);
		}
	}

	public function sold ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$return = $this->models->updateSold ($_POST['sold']);
			if ($return === true) {
				$this->error = true;
				$this->errorInfos = array($return['type'], $return['text'], constant('SHOP'), false);
				$this->redirect('Market/buyconfirm', 3);
			} else {
				$this->error = true;
				$this->errorInfos = array($return['type'], $return['text'], constant('SHOP'), false);
				$this->redirect('Market/buyconfirm', 3);		
			}
		}
	}

	public function update ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$data = current($_POST);
			$return = $this->models->updateCart($data);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('SHOP'), false);
			$this->redirect('Market/buyconfirm', 2);
		}
	}

	public function finish ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			if (isset($_SESSION['BUY']['FINISH'])) {
				$this->models->getPayPal();
			} else {
				$this->redirect('Market', 3);
				$this->error = true;
				$this->errorInfos = array('warning', constant('NO_VALIDATION'), constant('SHOP'), false);
			}
		}
	}

	public function PayPalValidate ()
	{
		$this->models->updateValidate($_POST);
	}

	public function billing ()
	{
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$config =  Config::GetConfigPage('market');
			$set['pagination'] = $this->pagination($config->config['NB_BILLING'], 'market', constant('TABLE_PURCHASE'));
			$data['billing'] = $this->models->getBilling();
			$this->set($data);
			$this->render('billing');
		}
	}

	public function invoice ()
	{
		if (isset($this->data[2]) and !empty($this->data[2])) {
			$id = (string) $this->data[2];
		}
		if (User::isLogged() === false) {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
			$data['adress']  = $this->models->getAdress();
			$data['billing'] = $this->models->getBilling($id);
			$this->set($data);
			$this->render('invoice');
		}
	}

	public function payPalError ()
	{
		debug($this);
	}
}