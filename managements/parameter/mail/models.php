<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.3 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_MAIL_CONFIG

final class ModelsMails
{
    public function getConfig()
    {
        $return = array();

        $sql = new BDD();
        $sql->table('TABLE_MAIL_CONFIG');
        $sql->queryAll();

        foreach ($sql->data as $key => $value) {
            $return[$value->name] = $value->config;
        }

        $return = (object) $return;

        return $return;
    }

    public function saveConfig ($data)
    {
        $data['host']        = Secure::isMail($data['host'])        ? $data['host']        : 'localhost';
        $data['port']        = is_numeric($data['port'])            ? $data['port']        : '587';
        $data['SMTPAuth']    = $data['SMTPAuth'] == 'true'          ? 'true'               : 'false';
        $data['SMTPAutoTLS'] = is_numeric($data['SMTPAutoTLS'])     ? $data['SMTPAutoTLS'] : 'true';
        $data['IsHTML']      = $data['IsHTML'] ==  'true'           ? 'true'               : 'false';
        $data['charset']     = Secure::isString($data['charset'])   ? $data['charset']     : 'UTF-8';
        $data['setFrom']     = Secure::isMail($data['setFrom'])     ? $data['setFrom']     : $_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'];
        $data['fromName']    = Secure::isString($data['fromName'])  ? $data['fromName']    : 'Unknow';
        $data['username']    = Secure::isMail($data['username'])    ? $data['username']    : '';
        $data['Password']    = Secure::isString($data['Password'])  ? $data['Password']    : '';

        foreach ($data as $key => $v) {
            $sql = new BDD;
            $sql->table('TABLE_MAIL_CONFIG');
			$sql->where(array('name'=>'name','value'=> $key));
			$sql->update(array('config' => $v));
            unset($sql);
        }
    }
}