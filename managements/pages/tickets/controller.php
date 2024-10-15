<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.9 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

 use BelCMS\Core\Config;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use Belcms\Widgets\Controller\Users\Users;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Tickets extends AdminPages
{
    var $admin  = false;
    var $active = true;
    var $bdd = 'ModelsTickets';
    #####################################
    # Liste des Tickets
    ##################################### 
    public function index ()
    {
        $menu[] = array(constant('HOME') => array('href'=>'tickets?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $menu[] = array(constant('CAT') => array('href'=>'tickets/cat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-warning text-white'));
        $menu[] = array(constant('CONFIG') => array('href'=>'tickets/parameter?management&option=pages','icon'=>'mgc_box_3_fill', 'color' => 'bg-dark text-white'));
        $data['tickets'] = $this->models->getTickets();
        $this->set($data);
        $this->render('index', $menu);
    }
    public function edit() {
        $menu[] = array(constant('HOME') => array('href'=>'tickets?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $id = (int) $this->data[2];
        $return['data'] = $this->models->getTickets ($id);
        $return['cat']  = $this->models->getCat();
        $return['user'] = $this->models->GetUser();
        $this->set($return);
        $this->render('ticketsEdit', $menu);
    }
    public function close ()
    {
        $id = (int) $this->data[2];
        $return = $this->models->close($id);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('tickets?management&option=pages', 2);
    }
    public function sendedit ()
    {
        $id                    = (int) $_POST['id'];
        $array['subject']      = Common::MakeConstant(Common::VarSecure($_POST['subject']));
        $array['text_sbiject'] = Common::VarSecure($_POST['text_sbiject'], null);
        $array['cat']          = (int) $_POST['cat'];
        $array['assign']       = Common::VarSecure($_POST['assign'], null);
        $return                = $this->models->sendedit($array, $id);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('tickets?management&option=pages', 2);
    }
    #####################################
    # Liste des catégories
    #####################################
    public function cat ()
    {
        $menu[] = array(constant('HOME') => array('href'=>'tickets?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $menu[] = array(constant('ADD') => array('href'=>'tickets/addcat?management&option=pages','icon'=>'mgc_add_fill', 'color' => 'bg-warning text-white'));
        $data['cat'] = $this->models->getCat();
        $this->set($data);
        $this->render('cat', $menu);
    }
    #####################################
    # Ajoute une catégorie
    #####################################
    public function addcat ()
    {
        $this->render('addcat');
    }
    public function sendadd ()
    {
        $name = Common::VarSecure($_POST['name'], null);
        $return = $this->models->sendAddCat ($name);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('tickets?management&option=pages', 2);
    }

    public function editCat ()
    {
        $menu[] = array(constant('HOME') => array('href'=>'tickets?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $id = (int) $this->data[2];
        $return['name'] = $this->models->editCat ($id);
        $this->set($return);
        $this->render('tickets', $menu);
    }

    public function sendeditcat ()
    {
        $id = (int) $_POST['id'];
        $name = Common::VarSecure($_POST['name'], null);
        $array = array('id' => $id, 'name' => $name);
        $return = $this->models->sendeditcat($array);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('tickets/cat?management&option=pages', 2);
    }

    public function delcat ()
    {
        $id = (int) $this->data[2];
        $return = $this->models->delcat($id);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('tickets/cat?management&option=pages', 2);
    }
    #####################################
    # Parametre
    ##################################### 
    public function parameter ()
    {
        $menu[] = array(constant('HOME') => array('href'=>'Tickets?management&option=pages','icon'=>'mgc_home_3_line', 'color' => 'bg-primary text-white'));
        $data['groups'] = Config::getGroups();
        $data['config'] = Config::GetConfigPage(get_class($this));
        $this->set($data);
        $this->render('parameter', $menu);
    }
    #####################################
    # Envoi les paramètre à la BDD
    ##################################### 
    public function sendparameter ()
    {
        $return = $this->models->sendparameter($_POST);
        $this->error(get_class($this), $return['text'], $return['type']);
        $this->redirect('Tickets?management&option=pages', 2);
    }
}