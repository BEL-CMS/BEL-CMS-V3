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
	var 		$vars = array();

	public      $render,
				$models;

	protected   $name,
				$title,
				$pos;

	public function __construct($var, $pos = null)
	{
		$this->name  = $var->name;
		$this->title = $var->title;
		$this->pos   = $var->pos;
		$this->render = self::render ();
	}

	#########################################
	# Assemble les variable passé par,
	# le controller en $this-set(array());
	#########################################
	public function set ($d)
	{
		$this->vars = array_merge($this->vars,$d);
	}

	public function render ()
	{
		ob_start();

		self::getModels ();
		$get = self::getController();
		$var = $get->render();
		extract($var);
		$render = constant('DIR_WIDGETS').strtolower($this->name).DS.'index.php';

		include $render;

		$content = ob_get_contents ();

		if (ob_get_length() != 0) {
			ob_end_clean();
		}

		return $content;
	}

	public function getBoxGlobal ()
	{
		ob_start();
		echo self::getTopBox();
		echo self::getBoxContent();
		echo self::getBottomBox();
		$content = ob_get_contents ();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}

	private function getTopBox ()
	{
		ob_start();
		$custom = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'widgets'.DS.'title.php';
		if (is_file($custom)) {
			include $custom;
		} else {
			$class = 'belcms_widgets_title_'.$this->pos;
			$box   = '<div class="'.$class.'>';
			$box  .= '<h4>'.$this->title.'</h4>';
			echo $box;
		}
		$content = ob_get_contents ();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}

	private function getBottomBox ()
	{
		ob_start();
		$custom = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'widgets'.DS.'bottom.php';
		if (is_file($custom)) {
			include $custom;
		} else {
			echo '</div>';
		}
		$content = ob_get_contents ();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $content;
	}

	private function getBoxContent ($render = null)
	{
		ob_start();
		$custom = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'widgets'.DS.'content.php';
		if (is_file($custom)) {
			include $custom;
		} else {
			$id = 'belcms_widgets_content_'.$this->pos;
			$boxContent = '<div id="'.$id.'';
			$boxContent .= $render;
			$boxContent .= '</div>';
			include $custom;
		}
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
				return $var;
			}
		}
	}

	private function getModels ()
	{
		if ($this->name != null) {
			$file = constant('DIR_WIDGETS').strtolower($this->name).DS.'models.php';
			try {
				if (is_file($file)) {
					require $file;
				}
			} catch (\Throwable $e) {
				var_dump($e);
			}
		}
	}

}
