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
		$query = new BDD;
		$query->table('TABLE_GALLERY_VOTE');
		$query->where(array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key));
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
			$return['text'] = 'Vous avez voté, merci';
			$return['type'] = 'success';
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
}