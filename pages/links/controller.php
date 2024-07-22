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

namespace BELCMS\Pages\Controller;
use BelCMS\Core\Config;
use BelCMS\Core\Interaction;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Links extends Pages
{
	var $useModels = 'links';

    public function index ()
    {
		$config =  Config::GetConfigPage('links');
		$data['pagination'] = $this->pagination($config->config['MAX_LINKS'], 'link/View', constant('TABLE_LINKS'));
        $data['data']  = $this->models->getCat();
        $data['count'] = $this->models->getNbLinks();
        $this->set($data);
        $this->render('index');

    }

    public function one ()
    {
        $data['data']  = $this->models->getCat();
        $data['count'] = $this->models->getNbLinks();
        $this->set($data);
        $this->render('one');
    }

    public function new ()
    {
        $data['links'] = $this->models->getNbNewLinks();
        $this->set($data);
        $this->render('new');  
    }

    public function popular()
    {
        $data['links'] = $this->models->getNbPopular();
        $this->set($data);
        $this->render('popular');
    }

    public function propose() {
		$_SESSION['TMP_QUERY_REGISTER'] = array();
		$_SESSION['TMP_QUERY_REGISTER']['number_1'] = rand(1, 9);
		$_SESSION['TMP_QUERY_REGISTER']['number_2'] = rand(1, 9);
		$_SESSION['TMP_QUERY_REGISTER']['overall']  = $_SESSION['TMP_QUERY_REGISTER']['number_1'] + $_SESSION['TMP_QUERY_REGISTER']['number_2'];
		$_SESSION['TMP_QUERY_REGISTER'] = Common::arrayChangeCaseUpper($_SESSION['TMP_QUERY_REGISTER']);
        $this->render('form');
    }

    public function sendform() {
        $test = $_POST['captcha'] == '' ? true : false;
        if ($test === true and $_SESSION['TMP_QUERY_REGISTER']['OVERALL'] == $_POST['query']) {
            $return = $this->models->sendform($_POST);
			$this->redirect('Links', 3);
			$this->error = true;
            $this->errorInfos = array($return["type"], $return["text"], constant('LINK'), false);
        } else {
            $this->error = true;
            $this->errorInfos = array('error', constant('ERROR_CAPTCHA'), constant('INFO'), false);
            new Interaction(constant('ERROR'), constant('INFO'), constant('ERROR_CAPTCHA'));
        }
    }

    public function getLinksCat ()
    {
        $id = (int) $this->data['2'];
        if (!empty($id) and is_numeric($id)) {
            $data['data'] = $this->models->getLinksCat ($id);
            $this->set($data);
            $this->render('linkcat');
        } else {
            $this->error = true;
            $this->errorInfos = array('error', constant('ERROR_CAPTCHA'), constant('INFO'), false);
            new Interaction(constant('ERROR'), constant('INFO'), constant('ERROR_ID')); 
        }
    }

    public function view ()
    {
        $id = (int) $this->data[2];
        if (!is_int($id)) {
            $this->error = true;
            $this->errorInfos = array('error', constant('ERROR_CAPTCHA'), constant('INFO'), false);
            new Interaction(constant('ERROR'), constant('INFO'), constant('ERROR_ID')); 
        } else {
            $return = $this->models->getView($id);
            $this->models->visit($id);
            $post['data'] = $return;
            $this->set($post);
            $this->render('view');
        }
    }

    public function exit ()
    {
        $id = (int) $this->data[2];
        if (!is_int($id)) {
            $this->error = true;
            $this->errorInfos = array('error', constant('ERROR_CAPTCHA'), constant('INFO'), false);
            new Interaction(constant('ERROR'), constant('INFO'), constant('ERROR_ID')); 
        } else {
            $link = $this->models->getExit($id);
            $this->link($link, 5);
            $this->error = true;
            $this->errorInfos = array('error', constant('LINK_EXIT'), constant('INFO'), true);
        }
    }
}