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

namespace Belcms\Widgets\Models\Pricing;
use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class pricing
{
    public function getPlan () {
        $sql = new BDD;
        $sql->table('TABLE_PRICING');
        $sql->orderby(array(array('name' => 'sort_asc', 'type' => 'ASC')));
        $sql->queryAll();
        return $sql->data;
    }

    public function listing ($data)
    {
        $sql = new BDD;
        $sql->table('TABLE_PRICING_LIST');
        $sql->where(array('name' => 'id', 'value' => $data));
        $sql->fields(array('cat_1','cat_2','cat_3','cat_4','cat_5','cat_6','cat_7','cat_8','cat_9','cat_10'));
        $sql->queryOne();
        return $sql->data;
    }
}
