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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

#########################################
# TABLE_USERS_NOTIFICATION
# author, date_notif, message, ip
#########################################
final class UserNotification
{
    public function __construct($author, $message)
    {
        $insert['author']  = Common::VarSecure($author, null);
        $insert['message'] = Common::VarSecure($message, null);
        $insert['ip']      = Common::GetIp();
        $sql = new BDD;
        $sql->table('TABLE_USERS_NOTIFICATION');
        $sql->insert($insert);
    }
}