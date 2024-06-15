<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.4 [PHP8.3]
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
# Class Validation
################################################
final class Validation
{
    public      $author,
                $valid;

    function __construct() {
        if (!isset($_GET['valid'])) {
            $this->author = User::isLogged() == true ? self::getSQLUser() : false;
            $this->valid  = $_SESSION['CONFIG_CMS']['VALIDATION'] == 'mail' ? true : false;
            self::getValid();
        }
    }

    private function getValid ()
    {
        if (!empty($this->author) && $this->valid === true) {
            if ($this->author->valid == 0) {
                self::html();
            }
        }
    }

    public function getSQLUser () 
    {
        $sql = new BDD;
        $sql->table('TABLE_USERS');
        $sql->where(array('name' => 'hash_key', 'value' => $_COOKIE['BELCMS_HASH_KEY_'.$_SESSION['CONFIG_CMS']['COOKIES']]));
        $sql->fields(array('hash_key', 'mail', 'ip', 'valid'));
        $sql->queryOne();
        return $sql->data;
    }

    public function html ()
    {
        require_once ROOT.DS.'users'.DS.'validation.php';
        die();
    }

    public function returnValidMail ($data = false)
    {
        if ($data !== false) {
            require_once ROOT.DS.'users'.DS.'validation.php';
            die(); 
        }
    }
}