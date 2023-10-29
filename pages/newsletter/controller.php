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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Newsletter extends Pages
{
	var $models = 'ModelsNewsletter';

	public function index ()
	{
		if (isset($_SESSION['USER'])) {
			$grp = Users::getGroups($_SESSION['USER']['HASH_KEY']);
			if (in_array(1, $grp)) {
				$set['data'] = $this->models->getuUersList();
				$this->set($set);
				$this->render('index');
			} else {
				$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
				$this->redirect('blog', 2);
			}
		} else {
			$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
			$this->redirect('blog', 2);
		}
	}

	public function send ()
	{
		if (isset($_SESSION['USER'])) {
			if (Users::isLogged()) {
				$return = $this->models->sendNew($_POST);
				$this->error (get_class($this), $return['text'], $return['type']);
				$this->redirect('blog', 2);
			} else {
				$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
				$this->redirect('blog', 2);
			}
		} else {
			$this->redirect('blog', 2);
			$this->error(get_class($this), NO_ACCESS_GROUP_PAGE, 'error');
		}
	}
}