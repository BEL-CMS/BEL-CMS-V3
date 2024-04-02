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
use Belcms\Pages\Pages;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Survey extends Pages
{
	var $useModels = 'Survey';

	public function index ()
	{
		$d['data'] = $this->models->getAllSurvey();
		$this->set($d);
		$this->render('index');
	}

	public function sendvote ()
	{
		$return = $this->models->vote($_POST);
		return json_encode($return);
	}

	public function newsurvey ()
	{
		$return = $this->models->newSurvey($_POST);
		return json_encode($return);
	}
}