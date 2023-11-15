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

use BelCMS\Core\Config;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Forum extends AdminPages
{
	var $admin  = false; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd = 'ModelsForum';

	public function index ()
	{
		$data['data'] = $this->models->GetThreads();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'Forum/AddForum?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'Forum/category?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('ALL_MSG_POST') => array('href'=>'Forum/allMsg?management&option=pages','icon'=>'mgc_chat_1_line', 'color' => 'text-warning bg-warning/25'));
		$menu[] = array(constant('ALL_MSG_REP') => array('href'=>'Forum/allMsg?management&option=pages','icon'=>'mgc_chat_1_line', 'color' => 'bg-info text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'Forum/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('index', $menu);
	}

	public function category ()
	{
		$data['data'] = $this->models->GetForum();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD_CAT') => array('href'=>'Forum/addcategory?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'Forum/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$this->render('category', $menu);
	}

	public function allMsg ()
	{
		$data['data'] = $this->models->GettAllPosts();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ALL_MSG_REP') => array('href'=>'Forum/allMsgpost?management&option=pages','icon'=>'mgc_chat_1_line', 'color' => 'bg-info text-white'));
		$this->render('allmsg', $menu);
	}

	public function allMsgpost ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['data'] = $this->models->GettAllPostsMsg();
		$this->set($data);
		$this->render('allmsgpost', $menu);
	}

	public function editmessage ()
	{	
		$id = $this->id;
		$data['data'] = $this->models->GetEditPost($id);
		$this->set($data);
		$this->render('editmessage');
	}

	public function editmessagepost ()
	{	
		$id = $this->id;
		$data['data'] = $this->models->GetEditPostMsg($id);
		$this->set($data);
		$this->render('editMessagepost');
	}

	public function sendeditMessagepost ()
	{	
		$forum = $this->models->sendEditPostMsg($_POST);
		$this->redirect('Forum/allMsgpost?management&option=pages', 2);
		$this->error(get_class($this), $forum["msg"], $forum["type"]);
	}

	public function sendeditmessage ()
	{
		$forum = $this->models->sendEditPost($_POST);
		$this->redirect('Forum/allMsg?management&option=pages', 2);
		$this->error(get_class($this), $forum["msg"], $forum["type"]);
	}

	public function delMessage ()
	{
		$id = $this->id;
		$forum = $this->models->sendDelSujet($id);
		$this->redirect('Forum/allMsg?management&option=pages', 2);
		$this->error(get_class($this), $forum["text"], $forum["type"]);
	}

	public function delMessagepost()
	{
		$id = $this->id;
		$forum = $this->models->sendDelPost($id);
		$this->redirect('Forum/allMsg?management&option=pages', 2);
		$this->error(get_class($this), $forum["text"], $forum["type"]);
	}

	public function addcategory ()
	{
		$data['groups'] = Config::getGroups();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addcategory', $menu);
	}

	public function editCat ()
	{
		$id = $this->id;
		if ($this->models->SecureCat($id) === true) {
			$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$data['groups'] = Config::getGroups();
			$data['data']   = $this->models->GetForum($id);
			$this->set($data);
			$this->render('editcategory', $menu);			
		} else {
			$this->error(get_class($this), constant('NO_ACCESS_CAT'), 'error');
			Common::Redirect('Forum/category?management&pages', 2);
		}
	}

	public function delCategory ()
	{
		$id = $this->id;
		if ($this->models->SecureCat($id) === true) {
			$return = $this->models->delCat($id);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('Forum/category?management&option=pages', 2);
		} else {
			$this->error(get_class($this), constant('NO_ACCESS_CAT'), 'error');
		}
		$this->redirect('Forum/category?management&option=pages', 2);
	}

	public function addforum ()
	{
		$data['data'] = $this->models->GetForum();
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addforum', $menu);
	}

	public function editForum()
	{
		$id = $this->id;
		if (is_numeric($id)) {
			$data['thread'] = $this->models->GetThreads($id);
			$data['data'] = $this->models->GetForum();
			$this->set($data);
			$this->render('editforum');
		}
	}
	# Send
	public function send ()
	{
		if ($_POST['send'] == 'addforum') {
			$return = $this->models->sendAddForum($_POST);
		} else if ($_POST['send'] == 'editforum') {
			$return = $this->models->sendEditForum($_POST);
		} else if ($_POST['send'] == 'addcat') {
			if ($this->models->isCat($_POST['title'])) {
				$return = $this->models->SendAddCat($_POST);
			} else {
				$this->error(get_class($this), constant('CAT_IF_EXIST'), 'infos');
				$this->redirect('Forum/category?management&option=pages', 2);
				return;
			}
		} elseif ($_POST['send'] == 'editcat') {
			$return = $this->models->sendEditCat($_POST);
			$this->redirect('Forum/category?management&option=pages', 2);
			$this->error(get_class($this), $return['text'], $return['type']);
			return;
		}

		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Forum?management&option=pages', 2);
	}

	public function delForum ()
	{
		$id = $this->id;
		$return = $this->models->delThreads($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Forum?management&option=pages', 2);
	}

	public function parameter ()
	{
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$menu[] = array(constant('HOME') => array('href'=>'Forum?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('Forum?management&option=pages', 2);
	}
}