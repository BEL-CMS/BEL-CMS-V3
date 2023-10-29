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

class Survey extends Pages
{
	var $models = 'ModelsSurvey';

	public function index ()
	{
		$set['data'] = $this->models->getSurvey();
		foreach ($set['data'] as $k => $v) {
			$set['data'][$k]->vote = $this->models->checkVote($v->id);
			if ($set['data'][$k]->vote == false) {
				$set['data'][$k]->vote = '/pages/survey/img/green.png';
			} else {
				$set['data'][$k]->vote = '/pages/survey/img/red.png';
			}
		}
		$this->set($set);
		$this->render('index');
	}

	public function send ()
	{
		if (isset($_POST['id']) && is_numeric($_POST['id'])) {
			$return = $this->models->addVote($_POST);
			$this->error(get_class($this), $return['text'], $return['type']);
			$this->redirect('blog', 2);
		} else {
			$this->error(get_class($this), ERROR_NO_ID_VALID, 'error');
		}
	}
}