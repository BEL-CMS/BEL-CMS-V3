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

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

########################
# TABLE_NEWSLETTER
# TABLE_NEWSLETTER_SEND
# TABLE_NEWSLETTER_TPL
########################
final class ModelsNewsletter
{
	public function getAllUsers ()
    {
        $return = array();
        $sql = new BDD;
        $sql->table('TABLE_NEWSLETTER');
        $sql->queryAll();
        $return = $sql->data;

        return $return;
    }

    public function getAllTpl ()
    {
        $return = array();
        $sql = new BDD;
        $sql->table('TABLE_NEWSLETTER_TPL');
        $sql->queryAll();
        $return = $sql->data;
        return $return;
    }

    public function sendtpl ($data = false)
    {
        if (is_array($data)) {
            $insert['name']     = Common::VarSecure($data['name'], '');
            $insert['template'] = Common::VarSecure($data['content'], 'html');
            $sql = new BDD();
            $sql->table('TABLE_NEWSLETTER_TPL');
            $sql->insert($insert);
        }
    }
}