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
        $set['captcha'] = Captcha::createCaptcha();
        $this->set($set);
        $this->render('index');
    }

    public function send ()
    {
        if (empty($_POST['name'])) {  
            Notification::warning('Aucun nom donné');
        }
        if (empty($_POST['mail'])) {  
            Notification::warning('Aucun e-mail transmit');
        }
        if (empty($_POST['subject'])) {  
            Notification::warning('Aucun sujet transmit');
        }
        if (empty($_POST['message'])) {
            Notification::warning('Aucun message transmit');
        }

        if (Captcha::verifCaptcha($_POST['query_contact']) === false) {
            $this->error = true;
            $this->errorInfos = array('error', constant('CODE_CAPTCHA_ERROR'), constant('ERROR_CAPTCHA'), false);
            return false;   
        } else {
            $return = $this->models->send($_POST);
            debug($return);  
        }
    }
}