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

namespace BelCMS\Templates;
use BelCMS\Core\Dispatcher;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

class Templates
{
	public	$configTPL;

	public function __construct($var = null)
	{
		$this->configTPL    = $var;
		$var->link          = ucfirst($var->link ?? '');
		$fileLoadTpl        = constant('DIR_TPL').self::getNameTpl().DS.'template.php';
		$fileLoadTplDefault = constant('DIR_TPL').'default'.DS.'template.php';
		$var->css           = self::cascadingStyleSheets($var->link);
		$var->javaScript    = self::javaScript($var->link);
		$var->tags          = self::getTagsTPL();
		$var->fullwide      = self::getFullWide();
		if (is_file($fileLoadTpl) === true) {
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

		$page = strtolower(Dispatcher::page() ?? '');
		$view = strtolower(Dispatcher::view() ?? '');

		if (in_array($page, $return)) {
			return true;
		}
		if (in_array($view, $return)) {
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
				if (isset($_SESSION['USER'])) {
					if ($v->groups_access == 0 or in_array(1, $_SESSION['USER']->groups->all_groups)) {
						$return[$k] = $v;
					} else {
						$a = explode('|', $v->groups_access);
						if (in_array($_SESSION['USER']->groups->all_groups, $a)) {
							$return[$k] = $v;
						}
					}
				} else {
					if ($v->groups_access == 0) {
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
		$link = strtolower($var);
		$dir = 'templates'.DS.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.'styles.css';
		$files          = array();
		$return         = '';
		/* GLOBAL STYLE */
		$files[] = 'assets/css/belcms.global.css';
		/* jQuery ui 1.13.2 */
		$files[] = 'assets/plugins/jquery-ui-1.13.2/themes/base/jquery-ui.min.css';
		$files[] = 'assets/plugins/jquery-ui-1.13.2/themes/base/theme.css';
		// NOTIFICATION */
		$files[] = 'assets/css/belcms.notification.css';
		/* FONTAWASOME 6.5.1 ALL */
		$files[] = 'assets/plugins/fontawesome-6.5.1/css/all.min.css';
		/* HightLight */
		$files[] = 'assets/plugins/highlight/styles/github-dark-dimmed.min.css';
		/* glightbox */
		$files[] = 'assets/plugins/glightbox/css/glightbox.min.css';
		$files[] = 'assets/plugins/glightbox/css/plyr.min.css';
		/* Calendrier */
		$sql = new BDD;
		$sql->table('TABLE_WIDGETS');
		$sql->where(array(
			'name'  => 'name',
			'value' => 'calendar',
		));
		$sql->queryOne();
		if ($link == 'calendar' or !empty($sql->data)) {
			$files[] = 'assets/plugins/quick-events/quick-events.css';
		}
		/* custom css template */
		if (is_file(constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom/custom.css')) {
			$files[] = 'templates/'.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom/custom.css?';
		}
		/* pages css */
		$dirPage = constant('DIR_PAGES').strtolower($var).DS.'css'.DS.'styles.css';
		if (is_file($dirPage)) {
			$files[] = 'pages/'.strtolower($var).'/css/styles.css';
		}
		/* widgets css */
		foreach (self::getCssWidgets() as $v) {
			/* widgets css default */
			$dirWidgets = constant('DIR_WIDGETS').strtolower($v->name).DS.'css'.DS.'styles.css';
			if (is_file($dirWidgets)) {
				$files[] = 'widgets/'.strtolower($v->name).'/css/styles.css';
			}
		}

		$files[] = $dir;

		foreach ($files as $v) {
			$return .= '	<link href="'.$v.'" rel="stylesheet" type="text/css" media="all">'.PHP_EOL;
		}

		return $return;

	}
	#########################################
	# Gestions des scripts (js)
	#########################################
	public function javaScript ($var)
	{
		$link           = strtolower($var);
		$files          = array();
		$return         = '';
		/* jQuery 3.7.1 */
		$files[] = 'assets/js/jQuery/jquery-3.7.1.min.js';
		/* jQuery ui 1.13.2 */
		$files[] = 'assets/plugins/jquery-ui-1.13.2/jquery.js';
		$files[] = 'assets/plugins/jquery-ui-1.13.2/jquery-ui.min.js';
		/* Tinymce */
		$files[] = 'assets/plugins/tinymce/tinymce.min.js';
		/* FONTAWASOME 6.5.1 ALL */
		$files[] = 'assets/plugins/fontawesome-6.5.1/js/all.min.js';
		/* HightLight */
		$files[] = 'assets/plugins/highlight/highlight.min.js';
		$files[] = 'assets/plugins/highlight/languages/apache.min.js';
		$files[] = 'assets/plugins/highlight/languages/css.min.js';
		$files[] = 'assets/plugins/highlight/languages/javascript.min.js';
		$files[] = 'assets/plugins/highlight/languages/php.min.js';
		$files[] = 'assets/plugins/highlight/languages/sql.min.js';
		$files[] = 'assets/plugins/highlight/go.min.js';
		$files[] = 'assets/plugins/highlight/set.js';
		/* Tooltip */
		$files[] = 'assets/plugins/tooltip/popper.min.js';
		$files[] = 'assets/plugins/tooltip/tippy-bundle.umd.min.js';
		$files[] = 'assets/plugins/tooltip/tooltip.js';
		/* glightbox */
		$files[] = 'assets/plugins/glightbox/js/glightbox.min.js';

		$sql = new BDD;
		$sql->table('TABLE_WIDGETS');
		$sql->where(array(
			'name'  => 'name',
			'value' => 'calendar',
		));
		$sql->queryOne();
		if ($link == 'calendar' or !empty($sql->data)) {
			$files[] = 'assets/plugins/quick-events/languages/lang.js';
			$files[] = 'assets/plugins/quick-events/jquery.magnific-popup.js';
			$files[] = 'assets/plugins/quick-events/quick-events.js';
		}
		/* custom css template */
		if (is_file(constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.'custom.js')) {
			$files[] = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.'custom.js';
		}
		/* FILE GENERAL BEL-CMS */
		$files[] = 'assets/js/belcms.core.js';
		/* pages js */
		$dirPage = constant('DIR_TPL').strtolower($var).DS.'js'.DS.'javascripts.js';
		if (is_file($dirPage)) {
			$files[] = $dirPage;
		}
		/* Widgets js */
		foreach (self::getCssWidgets() as $v) {
			/* widgets js default */
			$dirWidgets = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'custom'.DS.strtolower($v->name).'.js';
			if (is_file($dirWidgets)) {
				$files[] = ROOT.DS.'templates/'.$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].'/custom/'.strtolower($v->name).'.js';
			}
		}

		if (is_file(ROOT.DS.'pages'.DS.strtolower($var).DS.'js'.DS.'javascripts.js')) {
			$files[] = 'pages/'.strtolower($var).'/js/javascripts.js';
		}

		foreach ($files as $v) {
			$return .= '	<script type="text/javascript" src="'.$v.'"></script>'.PHP_EOL;
		}

		return $return;
	}
}