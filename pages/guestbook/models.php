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
use BelCMS\Core\Config;
use BelCMS\Core\Dispatcher;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
# TABLE_GUESTBOOK #
final class GuestBook
{
	function getUser ()
	{
		$config = Config::GetConfigPage('guestbook');
		if (isset($config->config['MAX_USER'])) {
			$nbpp = (int) $config->config['MAX_USER'];
		} else {
			$nbpp = (int) 10;
		}
		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$sql = new BDD();
		$sql->table('TABLE_GUESTBOOK');
		$sql->orderby('ORDER BY `'.TABLE_GUESTBOOK.'`.`id` DESC', true);
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$sql->queryAll();
		$data = $sql->data;
		foreach ($data as $key => $value) {
			if (User::ifUserExist($value->author) == true) {
				$user = User::getInfosUserAll($value->author);
				$username = $user->user->username;
				$data[$key]->author = $username;
				$data[$key]->avatar = is_file(ROOT.DS.$user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
			} else {
				$data[$key]->author = Common::VarSecure($value->author, null);
				$data[$key]->avatar = constant('DEFAULT_AVATAR');
			}
			$data[$key]->date_msg = Common::TransformDate($value->date_msg, 'FULL', 'MEDIUM');
			$data[$key]->message  = Common::VarSecure($value->message, null);
			$data[$key]->message  = Common::getSmiley($value->message);
		}
		return $data;
	}

	public function sendNew ($data)
	{
		$insert['author']  = Common::VarSecure($data['author']);
		$insert['message'] = Common::VarSecure($data['message']);
		$sql = new BDD();
		$sql->table('TABLE_GUESTBOOK');
		$sql->insert($insert);

		$return['msg']  = constant('ADD_NEW_GUESTBOOK');
		$return['type'] = 'success';

		return $return;
	}
}