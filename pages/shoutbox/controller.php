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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Shoutbox extends Pages
{
	var $useModels = 'Shoutbox';

	function index ()
	{
		$this->render('index');
	}

	public function send ()
	{
		$return = self::insertMsg();
		echo $return;
	}
	public function getLast ()
	{
		$id = (int) $_GET['id'];
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$where = array('name' => 'id', 'value' => $id, 'op' => '>');
		$sql->where($where);
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
		} else {
			$return = array();
		}
		return $return;
	}
	public function get()
	{
		$return = null;
		$get = self::getLast();
		$i = 1;
		foreach ($get as $k => $v):
			$i++;

			if (!empty($v->hash_key)) {
				$infosUser = User::getInfosUserAll($v->hash_key);
				$username  = $infosUser->user->username;
				$avatar    = empty($infosUser->profils->avatar) ? constant('DEFAULT_AVATAR') : $infosUser->profils->avatar;
			} else {
				$username  = 'Inconnu';
				$avatar    = constant('DEFAULT_AVATAR');
			}

			$msg = ' ' . $v->msg;
			$msg = preg_replace("#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i", '\1<a href="http://\2.\3" onclick="window.open(this.href); return false;">\2.\3</a>', $msg);
			$msg = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $msg);

			$return .= '<li id="id_'.$v->id.'">
				<a data-toggle="tooltip" title="'.$username.'" href="Members/View/'.$username.'" class="avatar">
					<img src="'.$avatar.'">
				</a>
				<div class="message_wrap">
					<div class="info"> <a data-toggle="tooltip" title="'.$username.'" href="Members/View/'.$username.'" class="name">'.$username.'</a> <span class="time">'.$v->date_msg.'</span>
					</div>
					<div class="text">'.Common::getSmiley($msg).'</div>
				</div>
			</li>';
		endforeach;

		return $return;
	}

	public function insertMsg()
	{
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			$return['text'] = 'Erreur HashKey';
			$return['type'] = 'danger';
			return $return;
		} else {
			$data['hash_key'] = $_SESSION['USER']->user->hash_key;
		}

		if (!empty($_SESSION['USER']->user->hash_key)) {
			$infosUser = User::getInfosUserAll($_SESSION['USER']->user->hash_key);
			$data['avatar'] = empty($infosUser->profils->avatar) ? constant('DEFAULT_AVATAR') : $infosUser->profils->avatar;
		} else {
			$data['avatar']    = constant('DEFAULT_AVATAR');
		}

		if (empty($_REQUEST['text'])) {
			$return['text'] = 'Erreur Message Vide';
			$return['type'] = 'danger';
			return json_encode($return);
		} else {
			$data['msg'] = Common::VarSecure($_REQUEST['text'], '<a><b><p><strong>');
		}

		$sql = New BDD();
		$sql->table('TABLE_SHOUTBOX');
		$sql->insert($data);

		$return['text']	= 'Message envoyer avec succès';
		$return['type']	= 'success';

		return $return;
	}

	public function getMessageJson ($api_key)
	{
		if (defined('API_KEY')) {
			if (!empty($api_key) && $api_key == constant('API_KEY')) {
				echo array('shoutbox' => $this->models->getMsgJson());
			} else {
				$return['shoutbox'] = 'Erreur API Key';
				echo $return;
			}
		} else {
			$return['shoutbox'] = 'Erreur API Key';
			echo $return;
		}
	}

	public function sendMessageJson ($api_key)
	{
		if (defined('API_KEY')) {
			if (!empty($api_key) && $api_key == constant('API_KEY')) {
				echo $this->models->insertMsgJson($this->data['hash_key'], $this->data['text']);
			} else {
				$return['text'] = 'Erreur API Key';
				echo $return;
			}
		} else {
			$return['text'] = 'Erreur API Key';
			echo $return;
		}
	}

}
