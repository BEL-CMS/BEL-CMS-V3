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
}