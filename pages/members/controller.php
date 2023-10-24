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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Core\Config as Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Members extends Pages
{
	var $models = 'Members';

	public function index ()
	{
		$set['pagination'] = $this->pagination(10, get_class($this), TABLE_USERS);
		$set['members'] = $this->models->GetUsers();
		$this->set($set);
		$this->render('index');
	}

	public function view ($page,$view,$id)
	{
		$data['groups'] = Secures::getGroups();
		$data['data']   = $this->models->getViewUser($id);
		if (empty($data['data'])) {
			Notification::warning('L\'utilisateur demandé n\'existe pas');
		} else {
			$this->set($data);
			$this->render('view');
		}
	}

	public function AddFriend ($id)
	{
		$user = Users::getInfosUser($id, true);
		if ($user['username'] == DELETE) {
			Notification::error(UNKNOW_MEMBER, FRIEND);
		} else {
			if ($this->models->addFriendSQL ($user['hash_key'] == null)) {
				Notification::warning(ADD_FRIEND_ERROR, FRIEND);
			} else {
				Notification::success(ADD_FRIEND_SUCCESS, FRIEND);
			}
			$this->redirect(true, 2);
		}
	}

	public function json ()
	{
		$data = $this->models->getJson();
		echo json_encode($data);
	}
}
