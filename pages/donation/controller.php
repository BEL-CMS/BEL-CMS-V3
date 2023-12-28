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
use Belcms\Pages\Pages;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Donation extends Pages
{
	var $useModels = 'Donation';

	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['DONS']['UNIQUE_ID']) or empty($_SESSION['DONS']['UNIQUE_ID'])) {
			$_SESSION['DONS']['UNIQUE_ID'] = md5(uniqid(rand(), true));
		}
		$this->models->getPayPal();
	}
	public function index ()
	{
        $this->render('index');
    }

    public function send ()
    {
        $this->set($_POST);
        $_SESSION['DONATE'] = $_POST;
        if ($_POST['type'] == 'payment') {
            $data['BC'] = $this->models->bank();
            $this->set($data);
        }
        $this->render('payment');
    }

    public function validate ()
    {
        $this->models->receiptValidate($_POST);
    }

    public function pledge ()
    {
        $this->models->validPledge($_POST);
        $this->error = true;
        $this->errorInfos = array('success', constant('THX_DONATE'), constant('DONATIONS'), false);
        $this->redirect('News', 3);
    }

    public function payPalError ()
    {
        $this->error = true;
        $this->errorInfos = array('error', constant('PAYPAL_ERROR'), constant('DONATIONS'), false);
        $this->redirect('Donation', 3);
    }
}