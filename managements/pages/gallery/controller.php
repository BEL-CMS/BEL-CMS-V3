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

use BelCMS\Core\Config;
use BelCMS\Core\Secure;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Gallery extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd    = 'ModelsGallery';
	#####################################
	# Page principal
	#####################################
	public function index ()
	{
		$menu[] = array(constant('ADD') => array('href'=>'gallery/add?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'gallery/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('SUB_CAT') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_archive_fill', 'color' => 'bg-dark/80 text-white'));
		$menu[] = array(constant('A_VALID') => array('href'=>'gallery/Valid?management&option=pages','icon'=>'mgc_check_2_fill', 'color' => 'bg-violet-500 border-violet-500 text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->getImg();
		$this->set($data);
		$this->render('index', $menu);
	}
	#####################################
	# Ajoute une image
	#####################################
	public function add ()
	{
		$data['cat'] = $this->models->GetNameSubCat(null);
		$this->set($data);
		$this->render('add');
	}
	public function sendadd ()
	{
		$return = $this->models->sendadd ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
	#####################################
	# Edit une image
	#####################################
	public function edit ()
	{
		$id = (int) $this->data[2];
		$data['data'] = $this->models->getImg($id);
		$data['cat'] = $this->models->GetNameSubCat(null);
		$this->set($data);
		$this->render('edit');
	}
	public function sendEdit ()
	{
		$return = $this->models->sendEdit ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
	#####################################
	# Efface une image
	#####################################
	public function del ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDel ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
	#####################################
	# Paramètres
	#####################################
	public function parameter ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$data['groups'] = Config::getGroups();
		$data['config'] = Config::GetConfigPage(get_class($this));
		$this->set($data);
		$this->render('parameter', $menu);
	}

	public function sendparameter ()
	{
		$return = $this->models->sendparameter($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
	#####################################
	# Main Catégorie
	#####################################
	public function cat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'gallery/addCat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('SUB_CAT') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_archive_fill', 'color' => 'bg-dark/80 text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->GetNameCat(null);
		$this->set($data);
		$this->render('cat', $menu);
	}
	#####################################
	# Ajoute une catégorie
	#####################################
	public function addCat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$this->render('addcat', $menu);
	}
	public function sendaddcat ()
	{
		$return = $this->models->sendAddCat ($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}
	#####################################
	# Éditer une catégorie
	#####################################
	public function editCat ()
	{
		$id = (int) $this->data[2];
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$d['data'] = $this->models->GetNameCat($id);
		$this->set($d);
		$this->render('editcat', $menu);
	}
	public function sendEditCat ()
	{
		$return = $this->models->sendEditCat($_POST);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}
	#####################################
	# Éfface une catégorie
	#####################################
	public function delcat ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delcat($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/cat?management&option=pages', 2);
	}
	#####################################
	# Main sous-catégorie
	#####################################
	public function subcat ()
	{
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD') => array('href'=>'gallery/addsubCat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'gallery/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
		$data['data'] = $this->models->GetNameSubCat(null);
		$this->set($data);
		$this->render('subcat', $menu);	
	}
	#####################################
	#  Ajouté une sous-catégorie
	#####################################
	public function addSubCat ()
	{
		$data['cat'] = $this->models->GetAllCat();
		if (count($data['cat']) == 0) {
			$this->error(get_class($this), constant('PLEASE_ADD_MAIN_CAT'), 'warning');
			$this->redirect('gallery/addCat?management&option=pages', 3);
		} else {
			$menu[] = array(constant('HOME') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
			$this->set($data);
			$this->render('addsubcat', $menu);		
		}
	}
	public function sendaddsubcat ()
	{
		if (empty($_POST['name'])) {
			$this->error(get_class($this), constant('PLEASE_ADD_NAME'), 'warning');
			$this->redirect('gallery/addsubCat?management&option=pages', 3);	
		}

		if (!isset($_POST['groups'])) {
			$group = 1;
		} else if (is_array($_POST['groups'])) {
			$group = implode('|', $_POST['groups']);
		} else {
			$group = 1;
		}

		$post['name']           = Common::VarSecure($_POST['name']);
		$post['color']          = Common::VarSecure($_POST['textcolor']);
		$post['bg_color']       = Common::VarSecure($_POST['bgcolor']);
		$post['id_gallery']     = Secure::isInt($_POST['main_group']);
		$post['groups_access']  = $group;

		$return = $this->models->sendAddSubCat ($post);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/subcat?management&option=pages', 2);
	}
	public function sendeditsubcat ()
	{
		if (empty($_POST['name'])) {
			$this->error(get_class($this), constant('PLEASE_ADD_NAME'), 'warning');
			$this->redirect('gallery/addsubCat?management&option=pages', 3);	
		}

		if (!isset($_POST['groups'])) {
			$group = 1;
		} else if (is_array($_POST['groups'])) {
			$group = implode('|', $_POST['groups']);
		} else {
			$group = 1;
		}

		$post['name']          = Common::VarSecure($_POST['name']);
		$post['color']         = Common::VarSecure($_POST['textcolor']);
		$post['bg_color']      = Common::VarSecure($_POST['bgcolor']);
		$post['groups_access'] = $group;
		$id_gallery            = (int) Secure::isInt($_POST['id_gallery']);

		$return = $this->models->sendEditSubCat ($post, $id_gallery);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/subcat?management&option=pages', 2);
	}
	#####################################
	#  Supprime une sous-catégorie
	#####################################
	public function delsubcat ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->delsubcat($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery/subcat?management&option=pages', 2);
	}
	#####################################
	# Edite la sous-catégorie
	#####################################
	public function editSubCat ()
	{
		$id = (int) $this->data[2];
		$menu[] = array(constant('HOME') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$d['data'] = $this->models->GetNameSubCat($id);
		$this->set($d);
		$this->render('editsubcat', $menu);	
	}
	#####################################
	# Page de validation
	#####################################
	public function Valid() {
		$menu[] = array(constant('HOME') => array('href'=>'gallery?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('CAT') => array('href'=>'gallery/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('SUB_CAT') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_archive_fill', 'color' => 'bg-dark/80 text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));

		$data['data'] = $this->models->getNoValid();
		if (!empty($data['data'])) {
			foreach ($data['data'] as $key => $v) {
				if (User::ifUserExist($v->author)) {
					$user = User::getInfosUserAll($v->author);
					$data['data'][$key]->author = $user->user->username;
				}
			}
		}
		$this->set($data);

		$this->render('valid', $menu);
	}
	#####################################
	# Tout validées
	#####################################
	public function DeleteAll ()
	{
		$return = $this->models->deleteAll ();
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
	#####################################
	# Tmp File : édition
	#####################################
	public function tmpEdit ()
	{
		$menu[] = array(constant('CAT') => array('href'=>'gallery/cat?management&option=pages','icon'=>'mgc_binance_coin_BNB_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('SUB_CAT') => array('href'=>'gallery/subcat?management&option=pages','icon'=>'mgc_archive_fill', 'color' => 'bg-dark/80 text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'gallery/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));

		$cat['cat'] = $this->models->GetNameSubCat();
		$this->set($cat);

		$id = (int) $this->data[2];
	    $data['data'] = $this->models->getTmpID($id);
		if (User::ifUserExist($data['data']->author)) {
			$user = User::getInfosUserAll($data['data']->author);
			$data['data']->author = $user->user->username;
		}
		$this->set($data);
		$this->render('tmpedit', $menu);
	}
	#####################################
	# Accept File and move file gallery
	#####################################
	public function accept()
	{
		$id                  = (int) $_POST['id'];

		$post['name']        = Common::VarSecure($_POST['name']);
		$post['uploader']    = Common::VarSecure($_POST['author']);
		$post['date_insert'] = Secure::validateDate($_POST['date']) ? $_POST['date'] : Common::DatetimeSQL($_POST['date']);
		$post['image']       = str_replace("tmp/", '', $_POST['image']);
		$post['description'] = Common::VarSecure($_POST['description'], 'html');
		$post['cat']         = Common::VarSecure($_POST['cat']);

		$destination = ROOT.$post['image'];
		$return = $this->models->accept ($post, $id);
	    rename(ROOT.$_POST['image'], $destination);

		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('gallery?management&option=pages', 2);
	}
}