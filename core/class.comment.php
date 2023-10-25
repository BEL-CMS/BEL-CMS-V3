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
namespace BelCMS\Core;
use BelCMS\PDO\BDD as BDD;
use BELCMS\User\User as UserInfos;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Comment
{
	public 	$id,
			$page,
			$view;

	private function getMessage ()
	{
		$sql = New BDD();
		$sql->table('TABLE_COMMENTS');
		$where[] = array('name' => 'page', 'value' => $this->page);
		$where[] = array('name' => 'page_sub', 'value' => $this->view);
		if (isset($this->id) and !empty($this->id)) {
			$where[] = array('name' => 'page_id', 'value' => $this->id);
		}
		$sql->where($where);
		$sql->queryAll();

		foreach ($sql->data as $k => $v) {
			$sql->data[$k]->user = self::getDataUser($v->hash_key);
		}

		return $sql->data;
	}

	private function getDataUser ($hash_key = null)
	{
		if ($hash_key AND strlen($hash_key) == 32) {
			$sql = New BDD();
			$sql->table('TABLE_USERS');
			$sql->where(array('name' => 'hash_key', 'value' => $hash_key));
			$sql->fields(array('username', 'avatar'));
			$sql->queryOne();
			$data = $sql->data;
			if ($sql->rowCount == 1) {
				if (empty($data->username)) {
					$data->username = constant('UNLISTED');
				}
				if (empty($data->avatar) and !is_file($data->avatar)) {
					$data->avatar = constant('AVATAR_DEFAULT');
				}
				$return = $data;
			} else {
				$return['username'] = 'Non répertorié';
				$return['avatar'] = constant('AVATAR_DEFAULT');;
				$return = (object) $return;
			}
		} else {
			$return['username'] = 'Non répertorié';
			$return['avatar'] = constant('AVATAR_DEFAULT');
			$return = (object) $return;
		}
		return $return;
	}

	public function html ()
	{
		$link  = null;
		$html  = '<nav id="bel_cms_comment">';
		$html .= '<ul>'; 

		$message = self::getMessage();

		foreach ($message as $k => $v) {
			$html .= '<li class="bel_cms_comment_item">';
			$html .= '<div class="bel_cms_comment_author">';
			$html .= '<img src="'.$v->user->avatar.'" alt="avatar">';
			$html .= '<div class="bel_cms_comment_date">';
			$html .= '<div class="belcms_comments_infos">';
			$html .= '<a class="simple-tooltip" title="'.$v->user->username.'" href="#">'.$v->user->username.'</a>';
			$html .= '<span>'.$v->date_com.'</span>';
			$html .= '</div></div>';
			$html .= '<div class="belcms_comments_com">'.$v->comment.'</div>';
			$html .= '</li>';
		}
			$html .= '</ul>
			';
		if (UserInfos::isLogged() === true) {
			$dispatcher = new Dispatcher();
			$dispatcher->link;
			$links = $dispatcher->link[0].'/'.$dispatcher->link[1].'/';
			if (isset($dispatcher->link[3]) and !empty($dispatcher->link[3])) {
				$links .= $dispatcher->link[3];
			}
			if ($_SESSION['USER']['HASH_KEY'] !== false) {
				$html .= '<form action="Comments/Send" method="post" enctype="multipart/form-data"><input name="url" type="hidden" value="'.$links.'"><textarea name="text"></textarea><button type="submit" class="btn btn-primary">Envoyer</button></form>';
			}
		}
		$html .= '</nav>';

		echo $html;
	}
	public static function countComments($page, $page_id)
	{
		$sql = New BDD;
		$sql->table('TABLE_COMMENTS');
		$where[] = array(
					'name'  => 'page_id',
					'value' => (int) $page_id
				);
		$where[] = array(
					'name'  => 'page',
					'value' => $page
				);
		$sql->where($where);
		$sql->count();
		return $sql->data;
	}
}
