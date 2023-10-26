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

namespace BelCMS\Templates;
use BelCMS\Core\Dispatcher as Dispatcher;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;

class Templates
{
	public	$configTPL;

	public function __construct($var = null)
	{
		$this->configTPL    = $var;
		$fileLoadTpl        = constant('DIR_TPL').self::getNameTpl().DS.'template.php';
		$fileLoadTplDefault = constant('DIR_TPL').'default'.DS.'template.php';
		$var->css           = self::cascadingStyleSheets($var->link);
		$var->javaScript    = self::javaScript($var->link);
		$var->tags          = self::getTagsTPL();
		$var->fullwide      = self::getFullWide();
		if (is_file($fileLoadTpl)) {
			require $fileLoadTpl;
		} else {
			require $fileLoadTplDefault;
		}
	}
	#########################################
	# Récupère le nom du template si pas
	# default sera utilisé
	#########################################
	protected function getNameTpl () : string
	{
		$return = 'default';
		$sql = new BDD;
		$sql->table('TABLE_CONFIG');
		$sql->where(array(
			'name'  => 'name',
			'value' => 'CMS_TPL_WEBSITE'
		));
		$sql->fields(array('value'));
		$sql->queryOne();
		if (!empty($sql->data->value)) {
			$return = $sql->data->value;
		}
		return $return;
	}
	#########################################
	# Récupère les page en fullwide
	#########################################
	protected function getFullWide ()
	{
		$page = explode(',', $_SESSION['CONFIG_CMS']['CMS_TPL_FULL']);
		foreach ($page as $k => $v) {
			$return[$k] = trim($v);
		}

		if (in_array(strtolower(Dispatcher::page()), $return)) {
			return true;
		}
		if (in_array(strtolower(Dispatcher::view()), $return)) {
			return true;
		}
	}
	#########################################
	# Récupère le nom du template si pas
	# default sera utilisé
	#########################################
	protected function getTagsTPL ()
	{
		$return = array();
		$sql = new BDD;
		$sql->table('TABLE_CONFIG_TPL');
		$sql->where(array(
			'name'  => 'name',
			'value' => 'tags'
		));
		$sql->fields(array('value'));
		$sql->queryOne();
		if (!empty($sql->data->value)) {
			$data = $sql->data->value;
			$return = Common::transformOpt($data, false);
		}
		return $return;
	}
	private function getCssWidgets ()
	{
		$return = array();
		$a      = array();
		$b      = array();

		$sql = new BDD;
		$sql->table('TABLE_WIDGETS');
		$sql->where(array(
			'name'  => 'active',
			'value' => 1
		));
		$sql->orderby(array('name' => 'orderby', 'value' => 'ASC'));
		$sql->queryAll();
		if (!empty($sql->data)) {
			foreach ($sql->data as $k => $v) {
				if (empty($v->page)) {
					$b[$k] = $v;
				} else {
					$a = explode('|', $v->pages);
					if (empty($v->page)) {
						if (!in_array($this->configTPL->link, $a)) {
							$b[$k] = $v;
						}	
					}
				}
			}
			foreach ($b as $k => $v) {
				if ($v->groups_access == 0 or in_array(1, $_SESSION['USER']->groups->all_groups)) {
					$return[$k] = $v;
				} else {
					$a = explode('|', $v->groups_access);
					if (in_array($_SESSION['USER']->groups->all_groups, $a)) {
						$return[$k] = $v;
					}
				}
			}
		}
		return $return;
	}
	#########################################
	# Gestions des styles (css)
	#########################################
	public function cascadingStyleSheets ($var)
	{
		$files          = array();
		$return         = '';
		/* GLOBAL STYLE */
		$files[] = 'assets/css/belcms.global.css';
		// NOTIFICATION */
		$files[] = 'assets/css/belcms.notification.css';
		/* FONTAWASOME 6.4.2 ALL */
		$files[] = 'assets/plugins/fontawesome-6.4.2/css/all.min.css';
		/* custom css template */
		if (is_file(constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom/custom.css')) {
			$files[] = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom/custom.css?';
		}
		/* pages css */
		$dirPage = constant('DIR_PAGES').strtolower($var).DS.'css'.DS.'styles.css';
		$dirWeb  = 'pages/'.strtolower($var).'/css/styles.css';
		if (is_file($dirPage)) {
			$files[] = $dirWeb;
		}
		/* widgets css */
		foreach (self::getCssWidgets() as $v) {
			/* widgets css default */
			$dirPage = constant('DIR_WIDGETS').strtolower($v->name).DS.'css'.DS.'styles.css';
			if (is_file($dirPage)) {
				$files[] = 'widgets/'.strtolower($v->name).'/css/styles.css';
			}
			/* widgets css default */
			$dirWidgets = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom/'.strtolower($v->name).'.css';
			if (is_file($dirWidgets)) {
				$files[] = 'templates/'.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom/'.strtolower($v->name).'.css';
			}
		}

		foreach ($files as $v) {
			$return .= '	<link href="'.$v.'" rel="stylesheet" type="text/css" media="all">'.PHP_EOL;
		}

		return trim($return);

	}
	#########################################
	# Gestions des scripts (js)
	#########################################
	public function javaScript ($var)
	{
		$files          = array();
		$return         = '';
		/* jQuery 3.7.1 */
		$files[] = 'assets/js/jQuery/jquery-3.7.1.min.js';
		/* Tinymce */
		$files[] = 'assets/js/tinymce/tinymce.min.js';
		/* FONTAWASOME 6.4.2 ALL */
		$files[] = 'assets/plugins/fontawesome-6.4.2/js/all.min.js';
		/* custom css template */
		if (is_file(constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.'custom.js')) {
			$files[] = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom'.DS.'custom.js';
		}
		/* FILE GENERAL BEL-CMS */
		$files[] = 'assets/plugins/belcms.core.js';
		/* pages js */
		$dirPage = constant('DIR_PAGES').strtolower($var).DS.'js'.DS.'javascripts.js';
		if (is_file($dirPage)) {
			$files[] = 'pages/'.strtolower($var).'/js/javascripts.js';
		}
		/* Widgets js */
		foreach (self::getCssWidgets() as $v) {
			/* widgets js default */
			$dirPage = constant('DIR_WIDGETS').strtolower($v->name).DS.'js'.DS.'javascripts.js';
			if (is_file($dirPage)) {
				$files[] = 'widgets/'.strtolower($v->name).'/js/javascripts.js';
			}
			/* widgets css default */
			$dirWidgets = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom/'.strtolower($v->name).'.js';
			if (is_file($dirWidgets)) {
				$files[] = 'templates/'.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom/'.strtolower($v->name).'.js';
			}
		}

		if (is_file(ROOT.'pages'.DS.strtolower($var).DS.'js'.DS.'javascripts.js')) {
			$files[] = 'pages'.DS.strtolower($var).DS.'js'.DS.'javascripts.js';
		}

		foreach ($files as $v) {
			$return .= '	<script type="text/javascript" src="'.$v.'"></script>'.PHP_EOL;
		}

		return trim($return);
	}
}