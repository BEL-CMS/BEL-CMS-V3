<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
*/

namespace BelCMS\Widgets;
class Widgets
{
	var 		$vars = array(),
				$useModels;

	public      $view,
				$models,
				$content;

	protected   $name,
				$title,
				$pos;

	public function __construct()
	{
		if (isset($this->useModels) and !empty($this->useModels)){
			self::loadModel($this->useModels);
		}
	}
	public function render ()
	{
		self::loadLang($this->useModels);
		// Démarre la mémoire tampon
		ob_start();
		$this->content = self::getContent();
		$custom = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'widgets'.DS.$this->pos.'.php';
		$dir    = constant('DIR_WIDGETS').'tpl'.DS.$this->pos.'.php';

		// Si le fichier existe, on inclut le fichier custom depuis le template (/templates/NomDuTemplate/widgets/)
		if (is_file($custom)) {
			include $custom;
		// Si pas, on essaye d'inclure le fichier par défaut (il doit exister normalement !)
		} else if (is_file($dir)) {
			include $dir;
		// Vraiment, au cas où le fichier a été effacé, j'inclus une erreur
		}
		// Met en le tampon dans une variable ($this->page);
		$this->view = ob_get_contents();
		// Verifie si le tampon est rempli, 
		// Détruit les données du tampon de sortie
		// et éteint la temporisation de sortie.
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
	}
	#########################################
	# inclus le widgets pur HTML/PHP
	#########################################
	public function getContent ()
	{
		self::loadLang($this->name);
		extract($this->vars);
		ob_start();
		$custom = constant('DIR_TPL').$_SESSION['CONFIG_CMS']['CMS_TPL_WEBSITE'].DS.'widgets'.DS.$this->name.DS.'index.php';
		$dir    = constant('DIR_WIDGETS').$this->name.DS.'index.php';
		if (is_file($custom)) {
			include $custom;
		} else {
			include $dir;
		}
		$return = ob_get_contents();
		if (ob_get_length() != 0) {
			ob_end_clean();
		}
		return $return;
	}
	#########################################
	# inclus le models
	#########################################
	public function loadModel ($name)
	{
		$dir = constant('DIR_WIDGETS').strtolower($name).DS.'models.php';

		if (is_file($dir)) {
			require_once $dir;
			$name = "Belcms\Widgets\Models\\".ucfirst($name)."\\".ucfirst($name);
			$this->models = new $name();
		} else {
			$error_name   = constant('FILE_NO_FOUND_MODELS');
			$error_text   = constant('FILE').' : <br>'.$dir.' '.constant('NOT_FOUND');
			$this->error  = true;
			$this->errorInfos = array('error', $error_text, $error_name, $full = true);
			return false;
		}
	}
	#########################################
	# récupere le fichier de langue
	#########################################
	public function loadLang ($name)
	{
		if (empty($name)){
			$name = '';
		} else {
			$name = strtolower($name);
		}
		$fileLoadlang = constant('DIR_WIDGETS').$name.DS.'langs'.DS.'lang.fr.php';
		if (is_file($fileLoadlang)) {
			require $fileLoadlang;
		}
	}
	#########################################
	# Assemble les variable passé par,
	# le controller en $this->set(array());
	#########################################
	public function set ($d)
	{
		$this->vars = array_merge($this->vars,$d);
	}
}
