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

namespace BELCMS\Pages\Controller;

use BelCMS\Core\Interaction;
use BelCMS\Core\Notification;
use Belcms\Pages\Pages;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Mails extends Pages
{
	var $useModels = 'Mails';

	function __construct()
	{
		parent::__construct();

		$dir = constant('DIR_UPLOADS_MAILS');
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$fopen  = fopen($dir.'/index.html', 'a+');
		fclose($fopen);
	}

	public function index ()
	{
		$this->render('index');
	}
}