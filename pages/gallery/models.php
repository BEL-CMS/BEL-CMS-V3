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

namespace Belcms\Pages\Models;

use BelCMS\PDO\BDD;
use BelCMS\Core\Config;
use BelCMS\Core\Dispatcher;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
#####################################
# Infos tables
#####################################
# TABLE_GALLERY
# TABLE_GALLERY_CAT
# TABLE_GALLERY_VOTE
#####################################
final class Gallery
{
	#####################################
	# Récupère toute les catégories
	#####################################
	public function geAlltCat ()
	{
		$config = Config::GetConfigPage('gallery');
		if (isset($config->config['MAX_CAT'])) {
			$nbpp = (int) $config->config['MAX_CAT'];
		} else {
			$nbpp = (int) 5;
		}

		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$sql = new BDD;
		$sql->table('TABLE_GALLERY_CAT');
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Compte le nombre d'image
	#####################################
	public function countImg ()
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY');
		$sql->count();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère les donné d'une image
	#####################################
	public function getDetail ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY');
		$sql->where(array('name' => 'cat', 'value' => $id));
		$sql->queryAll();
		foreach ($sql->data as $key => $value) {
			$sql->data[$key]->vote = self::getVoteId ($value->id);
		}
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère les vote d'une image
	#####################################
	private function getVoteId ($id)
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY_VOTE');
		$sql->where(array('name' => 'id_vote', 'value' => $id));
		$sql->count();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Voté +1 sur une image
	#####################################
	public function votePlusOne($id)
	{
		if (User::isLogged()) {
			$querySource = new BDD;
			$querySource->table('TABLE_GALLERY');
			$querySource->where(array('name' => 'id', 'value' => $id));
			$querySource->queryOne();
			$source = $querySource->data;

			if (!empty($source)) {
				$where[] = array('name' => 'id_vote', 'value' => $id);
				$where[] = array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key);
				$query = new BDD;
				$query->table('TABLE_GALLERY_VOTE');
				$query->where($where);
				$query->count();
		
				if ($query->data != 0) {
					$return['text'] = 'Vous avez déjà voté';
					$return['type'] = 'warning';
					return $return;
				} else {
					$insert['author']  = $_SESSION['USER']->user->hash_key;
					$insert['id_vote'] = $id;
					$sql = new BDD;
					$sql->table('TABLE_GALLERY_VOTE');
					$sql->insert($insert);

					$pts = $source->vote;
					$vote['vote'] = $pts + 1;

					$update = new BDD;
					$update->table('TABLE_GALLERY');
					$update->where(array('name' => 'id', 'value' => $id));
					$update->update($vote);
					
					$return['text'] = 'Merci pour votre vote';
					$return['type'] = 'success';
					return $return;
				}
			} else {
				$return['text'] = 'ID Vote inconnu';
				$return['type'] = 'error';
				return $return;
			}
		} else {
			$return['text'] = 'Seuls les membres peuvent vote';
			$return['type'] = 'warning';
			return $return;
		}
	}
	#####################################
	# Voté +1 sur une image
	#####################################
	public function getnew ()
	{
		$sql = New BDD;
		$sql->table('TABLE_GALLERY');
		$sql->orderby('ORDER BY `'.TABLE_GALLERY.'`.`date_insert` DESC', true);
		$sql->limit(5);
		$sql->queryAll();
		foreach ($sql->data as $key => $value) {
			$sql->data[$key]->vote = self::getVoteId ($value->id);
		}
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère les sous-catégories avec id
	#####################################
	public function GetNameSubCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_SUB_CAT');

		if ($id !== null) {
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			if (!empty($sql->data)){
				return $sql->data;
			}
		} elseif ($id == null) {
			$sql->queryAll();
			return $sql->data;
		}
	}
	#####################################
	# Récupère les sous-catégories avec id
	#####################################
	public function GetNameSubCatId ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_SUB_CAT');
		$where = array(
			'name' => 'id_gallery',
			'value' => $id
		);

		$sql->where($where);
		$sql->queryAll();

		if (!empty($sql->data)) {
			return $sql->data;
		} else {
			return false;
		}
	}
	#####################################
	# Envoie à la BDD la proposition d'image
	#####################################
	public function SendPropose ($data)
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY_VALID');
		$sql->insert($data);
		if ($sql->rowCount == 1) {
			$return['msg']  = constant('PROPOSE_SUCCESS');
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('PROPOSE_ERROR');
			$return['type'] = 'error';
		}
		return $return;
	}
	#####################################
	# Récupère les plus polulaire
	#####################################
	public function popular ()
	{
		$sql = new BDD;
		$sql->table('TABLE_GALLERY');
		$sql->orderby('ORDER BY `'.TABLE_GALLERY.'`.`vote` DESC', true);
		$sql->limit(6);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
}