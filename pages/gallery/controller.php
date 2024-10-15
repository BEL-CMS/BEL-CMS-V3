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

use BelCMS\Core\Captcha;
use Belcms\Pages\Pages;
use BelCMS\Core\Config;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use GetHost;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Gallery extends Pages
{
	var $useModels = 'Gallery';
    #####################################
    # Page d'accueil index
    #####################################
	public function index ()
	{
		$config = Config::GetConfigPage('gallery');
		$data['pagination'] = $this->pagination($config->config['MAX_CAT'], 'gallery', constant('TABLE_GALLERY_CAT'));
        $data['count'     ] = $this->models->countImg ();
        $data['cat']        = $this->models->geAlltCat ();

        $this->set($data);
        $this->render('index');
    }
    #####################################
    # Page d'accueil - sous catégorie
    #####################################
    public function subcat ()
    {
        $id = (int) $this->data['2'];
        if (empty($id) or $id == 0) {
            $this->error = true;
            $this->errorInfos = array('warning', constant('INVALID_ID'), 'Galerie', false);
        } else {
            $data['data'] = $this->models->GetNameSubCatId($id);
            if ($data['data'] != false) {
                foreach ($data['data'] as $key => $value) {
                    if (Secures::IsAcess($value->groups_access) == false ) {
                        unset($data['data'][$key]);
                    }
                }
                $this->set($data);
            } 
            $this->render('subcat');
        }
    }
    #####################################
    # Affiche-les données d'une image
    #####################################
    public function detail ()
    {
        $id = (int) $this->data['2'];
        $data['data'] = $this->models->getDetail($id);
        $this->set($data);
        $this->render('detail');
    }
    #####################################
    # Ajouter un vote +1 à l'image
    #####################################
    public function addvote ()
    {
        $id = (int) $this->data['2'];
        $return = $this->models->votePlusOne($id);
        $this->redirect('Gallery/detail/'.$id, 3);
        $this->error = true;
        $this->errorInfos = array($return["type"], $return["text"], 'Galerie', false);
    }
    #####################################
    # Affiche les nouvelles image
    #####################################
    public function new ()
    {
        $data['data'] = $this->models->getnew();
        $this->set($data);
        $this->render('new');
    }
    #####################################
    # Affiche les plus populaires
    #####################################
    public function popular ()
    {
        $data['data'] = $this->models->popular();
        $this->set($data);
        $this->render('popular');
    }
    #####################################
    # Proposé une image
    #####################################
    public function  propose ()
    {
        $return['captcha'] = Captcha::createCaptcha();
        $this->set($return);
        $this->render('propose');
    }
    #####################################
    # Envoie la proposition à la BDD
    #####################################
    public function SendPropose ()
    {
		if (Captcha::verifCaptcha($_POST['query_register']) == false) {
			$this->error = true;
			$this->errorInfos = array('error', constant('CODE_CAPTCHA_ERROR'), constant('REGISTRATION'), false);
            $this->redirect('gallery', 3);
			return false;
		}

        $post['name']        = Common::VarSecure($_POST['name']);
        $post['description'] = Common::VarSecure($_POST['text']);
        if (User::isLogged() == true) {
            $post['author'] = $_SESSION['USER']->user->hash_key;
        } else {
            $post['author'] = Common::GetIp();
        }
        
        if (isset($_FILES['file'])):
            $image = Common::Upload('file', 'uploads/gallery/tmp/', array('.png', '.gif', '.jpg', '.jpeg', '.ico', '.tif', '.eps', '.svg'));
            if ($image == constant('UPLOAD_FILE_SUCCESS')):
                $post['image'] = '/uploads/gallery/tmp/'.$_FILES['file']['name'];
            endif;
        endif;

        $return = $this->models->SendPropose($post);

        $this->error = true;
        $this->errorInfos = array($return['type'], $return['msg'], constant('REGISTRATION'), false);
        $this->redirect('gallery', 4);
    }
}