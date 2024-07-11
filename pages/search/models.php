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
		$search = Common::VarSecure($data['search'], null);

		switch ($data['cat']) {
			case 'news':
				$table = 'TABLE_PAGES_NEWS';
				$category = 'name';
			break;

			case 'articles':
				$table = 'TABLE_ARTICLES_CONTENT';
				$category = 'content';
			break;

			case 'downloads':
				$table = 'TABLE_DOWNLOADS';
				$category = 'description';
			break;

			case 'members':
				$table = 'TABLE_USERS';
				$category = 'username';
			break;

			case 'guestbook':
				$table = 'TABLE_GUESTBOOK';
				$category = 'author';
			break;

			case 'gallery':
				$table = 'TABLE_GALLERY';
				$category = 'name';
			break;

			case 'links':
				$table = 'TABLE_LINKS';
				$category = 'link';
			break;

			case 'market':
				$table = 'TABLE_MARKET';
				$category = 'name';
			break;
		}

		$sql = new BDD;
		$sql->table($table);
		$where = 'WHERE `'.$category.'` LIKE "%'.$search.'%"';
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
}