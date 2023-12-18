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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD as BDD; 
use BelCMS\Core\Config;
use BelCMS\Core\Dispatcher;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Market
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_MARKET
	# TABLE_MARKET_CAT
	#####################################
	#########################################
	# Récupère les catégorie (ou la) de la BDD
	#########################################
	public function getCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_MARKET_CAT');
		if ($id != null && is_numeric($id)):
			$where = array(
				'name'  => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
		else:
			$sql->queryAll();
		endif;
		if (!empty($sql->data)):
			return $sql->data;
		else:
			return array();
		endif;
	}
	#########################################
	# Récupère toutes les ventes
	#########################################
	public function getBuy ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_MARKET');
		if ($id != null && is_numeric($id)) {
			$where = array(
				'name'  => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			$data = $sql->data;
			if (!empty($data)) {
				$sqlImg = New BDD();
				$sqlImg->table('TABLE_MARKET_IMG');
				$whereImg = array(
					'name'  => '`id_market`',
					'value' => $data->id
				);
				$sqlImg->where($whereImg);
				$sqlImg->queryAll();
				$img = $sqlImg->data;
				if ($sqlImg->rowCount == 0) {
					$sql->data->img = array('assets/img/no_screen.png');
				} else {
					$sql->data->img = $img;
				}
			} else {
				$sql->data->img = array('assets/img/no_screen.png');
			}
		} else {
			$config = Config::GetConfigPage('market');
			if (isset($config->config['NB_BUY'])) {
				$nbpp = (int) $config->config['NB_BUY'];
			} else {
				$nbpp = (int) 6;
			}
			$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;
			$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
			$sql->limit(array(0 => $page, 1 => $nbpp), true);
			$sql->queryAll();
			if (count($sql->data) != 0) {
				foreach ($sql->data as $key => $value) {
					if (!empty($value->id)) {
						$sqlImg = New BDD();
						$sqlImg->table('TABLE_MARKET_IMG');
						$whereImg = array(
							'name'  => '`id_market`',
							'value' => $value->id
						);
						$sqlImg->where($whereImg);
						$sqlImg->queryAll();
						$img = $sqlImg->data;
						if ($sqlImg->rowCount == 0) {
							$sql->data[$key]->img = array('assets/img/no_screen.png');
						} else {
							$sql->data[$key]->img = $img;
						}
					} else {
						$sql->data[$key]->img = array('assets/img/no_screen.png');
					}
				}
			}
		}
		if (!empty($sql->data)) {
			return $sql->data;
		} else {
			return array();
		}
	}

	##################################################
	# Statistique, incrémentation.
	##################################################
	public function buyViewPlusOne ($id = null)
	{
		if ($id !== null) {
			$sql = new BDD;
			$sql->table('TABLE_MARKET');
			$sql->where(array(
				'name' => 'id',
				'value' => $id

			));
			$sql->queryOne();
			if (!empty($sql->data)) {
				$update['view'] = $sql->data->view +1;
				$insert = new BDD;
				$insert->table('TABLE_MARKET');
				$insert->where(array(
					'name' => 'id',
					'value' => $id
				));
				$insert->update($update);
			}
		}
	}

	#########################################
	# Récupère adresse
	#########################################
	public function getAdress ()
	{
		$sql = new BDD();
		$sql->table('TABLE_MARKET_ADRESS');
		$where = array(
			'name'  => 'hash_key ',
			'value' => $_SESSION['USER']->user->hash_key
		);
		$hash = $_SESSION['USER']->user->hash_key;
		$sql->where($where);
		$sql->queryOne();
		$data = $sql->data;
		$data->name        = Common::decrypt($data->name, $hash);
		$data->first_name  = Common::decrypt($data->first_name, $hash);
		$data->address     = Common::decrypt($data->address, $hash);
		$data->number      = Common::decrypt($data->number, $hash);
		$data->postal_code = Common::decrypt($data->postal_code, $hash);
		$data->city        = Common::decrypt($data->city, $hash);
		$data->country     = Common::decrypt($data->country, $hash);
		$data->phone       = Common::decrypt($data->phone, $hash);
		return $sql->data;
	}

	#########################################
	# Récupère adresse
	#########################################
	public function updateAdress ($data = null)
	{
		$insert['hash_key']    = $_SESSION['USER']->user->hash_key;
		$insert['name']        = Common::crypt($data['name'], $insert['hash_key']);
		$insert['first_name']  = Common::crypt($data['first_name'], $insert['hash_key']);
		$insert['address']     = Common::crypt($data['address'], $insert['hash_key']);
		$insert['number']      = Common::crypt($data['number'], $insert['hash_key']);
		$insert['postal_code'] = Common::crypt($data['postal_code'], $insert['hash_key']);
		$insert['city']        = Common::crypt($data['city'], $insert['hash_key']);
		$insert['country']     = Common::crypt($data['country'], $insert['hash_key']);
		$insert['phone']       = Common::crypt($data['phone'], $insert['hash_key']);
		$sql = new BDD();
		$sql->table('TABLE_MARKET_ADRESS');
		$sql->insert($insert);
		if ($sql->rowCount == true) {
			$return['text'] = constant('ADD_ADRESS_OK');
			$return['type'] = 'success';
		} else {
			$return['text'] = constant('ADD_ADRESS_NOK');
			$return['type'] = 'error'; 
		}
		return $return;
	}
	#########################################
	# Récupere l'achat / les achats
	#########################################

	#########################################
	# Confirmation de l'achat
	#########################################
	public function getBuyConfirm ($id = null)
	{
		if ($id !== null and is_int($id)) {
			$sql = New BDD();
			$sql->table('TABLE_MARKET');
			if ($id != null && is_numeric($id)) {
				$where = array(
					'name'  => 'id',
					'value' => $id
				);
				$sql->where($where);
				$sql->queryOne();
				$data = $sql->data;
				if (!empty($data)) {
					$sqlImg = New BDD();
					$sqlImg->table('TABLE_MARKET_IMG');
					$sqlImg->limit(1);
					$whereImg = array(
						'name'  => '`id_market`',
						'value' => $data->id
					);
					$sqlImg->where($whereImg);
					$sqlImg->queryAll();
					$img = $sqlImg->data;
					if ($sqlImg->rowCount == 0) {
						$sql->data->img = array('assets/img/no_screen.png');
					} else {
						$sql->data->img = $img;
					}
				} else {
					$sql->data->img = array('assets/img/no_screen.png');
				}
			}
			if (!empty($sql->data)):
				return $sql->data;
			else:
				return array();
			endif;
		}
	}
	#########################################
	# Ajout l'achat en attente
	#########################################
	public function buyAdd($id = null) {
		if ($id != null && is_numeric($id)) {
			$insert['hash_key'] = $_SESSION['USER']->user->hash_key;
			$insert['id_command'] = $id;
			$sql = New BDD();
			$sql->table('TABLE_MARKET_ORDER');
			$sql->insert($insert);
			// waiting for payment
			$wherePurchase = array('name' => 'author', 'value'=> $_SESSION['USER']->user->hash_key);
			$sqlPurchase = New BDD();
			$sqlPurchase->table('TABLE_PURCHASE');
			$sqlPurchase->where($wherePurchase);
			$sqlPurchase->queryOne();
			$returnPurchase = $sqlPurchase->data;
			if (empty($returnPurchase)) {
				$insertPurchase['author'] = $_SESSION['USER']->user->hash_key;
				$insertPurchase['id_purchase'] = $_SESSION['PAYPAL']['UNIQUE_ID'];
				$sqlPurchase = New BDD();
				$sqlPurchase->table('TABLE_PURCHASE');
				$sqlPurchase->insert($insertPurchase);
			}
		}
	}
	#########################################
	# Récupère les achats en attente de paiement
	#########################################
	public function getSales() {
		$return = array();
		$where = array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key);
		$sql = New BDD();
		$sql->table('TABLE_MARKET_ORDER');
		$sql->where($where);
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $k => $v) {
				$return[$v->id_command] = $v;
				if (!isset($return[$v->id_command]->number)) {
					$whereCount = array('name' => 'id_command', 'value' => $v->id_command);
					$sqlCount = New BDD();
					$sqlCount->table('TABLE_MARKET_ORDER');
					$sqlCount->where($whereCount);
					$sqlCount->count();
					$return[$v->id_command]->number = $sqlCount->data;
				}
				$whereBuy = array('name' => 'id', 'value' => $v->id_command);
				$sqlBuy = New BDD();
				$sqlBuy->table('TABLE_MARKET');
				$sqlBuy->where($whereBuy);
				$sqlBuy->queryOne();
				$data = $sqlBuy->data;
				$return[$v->id_command]->infos = $data;
				$sqlImg = New BDD();
				$sqlImg->table('TABLE_MARKET_IMG');
				$sqlImg->limit(1);
				$whereImg = array(
					'name'  => 'id_market',
					'value' => $v->id_command
				);
				$sqlImg->where($whereImg);
				$sqlImg->queryOne();
				$img = $sqlImg->data->img;
				if (!is_file(ROOT.$img)) {
					$return[$v->id_command]->img = 'assets/img/no_screen.png';
				} else {
					$return[$v->id_command]->img = $img;
				}
			}
		}
		return $return;
	}

	public function updateSold ($data = null)
	{
		if ($data == null) {
			$return['text'] = constant('ERROR_UNKNOW');
			$return['type'] = 'error'; 
			return $return;
		}
		if (isset($_SESSION['MARKET']['SOLD'])) {
			$return['text'] = constant('SOLD_OK_STOP');
			$return['type'] = 'error'; 	
			return $return;
		}
		$data = Common::VarSecure($data, null);
		$return = array();
		$where = array('name' => 'code', 'value' => $data);
		$sql = New BDD();
		$sql->table('TABLE_MARKET_SOLD');
		$sql->queryOne();
		if ($sql->rowCount == true) {
			$sqlreturn = $sql->data;
			if ($sqlreturn->number <= 0) {
				$return['text'] = constant('SOLD_NOK_FINISH_NUMBER');
				$return['type'] = 'error'; 	
				return $return;
			}
			if ($sqlreturn->infinite_date == 0) {
				$origin = new \DateTimeImmutable('NOW');
				$dateFinish = $sqlreturn->date_of_finish;
				$dateFinish = new \DateTimeImmutable($dateFinish);
				if ($origin > $dateFinish) {
					$return['text'] = constant('SOLD_NOK_FINISH');
					$return['type'] = 'error'; 	
					return $return;
				}
			}
			$_SESSION['MARKET']['SOLD'] = array('id' => $sqlreturn->id, 'name' => $sqlreturn->comments, 'value' => $sqlreturn->price);
			$return['text'] = $sqlreturn->comments;
			$return['type'] = 'success';
		} else {
			$return['text'] = constant('SOLD_NOK');
			$return['type'] = 'error'; 
		}
		return $return;	
	}

	public function updateCart ($data = null)
	{
		$i = 1;
		if ($data == null) {
			$return['text'] = constant('ERROR_UNKNOW');
			$return['type'] = 'error'; 
			return $return;
		}
		foreach ($data as $k => $v) {
			$where = array('name' => '`id_command`', 'value' => $k);
			$sqlDel = New BDD();
			$sqlDel->table('TABLE_MARKET_ORDER');
			$sqlDel->where($where);
			$sqlDel->delete();
		}

		foreach ($data as $k => $v) {
			$number = (int) $v;
			for ($i = 1; $i <= $number; $i++) {
				self::buyAdd($k);
			}
		}
		if (isset($_SESSION['MARKET']['SOLD'])) {
			unset($_SESSION['MARKET']['SOLD']);
		}

		$return['text'] = constant('UPDATE_BUY');
		$return['type'] = 'success';
		return $return;
	}

	public function getTva ($country = null)
	{
		if ($country != null) {
			$where = array('name' => '`country`', 'value' => $country);
			$sql = New BDD();
			$sql->table('TABLE_MARKET_TVA');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
			if (empty($return)) {
				$whereBase = array('name'=> 'country','value'=> 0);
				$base = New BDD();
				$base->table('TABLE_MARKET_TVA');
				$base->where($whereBase);
				$base->queryOne();
				return $base->data->price;
			} else {
				return $return->price;
			}
		} else {
			$whereBase = array('name'=> 'country','value'=> 0);
			$base = New BDD();
			$base->table('TABLE_MARKET_TVA');
			$base->where($whereBase);
			$base->queryOne();
			return $base->data->price;
		}
	}

	public function getPayPal ()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAYPAL');
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $key => $value) {
				Common::Constant($value->name, $value->value);
			}
		}
	}

	public function getPurchase ()
	{
		if (User::isLogged() !== false) {
			$where = array('name' => 'author', 'value'=> $_SESSION['USER']->user->hash_key);
			$sqlPurchase = New BDD();
			$sqlPurchase->table('TABLE_PURCHASE');
			$sqlPurchase->where($where);
			$sqlPurchase->queryOne();
			return $sqlPurchase->data->id_purchase;
		}
	}

	public function updateValidate ($data = null)
	{
		$unique_id = $_SESSION['PAYPAL']['UNIQUE_ID'];
		$dataVerif = $data['purchase_units']['0']['custom_id'];
		if ($data['status'] == 'COMPLETED') {
			// La vente / reduction / taxe / livraison / total / sub-total
			$purchase = $data['purchase_units'][0];
			$purchaseBreak = $purchase['amount']['breakdown'];
			$totalPay = $purchase['amount']['value'];
			$SubTotal = $purchaseBreak['item_total']['value'];
			$shipping = $purchaseBreak['shipping']['value'] . '&nbsp;' .$purchaseBreak['shipping']['currency_code'];
			$handling = $purchaseBreak['handling']['value'] . '&nbsp;' .$purchaseBreak['handling']['currency_code'];
			$taxe     = $purchaseBreak['tax_total']['value'] . '&nbsp;' .$purchaseBreak['tax_total']['currency_code'];
			$discount = $purchaseBreak['discount']['value'] . '&nbsp;' .$purchaseBreak['discount']['currency_code'];
			// liste des achats
			$item = '';
			foreach ($purchase['items'] as $key => $value) {
				$item .= 'name='.$value['name'].',';
				$item .= 'value='.$value['unit_amount']['value'].',';
				$item .= 'currency_code='.$value['unit_amount']['currency_code'].',';
				$item .= 'quantity='.$value['quantity'].'|';
			}
			$item = substr($item, 0, -1);
			// date de la transaction fini
			$dateTime = new \DateTime('NOW');
			$dateTime = date_format($dateTime,'Y-d-m H:i:s'); 
			$update['date_purchase'] = $dateTime;
			// le status (0 / non payé ou erreur / 1 = payé / 2 en attende de validation / 3 livraison en cours / 4 livré)
			$update['status']        = 1;
			$update['id_paypal']     = Common::crypt($data['id'], $_SESSION['USER']->user->hash_key);
			$update['total_pay']     = $totalPay;
			$update['sub_total']     = $SubTotal;
			$update['shipping']      = $shipping;
			$update['handling']      = $handling;
			$update['taxe']          = $taxe;
			$update['discount']      = $discount;
			$update['item']          = $item;
			// Adresse de paypal
			$infosUser = $data['payer'];
			$update['given_name']  = Common::crypt($infosUser['name']['given_name'], $_SESSION['USER']->user->hash_key);
			$update['surname']     = Common::crypt($infosUser['name']['surname'], $_SESSION['USER']->user->hash_key);
			$update['mail_paypal'] = Common::crypt($infosUser['email_address'], $_SESSION['USER']->user->hash_key);
			$update['address']     = Common::crypt($infosUser['address']['country_code'], $_SESSION['USER']->user->hash_key);
		}
		if (User::isLogged() === true and $unique_id == $dataVerif) {
			if ($data['status'] == 'COMPLETED') {
				$dataPurchase  = $data['purchase_units'][0];
				$where = array('name' => 'id_purchase', 'value'=> $unique_id);
				$sqlPurchase = New BDD();
				$sqlPurchase->table('TABLE_PURCHASE');
				$sqlPurchase->where($where);
				$sqlPurchase->update($update);
				debug($sqlPurchase);
				if ($sqlPurchase->rowCount == 1) {
					if (isset($_SESSION['MARKET']['SOLD'])) {
						$whereSold = array('name' => 'id', 'value' => $_SESSION['MARKET']['SOLD']['id']);
						$sqlSold = New BDD();
						$sqlSold->table('TABLE_MARKET_SOLD');
						$sqlSold->where($whereSold);
						$sqlSold->queryOne();
						$number = $sqlSold->data->number;
						if ($number != 0) {
							$updateSold['number'] = $number - 1;
							$sqlminSold = New BDD();
							$sqlminSold->table('TABLE_MARKET_SOLD');
							$sqlminSold->where($whereSold);
							$sqlminSold->update($updateSold);
						}
						unset($_SESSION['MARKET']['SOLD']);
					}
					$where = array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key);
					$sqlDel = New BDD();
					$sqlDel->table('TABLE_MARKET_ORDER');
					$sqlDel->where($where);
					$sqlDel->delete();
				}
			}
		}
	}

	public function getBilling ($id = null)
	{
		if ($id != null and is_int($id)) {
			$where = array('name' => 'id_purchase', 'value'=> $id);
		} else {
			$config = Config::GetConfigPage('market');
			if (isset($config->config['NB_BILLING'])) {
				$nbpp = (int) $config->config['NB_BILLING'];
			} else {
				$nbpp = (int) 10;
			}
			$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;
			$where = array('name' => 'author', 'value'=> $_SESSION['USER']->user->hash_key);
		}

		if (User::isLogged() === true) {
			$sql = New BDD();
			$sql->table('TABLE_PURCHASE');
			if ($id != null and is_int($id)) {
				$where = array('name' => 'id_purchase', 'value'=> $id);
			} else {
				$where = array('name' => 'author', 'value'=> $_SESSION['USER']->user->hash_key);
			}
			$sql->where($where);
			if ($id != null and is_string($id)) {
				$sql->queryOne();
				$data = $sql->data;
				$data->id_paypal   = Common::decrypt($data->id_paypal, $_SESSION['USER']->user->hash_key);
				$data->given_name  = Common::decrypt($data->given_name, $_SESSION['USER']->user->hash_key);
				$data->surname     = Common::decrypt($data->surname, $_SESSION['USER']->user->hash_key);
				$data->mail_paypal = Common::decrypt($data->mail_paypal, $_SESSION['USER']->user->hash_key);
				$data->address     = Common::decrypt($data->address, $_SESSION['USER']->user->hash_key);
			} else {
				$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
				$sql->limit(array(0 => $page, 1 => $nbpp), true);
				$sql->queryAll();
				$data = $sql->data;
				foreach ($data as $k => $v) {
					$data[$k]->id_paypal   = Common::decrypt($v->id_paypal, $_SESSION['USER']->user->hash_key);
					$data[$k]->given_name  = Common::decrypt($v->given_name, $_SESSION['USER']->user->hash_key);
					$data[$k]->surname     = Common::decrypt($v->surname, $_SESSION['USER']->user->hash_key);
					$data[$k]->mail_paypal = Common::decrypt($v->mail_paypal, $_SESSION['USER']->user->hash_key);
					$data[$k]->address 	   = Common::decrypt($v->address, $_SESSION['USER']->user->hash_key);
				}
			}
		}

		return $data;
	}
}