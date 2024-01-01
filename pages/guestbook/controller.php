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
use BelCMS\Core\Config;
use Belcms\Pages\Pages;
use BelCMS\Core\Notification;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class GuestBook extends Pages
{
	var $useModels = 'GuestBook';

	public function index ()
	{
        if (isset($_SESSION['TMP_QUERY_GUESTBOOK'])) {
            unset($_SESSION['TMP_QUERY_GUESTBOOK']);
        }
        $numberOneRand = rand(1, 9);
        $numberTwoRand = rand(1, 9);
		$OVERALL = $numberOneRand + $numberTwoRand;
        $_SESSION['TMP_QUERY_GUESTBOOK'] = array();
		$_SESSION['TMP_QUERY_GUESTBOOK']['NUMBER_1'] = $numberOneRand;
		$_SESSION['TMP_QUERY_GUESTBOOK']['NUMBER_2'] = $numberTwoRand;
        $_SESSION['TMP_QUERY_GUESTBOOK']['OVERALL'] = $numberOneRand + $numberTwoRand;
		$config = Config::GetConfigPage('guestbook');
		$set['pagination'] = $this->pagination($config->config['MAX_USER'], 'guestbook', constant('TABLE_GUESTBOOK'));
        $data['user'] = $this->models->getUser();
        $this->set($set);
        $this->set($data);
        $this->render('index');
    }

    public function new ()
    {
        $this->render('new');
    }

    public function sendNew ()
    {
        $return = $this->models->sendNew ($_POST);
		$this->error = true;
		$this->errorInfos = array($return['type'], $return['msg'], constant('INFO'), false);
		$this->redirect('GuestBook', 3);
    }
}