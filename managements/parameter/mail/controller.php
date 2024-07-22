<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.4 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Mail extends AdminPages
{

	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true;
	var $bdd    = 'ModelsMails';

    public function index ()
    {
        $data['data'] = $this->models->getConfig();
        $this->set($data);
        $this->render('index');
    }

    public function send ()
    {
        $return = $this->models->saveConfig($_POST);
		$this->error('Parametres', $return['text'], $return['type']);
        $this->redirect('Mail?management&option=parameter', 2);
    }
}