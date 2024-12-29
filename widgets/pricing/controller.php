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

namespace Belcms\Widgets\Controller\pricing;
use BelCMS\Widgets\Widgets;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Pricing extends Widgets
{
	var $useModels = 'pricing';

	public function index ($var)
	{
        $i = 0;
        $sql = $this->models->getPlan();

        foreach ($sql as $key => $value) {
            $i = $i + 1;
            $data['plan'][$i]['listing'] = $this->models->listing($value->listing);
            $data['plan'][$i]['header'] = $value;
        }
		$this->name  = $var->name;
		$this->title = $var->title;
		$this->pos   = $var->pos;
        $this->set($data);
		$this->render();
	}
}
