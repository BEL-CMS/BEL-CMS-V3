<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.1 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;

use BelCMS\Core\Notification;
use Belcms\Pages\Pages;
use BelCMS\Core\Captcha;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Contact extends Pages
{
	var $useModels  = 'Contact';

	public function index ()
	{
        if (Captcha::getActiveCaptcha() == true) {
			$captcha['captcha'] = new Captcha();
			$captcha['captcha'] = $captcha['captcha']->createCaptcha();
			$this->set($captcha);
            $this->render('index');
        } else {
            $set['captcha'] = false;
            $this->set($set);
            $this->render('index');
        }
    }

    public function send ()
    {
        if (empty($_POST['name'])) {  
            Notification::warning('Aucun nom donné');
            $this->errorInfos = array('error', 'Aucun nom donné', constant('ERROR_DATA'), false);
            die();
        }
        if (empty($_POST['mail'])) { 
            $this->error = true; 
            $this->errorInfos = array('error', 'Aucun e-mail transmit', constant('ERROR_DATA'), false);
        }
        if (empty($_POST['subject'])) {  
            $this->error = true;
            $this->errorInfos = array('error', 'Aucun sujet transmit', constant('ERROR_DATA'), false);
        }
        if (empty($_POST['message'])) {
            $this->error = true;
            $this->errorInfos = array('error', 'Aucun message transmit', constant('ERROR_DATA'), false);
        }
        if (Captcha::getActiveCaptcha() === true) {
            if (Captcha::verifCaptcha($_POST['query_captcha']) === false) {
                $this->error = true;
                $this->errorInfos = array('error', constant('CODE_CAPTCHA_ERROR'), constant('ERROR_DATA'), false);
            } else {
                Notification::warning(constant('CODE_CAPTCHA_ERROR'));
                $this->redirect('Contact', 3);
            }
        } else {
            $return = $this->models->send($_POST);
            $this->error = true;
            $this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
            //$this->redirect('Contact', 3);
        }
    }
}