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

namespace Belcms\Pages\Controller;

use BelCMS\Core\Secure;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Tickets extends Pages
{
	var $useModels = 'Tickets';

	public function index ()
	{
		if (User::isLogged()) {
			$set['cat'] = $this->models->getCat();
			$this->set($set);
			$this->render('index');
		} else {
			$this->redirect('User/Login?echo', 0);
		}
	}

	public function send ()
	{
		if (User::isLogged()) {
			$array['subject']      = Common::VarSecure($_POST['subject'], null);
			$array['mail']         = Secure::isMail($_POST['mail']) ? $_POST['mail'] : false;
			$array['text_sbiject'] = Common::VarSecure($_POST['message'], 'html');
			$array['cat']          = is_numeric($_POST['cat']) ? $_POST['cat'] : 0;

			if ($array['mail'] === false) {
				$this->redirect('Tickets', 3);
				$this->error = true;
				$this->errorInfos = array('warning', constant('ERROR_MAIL'), constant('INFO'), false);
			}
			$return = $this->models->insert($array);
			$this->error = true;
			$this->errorInfos = array($return['type'], $return['text'], constant('TICKET'), false);
			$this->redirect('Tickets', 3);
		} else {
			$this->redirect('User/Login?echo', 0);
		}
	}
}