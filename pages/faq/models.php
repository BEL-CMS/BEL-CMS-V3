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

namespace Belcms\Pages\Models;
use BelCMS\Core\Secure;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
#####################################
# Infos tables
#####################################
# TABLE_FAQ
# TABLE_FAQ_CAT
#####################################
final class FAQ
{
    function getCat ()
    {
        $sql = new BDD();
        $sql->table('TABLE_FAQ_CAT');
        $sql->queryAll();
        $return = $sql->data;
        foreach ($return as $key => $value) {
            $getFaq = self::getFaq($value->id);
            if ($getFaq !== false) {
                $return[$key]->faq[] = $getFaq;
            } else {
                $return[$key]->faq = false;
            }
        }
        return $return;
    }

    private function getFaq ($id = null)
    {
        $id = (int) $id;
        $sql = new BDD;
        $sql->table('TABLE_FAQ');
        $sql->where(array('name' => 'id_cat', 'value' => $id));
        $sql->queryOne();
        if (!empty($sql->data)) {
            return $sql->data;
        } else {
            return false;
        }
    }

    public function search ($data = null)
    {
        if ($data !== null)
        {
            $data = Common::VarSecure($data, null);
            $sql = new BDD;
            $sql->table('TABLE_FAQ');
            $where = 'WHERE `content` LIKE "%'.$data.'%"';
            $sql->where($where);
            $sql->queryAll();
            $return = $sql->data;
            return $return;
        }
    }
}