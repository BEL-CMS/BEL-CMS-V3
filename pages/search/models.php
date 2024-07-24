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

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\Core\Config;
use BelCMS\Core\Dispatcher;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_SEARCH

final class Search
{
	#####################################
	# Recherche par lettre
	#####################################
	public function search ($letter)
	{
		$config = Config::GetConfigPage('search');
		if (isset($config->config['MAX_SEARCH'])) {
			$nbpp = (int) $config->config['MAX_SEARCH'];
		} else {
			$nbpp = (int) 10;
		}
		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$letter = Common::VarSecure($letter, null);
		$sql = new BDD;
		$sql->table('TABLE_SEARCH');
		$sql->where(array('name' => 'letter', 'value' => $letter));
		$sql->orderby(array(array('name' => 'title', 'type' => 'ASC')));
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# recherche par id
	#####################################
	public function searchContent ($id)
	{
		$id = Secure::isString($id);
		$sql  = new BDD;
		$sql->table('TABLE_SEARCH');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# recherche par catégorie
	#####################################
	public function searchOption ($data)
	{
		$nbSearch = 0;
		$search = Common::VarSecure($data['search'], null);

		switch ($data['cat']) {
			case 'news':
				$table = 'TABLE_PAGES_NEWS';
				$category = 'name';
				$case = 'news';
			break;

			case 'articles':
				$table = 'TABLE_ARTICLES_CONTENT';
				$category = 'content';
				$case = 'articles';
			break;

			case 'downloads':
				$table = 'TABLE_DOWNLOADS';
				$category = 'description';
				$case = 'downloads';
			break;

			case 'members':
				$table = 'TABLE_USERS';
				$category = 'username';
				$case = 'members';
			break;

			case 'guestbook':
				$table = 'TABLE_GUESTBOOK';
				$category = 'author';
				$case = 'guestbook';
			break;

			case 'gallery':
				$table = 'TABLE_GALLERY';
				$category = 'name';
				$case = 'table';
			break;

			case 'links':
				$table = 'TABLE_LINKS';
				$category = 'link';
				$case = 'links';
			break;

			case 'market':
				$table = 'TABLE_MARKET';
				$category = 'name';
				$case = 'market';
			break;
		}

		$sql = new BDD;
		$sql->table($table);
		$where = 'WHERE `'.$category.'` LIKE "%'.$search.'%"';
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		if ($sql->rowCount != 0) {
			$query = new BDD;
			$query->table('TABLE_SEARCH_POPULAR');
			$query->where(array('name' => 'search', 'value' => $search));
			$query->queryOne();
			$returnSelect = $query->data;
			if ($query->rowCount >= 1) {
				$where = array('name' => 'search', 'value' => $search);
				$returnSelect = $query->data;
				$returnSelect->number = $returnSelect->number + 1;
				$insert['number'] = $returnSelect->number;
				$update = new BDD;
				$update->table('TABLE_SEARCH_POPULAR');
				$update->where($where);
				$update->update($insert);
			} else {
				$dataInsert['search'] = $search;
				$dataInsert['type']   = $case;
				$dataInsert['number'] = 1;
				$insertBDD = new BDD;
				$insertBDD->table('TABLE_SEARCH_POPULAR');
				$insertBDD->insert($dataInsert);
			}
		}
		return $return;
	}
}