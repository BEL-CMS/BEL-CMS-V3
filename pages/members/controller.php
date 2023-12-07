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

namespace Belcms\Pages\Controller;
use BelCMS\Core\Config;
use Belcms\Pages\Pages;
use BelCMS\Core\Notification;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Members extends Pages
{
	var $useModels = 'Members';

	public function index ()
	{
		$config =  Config::GetConfigPage('members');
		$set['pagination'] = $this->pagination($config->config['MAX_USER'], 'members', constant('TABLE_USERS'));
		$set['members'] = $this->models->GetUsers();
		$this->set($set);
		$this->render('index');
	}

	public function profil ()
	{
		$name = Common::VarSecure($this->data[2], null);
		$data['groups'] = Secures::getGroups();
		$data['data']   = $this->models->getViewUser($name);
		if (empty($data['data'])) {
			Notification::warning('L\'utilisateur demandé n\'existe pas', constant('USER'));
		} else {
			$this->set($data);
			$this->render('profil');
		}
	}

	public function AddFriend ($id)
	{
		$user = User::getInfosUserAll($id);
		$user = $user->username;
		if ($user['username'] == constant('DELETE')) {
			Notification::error(constant('UNKNOW_MEMBER'), constant('FRIEND'));
		} else {
			if ($this->models->addFriendSQL ($user['hash_key'] == null)) {
				Notification::warning(constant('ADD_FRIEND_ERROR, FRIEND'));
			} else {
				Notification::success(constant('ADD_FRIEND_SUCCESS, FRIEND'));
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
