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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Forum extends Pages
{
	var $models = 'ModelsForum';

	public function index ()
	{
		$data['forum'] = $this->models->getForum();

		if (empty($data['forum'])) {
			$this->error('Forum', 'Aucun Forum enregistrée en base de donnée.', 'warning');
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

	public function threads ($title, $id)
	{
		$data['id']      = (int) $id;
		$data['threads'] = $this->models->GetThreadsPost($data['id']);
		$groupUser       = Users::getGroups($_SESSION['USER']['HASH_KEY']);
		//$current         = current($data['threads']);
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
/*
##### Consomme trop de resource #####
		if ($access === false and isset($_SESSION['USER']['HASH_KEY'])) {
			$this->error('Forum', 'Tentative accès non autorisé, un administrateur à été prévenue.', 'error');
			$Interaction = New Interaction;
			$Interaction->user($_SESSION['USER']['HASH_KEY']);
			$Interaction->title('Accès non autorisé');
			$Interaction->type('error');
			$Interaction->text('Accès non autorisé de '.Users::hashkeyToUsernameAvatar($_SESSION['USER']['HASH_KEY']).' à la page Forum: threads');
			$Interaction->insert();
			$this->redirect(true, 2);
			return false;
		}
*/
		foreach ($data['threads'] as $k => $v) {
			$data['threads'][$k]->options = Common::transformOpt($v->options);
			$last = $this->models->getLastPostsForum($v->id);
			if (empty($last)) {
				$data['threads'][$k]->last = $this->models->getLastPostsOriginForum($v->id, $v->id_threads);
			} else {
				$data['threads'][$k]->last = $last;
			}
			
		}

		if (!empty($data['threads'])) {
			foreach ($data['threads'] as $key => $value) {
				$v = $value->id_threads;
			}
			$data['name'] = $this->models->GetThreadName($v);
		} else {
			$data['name'] = null;
		}

		$this->set($data);
		$this->render('threads');
	}

	public function post ($name = '', $id = '')
	{
		if (empty($name)) {
			$this->error('Forum', 'Page manquante...', 'error');
			$this->redirect('Forum', 3);
			return;
		}
		$d = array();
		$id = (int) $id;
		$_SESSION['REPLYPOST']   = $id;
		$_SESSION['FORUM']       = uniqid('forum_');
		$_SESSION['FORUM_CHECK'] = $_SESSION['FORUM'];
		$this->models->addView($id);
		$d['post'] = $this->models->GetPosts($name, $id);
		if (count($d['post']) == 0) {
			$this->error(get_class($this), 'Page manquante...', 'error');
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
		$this->error(get_class($this), $forum["msg"], $forum["type"]);
	}

	public function EditPost ($id = null)
	{
		$id     = Common::SecureRequest($id);
		$d['d'] = $this->models->editpost($id);
		if (Users::isSuperAdmin($_SESSION['USER']['HASH_KEY']) or $d['d']->author == $_SESSION['USER']['HASH_KEY']) {
			$this->set($d);
			$this->render('editpost');			
		} else {
			$this->error(FORUM, NO_ACCESS_POST, 'error');
		}
	}

	public function EditPostPrimary ($id = null)
	{
		$id     = Common::SecureRequest($id);
		$d['d'] = $this->models->editpostprimary($id);
		if (Users::isSuperAdmin($_SESSION['USER']['HASH_KEY']) or $d['d']->author == $_SESSION['USER']['HASH_KEY']) {
			$this->set($d);
			$this->render('editpostprimary');			
		} else {
			$this->error(FORUM, NO_ACCESS_POST, 'error');
		}
	}

	public function SendEditPost ()
	{
		if (Users::isSuperAdmin($_SESSION['USER']['HASH_KEY']) or $_POST['author'] == $_SESSION['USER']['HASH_KEY']) {
		$return = $this->models->sendEditPost($_POST);
		$this->error (get_class($this), $return['msg'], $return['type']);
		} else {
			$this->error(FORUM, NO_ACCESS_POST, 'error');
		}
		$this->redirect('Forum', 2);
	}

	public function SendEditPostPrimary ()
	{
		if (Users::isSuperAdmin($_SESSION['USER']['HASH_KEY']) or $_POST['author'] == $_SESSION['USER']['HASH_KEY']) {
		$return = $this->models->SendEditPostPrimary($_POST);
		$this->error (get_class($this), $return['msg'], $return['type']);
		} else {
			$this->error(FORUM, NO_ACCESS_POST, 'error');
		}
		$this->redirect('Forum', 2);	
	}

	private function accessLock ($id)
	{
		$groupUser = Users::getGroups($_SESSION['USER']['HASH_KEY']);

		if (in_array('1', $groupUser)) {
			return true;
		}

		$access    = false;
		$forumAccess = $this->models->getAccessForum($id);
		foreach ($forumAccess as $k => $v) {
			if (in_array($v, $groupUser)) {
				$access = true;
				break;
			}
		}
		return $access;
	}

	public function lockpost ($id)
	{
			if (self::accessLock($id)) {
				$return = $this->models->lock($id);
				$this->error (get_class($this), $return['msg'], $return['type']);
			} else {
				$this->error (get_class($this), NO_CLOSE_POST, 'error');
			}
			$this->redirect('Forum', 2);
	}

	public function unlockpost ($id)
	{
			if (self::accessLock($id)) {
				$return = $this->models->unlock($id);
				$this->error (get_class($this), $return['msg'], $return['type']);
			} else {
				$this->error (get_class($this), NO_ACCESS_POST, 'error');
			}
			$this->redirect('Forum', 2);
	}

	public function delpost ($id)
	{
		if (self::accessLock($id)) {
			$return = $this->models->delpost($id);
			$this->error (get_class($this), $return['msg'], $return['type']);
		} else {
			$this->error (get_class($this), NO_ACCESS_POST, 'error');
		}
		$this->redirect('Forum', 2);
	}

	public function NewThread ($name)
	{
		$_SESSION['NEWTHREADS'] = $name;
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
		$insert = $this->models->SubmitThread($data['id'], $data);
		$this->error (get_class($this), $insert['msg'], $insert['type']);
		$this->redirect('Forum', 2);
	}

	private function SubmitReply ($data)
	{
		$referer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'Forum';
		$insert  = $this->models->SubmitPost($data);
		$this->error (get_class($this), $insert['msg'], $insert['type']);
		$this->redirect('Forum', 2);
	}
}