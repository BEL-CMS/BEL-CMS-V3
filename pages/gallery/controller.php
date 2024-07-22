<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Core\Config;

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

        $data['count'] = $this->models->countImg ();
        $data['cat'] = $this->models->geAlltCat ();

        $this->set($data);
        $this->render('index');
    }
    #####################################
    # Affiche les donné d'une image
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

    public function popular ()
    {
        $data['data'] = $this->models->popular();
        $this->set($data);
        $this->render('popular');
    }
}