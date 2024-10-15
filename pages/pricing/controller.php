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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;
use BelCMS\Core\Notification;
use BelCMS\Core\Secure;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Pricing extends Pages
{
	var $useModels = 'Pricing';

    public function index ()
    {
        $d['plan'] = $this->models->getPlan();

        foreach ($d['plan'] as $key => $value) {
            $d['plan'][$key]->listing = $this->models->getListing ($value->listing);
        }

        $this->set($d);
        $this->render('index');
    }

    public function choise ()
    {
        if (User::isLogged()) {
            $id = Secure::isInt($_POST['id']);

            $d['data'] = $this->models->getPlan ($id);
            $d['data']->listing = $this->models->getListing ($d['data']->listing);

            $this->set($d);
            $this->render('choise');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
    }

    public function sale ()
    {
        $id = (int) $this->data['id'];
        if (User::isLogged()) {
            $data['data'] = $this->models->getPlan ($id);
            $data['user'] = User::getInfosUserAll($_SESSION['USER']->user->hash_key);
            $data['BC'] = $this->models->bank();
            $this->set($data);
            $this->render('send');
		} else {
			$this->redirect('User/login&echo', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		}
    }

    public function Preorder ()
    {
        $id = (int) $this->data['id'];
        $price = (int) $this->data['price'];
        $return = $this->models->preorder($id, $price);
        $this->error = true;
        $this->errorInfos = array($return["type"], $return["text"], 'PréCommande', false);
        $this->redirect('index.php', 3);
    }
}