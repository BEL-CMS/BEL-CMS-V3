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

namespace BelCMS\Widgets;
use BelCMS\PDO\BDD as BDD;

class Widgets
{
    public      $render;

    protected   $name,
                $pos,
                $models;

    public function __construct($name, $pos = null)
    {
        $this->name = $name;
        $this->pos  = $pos;
    }

    public function render ()
    {
        ob_start();

        $this->models = self::getModels ();
        $var = self::getController();

        $render = constant('DIR_WIDGETS').strtolower($this->name).DS.'index.php';
        require $render;

        $content = ob_get_contents ();

        if (ob_get_length() != 0) {
            ob_end_clean();
        }

        return $content;
    }

    private function getController ()
    {
        if ($this->name != null) {
            $controller = ucfirst($this->name);
            $file = constant('DIR_WIDGETS').strtolower($this->name).DS.'controller.php';
            if (is_file($file)) {
                require $file;
                $nameController = 'Belcms\Widgets\Controller\\'.$controller;
                $var = new $nameController();
                return $var->render();
            }
        }
    }

    private function getModels ()
    {
        if ($this->name != null) {
            $file = constant('DIR_WIDGETS').strtolower($this->name).DS.'models.php';
            if (is_file($file)) {
                require $file;
            }
        }
    }

}
