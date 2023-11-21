<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace Belcms\Pages\Models;
use ArrayObject;
use BelCMS\PDO\BDD;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_MAILS
# TABLE_MAILS_MSG
final class Mails
{
    public function getMessages ($archive = false)
    {
		$return = array();
		if (strlen($_SESSION['USER']->user->hash_key) != 32) {
			return false;
		} else {
            if ($archive === true) {
                $whereMail[] = array('name' => 'author_receives', 'value' => $_SESSION['USER']->user->hash_key);
                $whereMail[] = array('name'=> 'archive', 'value' => 1);
            } else {
                $whereMail = array('name' => 'author_receives', 'value' => $_SESSION['USER']->user->hash_key);
            }
            $sql   = New BDD();
            $sql->table('TABLE_MAILS');
            $sql->where($whereMail);
            $sql->isObject(true);
            $sql->queryAll();
            $mail = $sql->data;
            foreach ($mail as $key => $value) {
                $whereRead = array('name' => 'mail_id', 'value' => $value->mail_id);
                $read   = New BDD();
                $read->table('TABLE_MAILS_MSG');
                $read->orderby(array(array('name' => 'id', 'type' => 'DESC')));
                $read->where($whereRead);
                $read->isObject(true);
                $read->queryOne();
                $return[$key]['data'] = $value;
                $return[$key]['read'] = $read->data;

            }
        }
        return $return;
    }
}