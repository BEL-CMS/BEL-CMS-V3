<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0  [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# 
################################################
final class Popup
{
    public static function render($data)
    {
        if (strlen($data) == 32) {
            $where = array('name' => 'hash_key', 'value' => $data);
        } else {
            $where = array('name' => 'username', 'value' => $data);
        }
        if (!empty($username)) {
            $sql = new BDD;
            $sql->table('TABLE_USERS');
            $sql->where($where);
            $sql->queryOne();
            $return = $sql->data;

            $user = User::getInfosUserAll($return->hash_key);
            if ($user != false) {
               echo self::html();
            }
        }
    }

    private function html ()
    {
        $return  = '';
        $return .= '<div id="belcms_popup">';
        $return .= '<div>';
        $return .= '<div id="belcms_left">';
        $return .= '<img src="http://determe.be/uploads/avatar.jpeg" alt="avatar">';
        $return .= '</div>';
        $return .= '<div id="belcms_right">';
        $return .= 'Pseudo';
        $return .= '</div>';
        $return .= '</div>';
        return $return;
    }
}

