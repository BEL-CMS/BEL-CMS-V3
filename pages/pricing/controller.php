<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Controller;

use BelCMS\Core\Interaction;
use Belcms\Pages\Pages;
use BelCMS\Core\Notification;
use BelCMS\Core\Secure;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use Belcms\Widgets\Controller\Users\Users;
use Random\Engine\Secure as EngineSecure;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Pricing extends Pages
{
	var $useModels = 'Pricing';

    public function index ()
    {
        $i = 0;
        $sql = $this->models->getPlan();

        foreach ($sql as $key => $value) {
            $i = $i + 1;
            $data['plan'][$i]['listing'] = $this->models->listing($value->listing);
            $data['plan'][$i]['header'] = $value;
        }
        $this->set($data);
        $this->render('index');
    }

    public function method()
    {
		if (!is_numeric($this->data[2])) {
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
        $id['id'] = (int) $this->data[2];
        $this->set($id);
        $this->render('method');
    }

    public function payment ()
    {
		if (!is_numeric($this->data[2])) {
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
        $id = (int) $this->data[2];
        $d['plan'] = $this->models->getPlanChoise($id);
        $this->set($d);
        $this->render('add');
    }

    public function paymentPaypal ()
    {
		if (!is_numeric($this->data[2])) {
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
        $id = (int) $this->data[2];
        $d['plan'] = $this->models->getPlanChoise($id);
        $this->set($d);
        $this->render('addPaypal');
    }

    public function valid_sepa ()
    {
		if (!is_numeric($_POST['plan_id'])) {
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
        $id = (int) $_POST['plan_id'];

        $d['author'] = User::ifUserExist($_SESSION['USER']->user->hash_key) ? $_SESSION['USER']->user->hash_key : false;
        $d['plan']   = $id;

        $d['id_order'] = Common::randomString(8);
        $_SESSION['PRICING']['ID_ORDER'] = $d['id_order'];
        $d['mail']     = Secure::isMail($_POST['mail']);
        $d['url']     = Secure::isUrl($_POST['url']);
        $this->models->addValidSales($d);

        $d['plan'] = $this->models->getPlanChoise($id);
        $this->set($d);
        $this->render('sepa');
    }

    public function valid_paypal ()
    {
		if (!is_numeric($_POST['plan_id'])) {
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
        $id = (int) $_POST['plan_id'];

        $d['author'] = User::ifUserExist($_SESSION['USER']->user->hash_key) ? $_SESSION['USER']->user->hash_key : false;
        $d['plan']   = $id;
        $this->models->getPayPal();

        $d['id_order'] = Common::randomString(8);
        $_SESSION['PRICING']['ID_ORDER'] = $d['id_order'];
        $d['mail']     = Secure::isMail($_POST['mail']);
        $d['url']     = Secure::isUrl($_POST['url']);
        $this->models->addValidSalesPaypal($d);

        $d['plan'] = $this->models->getPlanChoise($id);
        $this->set($d);
        $this->render('paypal');
    }

    public function Myorders ()
    {
        $a = $this->models->getOrder ();

        foreach ($a as $k => $v) {
            $a[$k]->plan = $this->models->listing($v->plan);
        }

        $d['data'] = $a;

        $this->set($d);
        $this->render('order');
    }

    public function invoice ()
    {
        $id = Common::VarSecure($this->data[2], null);
		if (User::isLogged() === false) {
			$this->redirect('User', 3);
			$this->error = true;
			$this->errorInfos = array('warning', constant('LOGIN_REQUIRE'), constant('INFO'), false);
		} else {
            $d['invoice'] = $this->models->getAll($id);
            $d['pricing'] = $this->models->getPlanChoise($d['invoice']->plan);
            $list    = $this->models->listing($d['pricing']->listing);
            foreach ($list as $key => $value) {
                if (!empty($value)) {
                    $d['list'][$key] = $value; 
                }
            }
            $this->set($d);
            $this->render('invoice');
        }
    }

	public function PayPalValidate ()
	{
		$this->models->verifPaypal($_POST);
	}
}