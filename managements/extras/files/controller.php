<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Files extends AdminPages
{
	var $admin  = true;
	var $active = true;
	var $bdd = 'ModelsFiles';
	#####################################
    # Index de la page
	#####################################
	public function index ()
	{
		$data['data'] = $this->models->index ();
		$this->set($data);
		$this->render('index');
	}
	#####################################
    # Ajouter un fichier
	#####################################
	public function add ()
	{
		$this->render('add');
	}
	#####################################
    # Supprime un fichier
	#####################################
	public function del ()
	{
		$id     = (int) $this->id;
		$return = $this->models->delete($id);
		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('files?management&option=extras', 2);
	}
	#####################################
    # upload le fichier et la description
	#####################################
	public function sendimg ()
	{
		if (empty($_POST['name'])) {
			$this->error(get_class($this), 'Veuillez ajouter un nom', 'error');
			$this->redirect('files?management&option=extras', 2);
		}
		if ($_FILES['file']['name'] == ""){
			$this->error(get_class($this), 'Veuillez ajouter un document', 'error');
			$this->redirect('files?management&option=extras', 2);
		}

		$data['name'] = Common::VarSecure($_POST['name'], null);
		$data['name'] = Common::FormatName($data['name']);
		$data['description'] = Common::VarSecure($_POST['description']);

		$return = $this->models->sendpost($data);

		$this->error(get_class($this), $return['text'], $return['type']);
		$this->redirect('files?management&option=extras', 2);
	}
}