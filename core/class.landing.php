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

namespace BelCMS\Core;
use Belcms\Templates\Models\Landing as models;
use BelCMS\Core\Debug as debug;
use BelCMS\PDO\BDD;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

################################################
# Class Landing (Home)
################################################
final class Landing
{
    public  $dir,
            $user,
            $page,
            $host;

    function __construct()
    {
        if (self::getActiveLanding() === true) {
            $this->dir = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'landing'.DS;
            self::getConfig();
            self::render();
            die();
        }
    }

    private function getConfig ()
    {
        $dir = $this->dir.'models.php';
        if (is_file($dir)) {
            require_once $dir;
            $models = new models;
            $this->host = $models->getHost();
            if ( User::isLogged() ) {
                $this->user = $models->getUser($_SESSION['USER']->user->hash_key);
            }
            $this->page = 'Opening';
        }
    }

    public function getActiveLanding () : bool
    {
        $return = false;
        if ($_SESSION['CONFIG_CMS']['LANDING'] == 1 and !isset($_GET['params'])) {
            $dir = $this->dir.'models.php';
            if (is_file($dir)) {
                require_once $dir;
            }
            $return = true;
        }
        return $return;
    }

    public function render ()
    {
        if (self::getActiveLanding() === true) {
            ob_start();
            require_once $this->dir.'index.php';
            $content = ob_get_contents();
            if (ob_get_length() != 0) {
                ob_end_clean();
            }
            echo $content;
        }
    }
}