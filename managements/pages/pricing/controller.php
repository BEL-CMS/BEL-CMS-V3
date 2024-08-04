<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Pricing extends AdminPages
{
	var $admin  = false;
	var $active = true;
	var $bdd = 'ModelsPricing';
	#####################################
	# Liste des Plan
	##################################### 
    public function index ()
    {
        $menu[] = array(constant('HOME') => array('href'=>'pricing?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('VIEW_LIST') => array('href'=>'pricing/listing?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-warning text-white'));
		$menu[] = array(constant('CONFIG') => array('href'=>'pricing/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));

        $data['plan'] = $this->models->getPlan();

        foreach ($data['plan'] as $key => $value) {
            if (!empty($value->listing)) {
                $data['plan'][$key]->listing = $this->models->getListingName($value->listing);
            }
        }

        $this->set($data);
        $this->render('index', $menu);
    }
	#####################################
	# Ajouter un Plan
	##################################### 
    public function add ()
    {
		$menu[] = array(constant('HOME') => array('href'=>'pricing?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $data['list'] = $this->models->getList();
        $this->set($data);
        $this->render('add', $menu);
    }
    public function sendadd ()
    {

        $post['name']        = Common::VarSecure($_POST['name'], null);
        $post['price']       = is_numeric($_POST['price']) ? $_POST['price'] : 0;
        $post['description'] = Common::VarSecure($_POST['description'], null);
        $post['per']         = Common::VarSecure($_POST['per'], null);
        $post['listing']     = is_numeric($_POST['list']) ? $_POST['list'] : 0;
        $post['sort_asc']    = is_numeric($_POST['sort_asc']) ? $_POST['sort_asc'] : 1;

        $return = $this->models->sendPlan ($post);

        $this->redirect('pricing/listing?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
    }
	#####################################
	# Editer un Plan
	#####################################
    public function EditPlan ()
    {
        $id = (int) $this->data[2];
        $d['data'] = $this->models->getPlan ($id);
        $d['list'] = $this->models->getList();
        $this->set($d);
        $this->render('edit');
    }
    public function sendEdit ()
    {
        $id                  = (int) $_POST['id'];
        $post['name']        = Common::VarSecure($_POST['name'], null);
        $post['price']       = is_numeric($_POST['price']) ? $_POST['price'] : 0;
        $post['per']         = Common::VarSecure($_POST['per'], null);
        $post['description'] = Common::VarSecure($_POST['description'], null);
        $post['listing']     = is_numeric($_POST['list']) ? $_POST['list'] : 0;
        $post['sort_asc']    = is_numeric($_POST['sort_asc']) ? $_POST['sort_asc'] : 0;

        $return = $this->models->sendEdit($post, $id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('pricing?management&option=pages', 2);
    }
	#####################################
	# Supprime un Plan
	#####################################
	public function delPlan ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDelPlan ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('pricing?management&option=pages', 2);
	}
	#####################################
	# Supprime une liste
	#####################################
	public function delListing ()
	{
		$id = (int) $this->data[2];
		$return = $this->models->sendDelList ($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('pricing?management&option=pages', 2);
	}
	#####################################
	# Liste des choix (5)
	##################################### 
    public function listing ()
    {
		$menu[] = array(constant('HOME') => array('href'=>'pricing?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
		$menu[] = array(constant('ADD')  => array('href'=>'pricing/listingAdd?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-success text-white'));    
        $data['list'] = $this->models->getList();

        $this->set($data);
        $this->render('listing', $menu);
    }

    public function listingAdd ()
    {
		$menu[] = array(constant('HOME') => array('href'=>'pricing?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $this->render('addlisting', $menu);   
    }

    public function sendaddlisting ()
    {
        $post['name']  = Common::VarSecure($_POST['name'], null);
        $post['cat_1'] = Common::VarSecure($_POST['cat_1'], null);
        $post['cat_2'] = Common::VarSecure($_POST['cat_2'], null);
        $post['cat_3'] = Common::VarSecure($_POST['cat_3'], null);
        $post['cat_4'] = Common::VarSecure($_POST['cat_4'], null);
        $post['cat_5'] = Common::VarSecure($_POST['cat_5'], null);
        $post['actif_1'] = isset($_POST['actif_1']) ? true : false;
        $post['actif_2'] = isset($_POST['actif_2']) ? true : false;
        $post['actif_3'] = isset($_POST['actif_3']) ? true : false;
        $post['actif_4'] = isset($_POST['actif_4']) ? true : false;
        $post['actif_5'] = isset($_POST['actif_5']) ? true : false;

        $return = $this->models->sendList ($post);

        $this->redirect('pricing/listing?management&option=pages', 2);
        $this->error(get_class($this), $return['text'], $return['type']);
    }
}