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

namespace Belcms\Pages\Controller;
use Belcms\Pages\Pages;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

class Comments extends Pages
{
	var $useModels = 'Comments';

	public function send ()
	{
		if (isset($_SESSION['USER']->user->hash_key) and strlen($_SESSION['USER']->user->hash_key) == 32) {
			if (empty($_POST['text'])) {
				$this->error = true;
				$this->errorInfos = array('error', constant('COMMENT_EMPTY'), 'Commentaires', false);
				return;
			}
			if (empty($_POST['url'])) {
				$this->error = true;
				$this->errorInfos = array('error', constant('URL_EMPTY'), 'Commentaires', false);
				return;
			}
			$insert = $this->models->insertComment($this->data);
			if ($insert === false) {
				$this->error = true;
				$this->errorInfos = array($insert['type'], $insert['text'], 'Commentaires', false);
			} else {
				$this->error = true;
				$this->errorInfos = array($insert['type'], $insert['text'], 'Commentaires', false);
			}
		}

		$referer = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'news';
		$this->redirect($referer, 3);
	}
}
