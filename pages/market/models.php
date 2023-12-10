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
		if ($id != null && is_numeric($id)):
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
		else:
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
		endif;
		if (!empty($sql->data)):
			return $sql->data;
		else:
			return array();
		endif;
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
		$sql->where($where);
		$sql->queryOne();
	}
	#########################################
	# Récupere l'achat / les achats
	#########################################
	public function buyView ($id = null)
	{
		if ($id !== null) {
			$sql = new BDD;
			$sql->table('');
		}
	}
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
		}
	}
	#########################################
	# Récupère les achats en attente de paiement
	#########################################
	public function getSales() {
		$n = 0;
		$return = array();
		$where = array('name' => 'hash_key', 'value' => $_SESSION['USER']->user->hash_key);
		$sql = New BDD();
		$sql->table('TABLE_MARKET_ORDER');
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $k => $v) {
				$n = $n + 1;
				$return[$v->id_command] = $v;
				$return[$v->id_command]->number = $n;
				$whereBuy = array('name' => 'id', 'value' => $v->id_command);
				$sqlBuy = New BDD();
				$sqlBuy->table('TABLE_MARKET');
				$sqlBuy->where($whereBuy);
				$sqlBuy->queryOne();
				$data = $sqlBuy->data;

				$return[$v->id_command]->infos = $data;
			}
		}
		return $return;
	}
}