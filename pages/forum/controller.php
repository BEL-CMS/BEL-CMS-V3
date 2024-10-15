<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Forum extends Pages
{
	var $useModels = 'Forum';

	public function index ()
	{
		$data['forum'] = $this->models->getForum();

		if (empty($data['forum'])) {
			$this->error = true;
			$this->errorInfos = array('warning', 'Aucun Forum enregistrée en base de donnée.', constant('INFO'), false);
			return false;
		}

		foreach ($data['forum'] as $k => $v) {
			$data['forum'][$k]->category = $this->models->getCatForum($v->id);
			foreach ($data['forum'][$k]->category as $last_k => $last_v) {
				$data['forum'][$k]->category[$last_k]->countPosts = $this->models->getCountPost($last_v->id);
				$data['forum'][$k]->category[$last_k]->count = $this->models->CountSjForum($data['forum'][$k]->category[$last_k]->id);

				$last = $this->models->getLastPostForum($last_v->id);
				if (empty($last)) {
					$data['forum'][$k]->category[$last_k]->last = (object) array();
					$data['forum'][$k]->category[$last_k]->last->title     = null;
					$data['forum'][$k]->category[$last_k]->last->date_post = null;
					$data['forum'][$k]->category[$last_k]->last->author    = null;
				} else {
					$data['forum'][$k]->category[$last_k]->last = $last;
				}
			}
		}

		$this->set($data);
		$this->render('main');
	}

	public function threads ()
	{
		$data['id']      = (int) $this->id;
		$data['threads'] = $this->models->GetThreadsPost($data['id']);
		if (User::isLogged()) {
			$groupUser   = $_SESSION['USER']->groups->all_groups;
		} else {
			$groupUser = array(0 => 0);
		}
		$access          = false;
		$secure          = $this->models->securityPost((int) $data['id']);

		if (in_array('1', $groupUser)) {
			$access = true;
		} else {
			if ($secure === true) {
				$access = true;
			} else {
				foreach ($secure as $k_secure => $v_secure) {
					if (in_array($v_secure, $groupUser)) {
						$access = true;
						break;
					}
				}
			}
		}


		foreach ($data['threads'] as $k => $v) {
			$last = $this->models->getLastPostsForum($v->id);
			if (empty($last)) {
				$data['threads'][$k]->last = $this->models->getLastPostsOriginForum($v->id, $v->id_threads);
			} else {
				$data['threads'][$k]->last = $last;
			}
			$data['threads'][$k]->reply = $this->models->GetNbReply($v->id);
		}


		if (!empty($data['threads'])) {
			foreach ($data['threads'] as $key => $value) {
				$v = $value->id_threads;
			}
			$data['name'] = $this->models->GetThreadName($v);
		} else {
			$data['name'] = null;
		}

		if (!empty($data['threads'])) {
			$data['reply'] = $this->models->GetNbReply($data['threads'][0]->id);
		}


		$this->set($data);
		$this->render('threads');
	}

	public function post ()
	{
		if (empty($this->subPageName)) {
			$this->error = true;
			$this->errorInfos = array('error', 'Page manquante...', 'Forum', false);
			$this->redirect('Forum', 3);
			return;
		}
		$d = array();
		$id = (int) $this->id;
		$_SESSION['REPLYPOST']   = $id;
		$_SESSION['FORUM']       = uniqid('forum_');
		$_SESSION['FORUM_CHECK'] = $_SESSION['FORUM'];
		$this->models->addView($id);
		$d['post'] = $this->models->GetPosts($this->subPageName, $id);
		if (count($d['post']) == 0) {
			$this->error = true;
			$this->errorInfos = array('error', 'Page manquante...', 'Forum', false);
			return;
		} else {
			$this->set($d);
			$this->render('post');
		}
	}

	public function sendeditmessage ()
	{
		$forum = $this->models->sendEditPost($_POST);
		$this->redirect('Forum/allMsg?management&page=true', 2);
		$this->error = true;
		$this->errorInfos = array($forum["type"], $forum["msg"], 'Forum', false);
	}

	public function EditPost ()
	{
		$id     = Common::SecureRequest($this->id);
		$d['d'] = $this->models->editpost($id);
		if (in_array(1, $_SESSION['USER']->groups->all_groups) or $d['d']->author == $_SESSION['USER']->user->hash_key) {
			$this->set($d);
			$this->render('editpost');
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
	}

	public function EditPostPrimary ()
	{
		$id     = Common::SecureRequest($this->id);
		$d['d'] = $this->models->editpostprimary($id);
		if (in_array(1, $_SESSION['USER']->groups->all_groups) or $d['d']->author == $_SESSION['USER']->user->hash_key) {
			$this->set($d);
			$this->render('editpostprimary');			
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
	}

	public function SendEditPost ()
	{
		if (in_array(1, $_SESSION['USER']->groups->all_groups) or $_POST['author'] == $_SESSION['USER']->user->hash_key) {
		$return = $this->models->sendEditPost($_POST);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
		$this->redirect('Forum', 2);
	}

	public function SendEditPostPrimary ()
	{
		if (in_array(1, $_SESSION['USER']->groups->all_groups) or $_POST['author'] == $_SESSION['USER']->user->hash_key) {
			$return = $this->models->SendEditPostPrimary($_POST);
			$this->error = true;
			$this->errorInfos = array('error', $return['msg'], 'Forum', false);
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
		$this->redirect('Forum', 2);	
	}

	private function accessLock ($id)
	{
		$return = false;
		$forumAccess = $this->models->getAccessForum($id);
		/* Si logué return tout les groupes, autrement groupe visiteur (0) */
		if (User::isLogged()) {
			$groupUser = $_SESSION['USER']->groups->all_groups;
		} else {
			$groupUser = array(0 => 0);
		}
		/* Admin de niveau 1 */
		if (in_array('1', $groupUser)) {
			return true;
		}
		/* Si c'est un modérateur */
		if ($this->models->getModerator() === true) {
			return true;
		}
		/* Si logué et si c'est son post */
		if (User::isLogged()) {
			if ($forumAccess->author == $_SESSION['USER']->user->hash_key) {
				return true;
			}
		}
		return $return;
	}

	private function accessLockAdmin ($id)
	{
		$return = false;
		/* Si logué return tout les groupes, autrement groupe visiteur (0) */
		if (User::isLogged()) {
			$groupUser = $_SESSION['USER']->groups->all_groups;
		} else {
			$groupUser = array(0 => 0);
		}
		/* Admin de niveau 1 */
		if (in_array('1', $groupUser)) {
			return true;
		}
		/* Si c'est un modérateur */
		if ($this->models->getModerator() === true) {
			return true;
		}
		return $return;
	}

	public function lockpost ()
	{
		$id = (int) $this->id;
		if (self::accessLock($id)) {
			$return = $this->models->lock($id);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_CLOSE_POST'), 'Forum', false);
		}
		$this->redirect($_SERVER['HTTP_REFERER'], 2);
	}

	public function unlockpost ()
	{
		$id = (int) $this->id;
		if (self::accessLock($id)) {
			$return = $this->models->unlock($id);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
		$this->redirect($_SERVER['HTTP_REFERER'], 2);
	}

	public function delpost ($id)
	{
		$id = (int) $this->id;
		if (self::accessLockAdmin($id)) {
			$return = $this->models->delpost($id);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		} else {
			$this->error = true;
			$this->errorInfos = array('error', constant('NO_ACCESS_POST'), 'Forum', false);
		}
		$this->redirect('Forum', 2);
	}

	public function NewThread ()
	{
		$id = (int) $this->id;
		$_SESSION['NEWTHREADS'] = $id;
		$this->render('newthread');
	}

	public function send ()
	{
		if ($_REQUEST['send'] == 'SubmitReply') {
			self::SubmitReply($this->data);
		} else if ($_REQUEST['send'] == 'NewThread') {
			self::NewPostThread($this->data);
		}
	}

	private function NewPostThread ($data)
	{
		$return = $this->models->SubmitThread($data['id'], $data);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		$this->redirect('Forum', 2);
	}

	private function SubmitReply ($data)
	{
		$referer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'Forum';
		$return  = $this->models->SubmitPost($data);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], 'Forum', false);
		//$this->redirect($referer, 2);
	}
}