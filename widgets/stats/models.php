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

namespace Belcms\Widgets\Models\Stats;
use BelCMS\PDO\BDD as BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Stats
{
	protected function GetGroups ()
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_GROUPS');
		$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
		}
		return $return;
	}

	function getActive()
	{
		$active = array();
		$sql = New BDD();
		$sql->table('TABLE_STATS');
		$sql->queryAll();

		foreach ($sql->data as $value) {
			$active[$value->name] = $value->value == '1' ? true : false;
		}
		return $active;
	}

	function getNbPageView()
	{
		$count = (int) 0;
		$sql = New BDD();
		$sql->table('TABLE_PAGE_STATS');
		$sql->fields('nb_view');
		$sql->queryAll();
	
		foreach ($sql->data as $view) {
		   $count += $view->nb_view;
		}
		return $count;
	}

	function getNbNews()
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_NEWS');
		$sql->count();
		return $sql->data;
	}

	function getNbDownloads ()
	{
		$count = (int) 0;
		$sql = new BDD;
		$sql->table('TABLE_DOWNLOADS');
		$sql->queryAll();
	
		foreach ($sql->data as $view) {
		   $count += $view->dls ;
		}
		return $count;
	}

	function getNbUsers ()
	{
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->count();
		return $sql->data;
	}

	function getNbArticles ()
	{
		$sql = New BDD();
		$sql->table('TABLE_ARTICLES');
		$sql->count();
		return $sql->data;
	}

	function getNbComments ()
	{
		$sql = New BDD();
		$sql->table('TABLE_COMMENTS');
		$sql->count();
		return $sql->data;
	}
	function getNbImg ()
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		$sql->count();
		return $sql->data;
	}

	function getNbLinks ()
	{
		$sql = New BDD();
		$sql->table('TABLE_LINKS');
		$sql->count();
		return $sql->data;
	}


	protected function GetUsersNb ($where = false)
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		if ($where !== false) {
			$where = "WHERE `groups` LIKE '%".$where."%'";
			$sql->where($where);
		}
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->rowCount;
		} else {
			$return = 0;
		}
		return $return;
	}
	protected function GetConnected ()
	{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_STATS');
		$where = "WHERE 1 and `name` in ('record','last','today')";
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;

		foreach ($return as $k => $v) {
			$_SESSION['STATS'][$v->name] = $v->value;
		}

		return $return;
	}
	protected function NbNow ()
	{
		$sql = New BDD();
		$sql->table('TABLE_VISITORS');
		$less = strtotime("-3 minutes");
		$where = "WHERE `date_page` > '$less'";
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;

		return $return;
	}
}
