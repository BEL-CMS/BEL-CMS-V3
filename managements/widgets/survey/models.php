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

use BelCMS\Core\Secure;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

#	TABLE_SURVEY
#->	id, question, timestop, dateclose, vote, answer_nb
#	TABLE_SURVEY_QUEST
#->	id, id_question, answer, nbvote
#	TABLE_SURVEY_VOTE
#->	id, id_vote, id_question , datetime_vote
final class ModelsSurvey
{
	public function getSurvey ()
	{
		$sql = new BDD;
		$sql->table('TABLE_SURVEY');
		$sql->queryAll();
		return $sql->data;
	}

	public function sendNew ($data)
	{
		if (is_array($data) and !empty($data)) {
			$insert['question']   = Common::VarSecure($data['name'], '');
			$insert['dateclose']  = $data['dateclose'] == 0 ? 'P99Y' : $data['dateclose'];
			$insert['answer_nb']  = is_numeric($data['nb']) ? $data['nb'] : 2;
			$sql = new BDD;
			$sql->table('TABLE_SURVEY');
			$sql->insert($insert);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SEND_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('SEND_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
}