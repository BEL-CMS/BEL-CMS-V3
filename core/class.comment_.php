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
use BelCMS\Requires\Common;
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
		$dispatcher = new Dispatcher();
		$dispatcher->link;
		$dispatcher->link[0] = Common::VarSecure($dispatcher->link[0]);
		$dispatcher->link[1] = Common::VarSecure($dispatcher->link[1]);
		$dispatcher->link[3] = (int) $dispatcher->link[3];

		$sql = New BDD();
		$sql->table('TABLE_COMMENTS');
		$where[] = array('name' => 'page', 'value' => $dispatcher->link[0]);
		$where[] = array('name' => 'page_sub', 'value' => $dispatcher->link[1]);
		if (isset($dispatcher->link[2]) and !empty($dispatcher->link[2])) {
			$where[] = array('name' => 'page_id', 'value' => $dispatcher->link[2]);
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
			$user = UserInfos::getInfosUserAll($hash_key);
			if ($user) {
				$return['username'] = $user->user->username;
				$return['avatar']   = is_file($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
			} else {
				$return['username'] = constant('MEMBER_DELETE');
				$return['avatar']   = constant('DEFAULT_AVATAR');
			}
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
			$links = $dispatcher->link[0].'/'.$dispatcher->link[1].'/';
			if (isset($dispatcher->link[2]) and !empty($dispatcher->link[2])) {
				$links .= $dispatcher->link[2];
			}
			if ($_SESSION['USER']->user->hash_key !== false) {
				$html .= '<form action="Comments/Send" method="post" enctype="multipart/form-data"><input name="url" type="hidden" value="'.$links.'">';
				$html .= '<textarea name="text"></textarea>';
				$html .= '<input type="submit" style="padding: 0 15px;line-height:30px;" class="belcms_btn belcms_bg_grey" value="Envoyer"';
				$html .= '</form>';
			}
		}
		$html .= '</nav>';

		echo $html;
	}
	public static function countComments($page, $page_id)
	{
		$dispatcher = new Dispatcher();
		$sql = New BDD;
		$sql->table('TABLE_COMMENTS');
		if (empty($page)) {
			$where[] = array('name' => 'page', 'value' => $dispatcher->link[0]);
		} else {
			$where[] = array('name' => 'page', 'value' => $page);
		}
		if (!empty($dispatcher->link[1])) {
			$where[] = array('name' => 'page_sub', 'value' => $dispatcher->link[1]);
		}
		if (empty($page_id)) {
			if (isset($dispatcher->link[2]) and !empty($dispatcher->link[2])) {
				$where[] = array('name' => 'page_id', 'value' => $dispatcher->link[2]);
			}
		} else {
			$where[] = array('name' => 'page_id', 'value' => (int) $page_id);
		}
		$sql->where($where);
		$sql->count();
		return $sql->data;
	}
}
