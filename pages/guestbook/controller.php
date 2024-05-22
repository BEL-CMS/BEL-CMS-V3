<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;
use BelCMS\Core\Captcha;
use BelCMS\Core\Config;
use Belcms\Pages\Pages;
use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class GuestBook extends Pages
{
	var $useModels = 'GuestBook';

	public function index ()
	{
        if (Captcha::getActiveCaptcha() === true) {
            if (Captcha::getTimeCaptcha() and is_array(Captcha::getTimeCaptcha())) {
                $this->error = true;
                $this->errorInfos = array('warning', constant('CODE_CAPTCHA_TIME'), constant('INFO'), false); 
            } else {
                $config = Config::GetConfigPage('guestbook');
                $set['pagination'] = $this->pagination($config->config['MAX_USER'], 'guestbook', constant('TABLE_GUESTBOOK'));
                $data['user'] = $this->models->getUser();
                $this->set($set);
                $this->set($data);
                $this->render('index');
            }
        } else {
            $set['captcha'] = false;
            $config = Config::GetConfigPage('guestbook');
            $set['pagination'] = $this->pagination($config->config['MAX_USER'], 'guestbook', constant('TABLE_GUESTBOOK'));
            $data['user'] = $this->models->getUser();
            $this->set($set);
            $this->set($data);
            $this->render('index');
        }
    }

    public function new ()
    {
        if (Captcha::getActiveCaptcha() === true) {
            if (Captcha::getTimeCaptcha() and is_array(Captcha::getTimeCaptcha())) {
                $this->error = true;
                $this->errorInfos = array('warning', constant('CODE_CAPTCHA_TIME'), constant('INFO'), false);  
            } else {
                $set['captcha'] = Captcha::createCaptcha();
                $this->set($set);
                $this->render('new');  
            }
        } else {
            $set['captcha'] = false;
            $this->set($set);
            $this->render('new');
        }
    }

    public function sendNew ()
    {
        if (Captcha::getActiveCaptcha() === true) {
            if (Captcha::verifCaptcha($_POST['query_captcha']) === false) {
                $this->error = true;
                $this->errorInfos = array('error', constant('CODE_CAPTCHA_ERROR'), constant('ERROR_CAPTCHA'), false);
                return false;
            } else {
                $return = $this->models->sendNew ($_POST);
                $this->error = true;
                $this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
                $this->redirect('GuestBook', 3);  
            }
        } else {
            Notification::warning(constant('CODE_CAPTCHA_ERROR'));
            $this->redirect('GuestBook', 3);
        }
    }
}