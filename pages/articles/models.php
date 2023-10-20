<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Models;
use BelCMS\Core\Config as Config;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;
use BelCMS\User\User as User;
use BelCMS\Core\Dispatcher as Dispatcher;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Articles
{
	# TABLE_PAGES_ARTICLES
	# TABLE_PAGES_ARTICLES_CAT
	public function getArticles ($id = false)
	{
		$config = Config::GetConfigPage('Articles');
		if (isset($config->config['MAX_ARTICLES'])) {
			$nbpp = (int) $config->config['MAX_ARTICLES'];
		} else {
			$nbpp = (int) 3;
		}

		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$sql = New BDD();
		$sql->table('TABLE_PAGES_ARTICLES');

		if ($id) {
			$request = Common::secureRequest($id);
			if (is_numeric($id)) {
				$sql->where(array(
					'name'  => 'id',
					'value' => $request
				));
			} else {
				$sql->where(array(
					'name'  => 'rewrite_name',
					'value' => $request
				));
			}
			$sql->queryOne();

			if (!empty($sql->data)) {
				$sql->data->link = 'Articles/readmore/'.$sql->data->rewrite_name.'?id='.$sql->data->id;
				if (empty($sql->data->tags)) {
					$sql->data->tags = array();
				} else {
					$sql->data->tags = explode(',', $sql->data->tags);
				}
				$author = $sql->data->author;
				//$user = User::getInfosUserAll($author);
				if (empty($user)) {
					$sql->data->username = constant('UNKNOWN');
					$sql->data->avatar   = constant('DEFAULT_AVATAR');
				} else {
					//$sql->data->username = $user->user->username;
					//$sql->data->avatar   = $user->profils->avatar;
				}
			} else {
				$sql->data = null;
			}
		} else {
			$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
			$sql->limit(array(0 => $page, 1 => $nbpp), true);
			$sql->queryAll();
			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->link = 'Articles/readmore/'.$v->rewrite_name.'/'.$v->id;
				if (empty($sql->data[$k]->tags)) {
					$sql->data[$k]->tags = array();
				} else {
					$sql->data[$k]->tags = explode(',', $sql->data[$k]->tags);
				}
				$author = $sql->data[$k]->author;
			}
		}
		return $sql->data;
	}

	public function getLastArticles ()
	{
		$return = false;

		$sql = New BDD();
		$sql->table('TABLE_PAGES_ARTICLES');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit('1');
		$sql->queryOne();

		if (!empty($sql->data)) {
			$sql->data->link = 'Articles/readmore/'.$sql->data->rewrite_name.'?id='.$sql->data->id;
			if (empty($sql->data->tags)) {
				$sql->data->tags = array();
			} else {
				$sql->data->tags = explode(',', $sql->data->tags);
			}
			$return = $sql->data;
		}
		return $return;
	}

	public function NewView ($id = false)
	{
		if ($id) {
			$id = Common::secureRequest($id);
			$get = New BDD();
			$get->table('TABLE_PAGES_ARTICLES');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			$data = $get->data;
			if ($get->rowCount != 0) {
				$count = (int) $data->view;
				$count++;
				$update = New BDD();
				$update->table('TABLE_PAGES_ARTICLES');
				$update->where($where);
				$update->update(array('view' => $count));
			}
		}
	}
}
