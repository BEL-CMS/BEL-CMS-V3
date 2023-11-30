<?php
use BelCMS\Requires\Common;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Styles extends AdminPages
{
	#########################################
	# Variables
	#########################################
	var $admin  = true; // Admin suprême uniquement (Groupe 1);
	var $active = true; // activation manuel;
	var $bdd = 'ModelsStyles';
	#########################################
	# Premiere page avec le rendu de la page index.php
	#########################################
	public function index ()
	{
		$this->render('index');
	}
	#########################################
	# Recupere le styles.css de la page
	#########################################
	public function edit ()
	{
		$page = Common::VarSecure($this->data[2]);
		$return['data'] = $this->models->getStylesCss ($page);
		$return['page'] = $page;
		$this->set($return);
		$this->render ('edit');
	}
	#########################################
	# Sauvegarde du fichier styles.css de la page
	#########################################
	public function send ()
	{
		$return = $this->models->sendEditCss ($_POST['content'], $_POST['page']);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('styles?management&option=templates', 2);
	}
	#########################################
	# Recupere le styles.css du widget
	#########################################
	public function editWidgets ()
	{
		$widget = Common::VarSecure($this->data[2]);
		$return['data']   = $this->models->getStylesCssWidgets ($widget);
		$return['widget'] = $widget;
		$this->set($return);
		$this->render ('editwidget');
	}
	#########################################
	# Sauvegarde du fichier styles.css du widget
	#########################################
	public function sendWidget ()
	{
		$return = $this->models->sendEditCssWidget ($_POST['content'], $_POST['widget']);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('styles?management&option=templates', 2);
	}
}