<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
#->	id, id_question, answer
#	TABLE_SURVEY_VOTE
#->	id, id_vote, id_question , datetime_vote
final class ModelsSurvey
{
	#########################################
	# Récupère les questions
	#########################################
	public function getSurvey ()
	{
		$sql = new BDD;
		$sql->table('TABLE_SURVEY');
		$sql->queryAll();
		return $sql->data;
	}
	#########################################
	# Enregistre une nouvelle question
	#########################################
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
	#########################################
	# Récupère les réponses
	#########################################
	public function getReply ($id)
	{
		if (is_int($id) and !empty($id)) {
			$sql = new BDD;
			$sql->table('TABLE_SURVEY_QUEST');
			$sql->where(array('name' => 'id_question', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			return $return;
		}
	}
	#########################################
	# Récupère le nombre de question
	#########################################
	public function getNbAnswer ($id)
	{
		if (is_int($id) and !empty($id)) {
			$sql = new BDD;
			$sql->table('TABLE_SURVEY');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			return $return;
		}
	}
	#########################################
	# Enregistre les question
	#########################################
	public function sendReply ($data)
	{
		if (is_array($data) and !empty($data)) {
			foreach ($data['reply'] as $key => $value) {
				if (!empty($value)) {
					$reply[$key] = $value;
				}
			}
			foreach ($reply as $key => $value) {
				$insert['id_question'] = (int) $data['id'];
				$insert['answer']      = Common::VarSecure($value, '');
				$sql = new BDD;
				$sql->table('TABLE_SURVEY_QUEST');
				$sql->insert($insert);
			}
			$return = array(
				'type' => 'success',
				'text' => constant('SEND_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
	#########################################
	# Editer la question et les paramètres
	#########################################
	public function edit ($id)
	{
		if (is_int($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql = new BDD;
			$sql->table('TABLE_SURVEY');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
	#########################################
	# Enregistre les questions
	#########################################
	public function sendEdit ($data)
	{
		if (is_array($data) and is_numeric($data['id'])) {
			$update['question']  = Common::VarSecure($data['name'], '');
			$update['dateclose'] = Common::VarSecure($data['dateclose'], '');
			$update['answer_nb'] = Secure::isInt($data['nb']);
			$where = array('name' => 'id', 'value' => $data['id']);
			$sql = new BDD;
			$sql->table('TABLE_SURVEY');
			$sql->where($where);
			$sql->update($update);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_PARAM_ERROR')
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
	#########################################
	# Enregistre les paramètres
	#########################################
	public function sendparameter ($data)
	{
		$return = array();

		if (!empty($data) && is_array($data)) {
			$upd['title']         = Common::VarSecure($data['title'], '');
			$upd['groups_access'] = implode("|", $data['groups']);
			$upd['groups_admin']  = implode("|", $data['admin']);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			if ($data['pos'] == 'top') {
				$upd['pos'] = 'top';
			} else if ($data['pos'] == 'bottom') {
				$upd['pos'] = 'bottom';
			} else if ($data['pos'] == 'left') {
				$upd['pos'] = 'left';
			} else if ($data['pos'] == 'right') {
				$upd['pos'] = 'right';
			}
			if (isset($data['current'])) {
				$upd['pages']  = implode("|", $data['current']);
			}
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_WIDGETS');
			$sql->where(array('name' => 'name', 'value' => 'survey'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_PARAM_ERROR')
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