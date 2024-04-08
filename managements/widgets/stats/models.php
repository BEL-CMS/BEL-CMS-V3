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

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsStats
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_SHOUTBOX
	#####################################
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

	public function sendOptions ($name = false, $value = false)
	{
		if ($name !== false and $value !== false) {
			$d['value'] = $value;
			$sql = New BDD();
			$sql->table('TABLE_STATS');
			$sql->where(array('name' => 'name', 'value' => $name));
			$sql->update($d);
		}
	}

	public function sendparameter ($data)
	{
		$return = array();

		if (!empty($data) && is_array($data)) {
			$upd['title']         = Common::VarSecure($data['title'], '');
			$upd['groups_access'] = implode("|", $data['groups']);
			$upd['groups_admin']  = implode("|", $data['admin']);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			if ($data['pos'] == 'top') {
				$upd['pos'] = 'top';
			} else if ($data['pos'] == 'bottom') {
				$upd['pos'] = 'bottom';
			} else if ($data['pos'] == 'left') {
				$upd['pos'] = 'left';
			} else if ($data['pos'] == 'right') {
				$upd['pos'] = 'right';
			}
			if (isset($data['current'])) {
				$upd['pages']  = implode("|", $data['current']);
			}
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_WIDGETS');
			$sql->where(array('name' => 'name', 'value' => 'stats'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_PARAM_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}

		return $return;
	}
}