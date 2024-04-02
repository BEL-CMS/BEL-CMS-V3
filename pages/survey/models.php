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

namespace Belcms\Pages\Models;
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
#->	id, id_vote, author, datetime_vote
final class Survey
{
	public function vote ($data)
	{
		if (is_numeric($data['answer']) and is_numeric($data['quest']) and is_numeric($data['id'])) {
			$answer   = (int) $data['answer'];
			$quest    = (int) $data['quest'];
			$idanswer = (int) $data['id'];
			$where[]  = array('name' => 'id_vote', 'value' => $answer);
			$where[]  = array('name' => 'id_question', 'value' => $quest);
			$sql = new BDD;
			$sql->table('TABLE_SURVEY_VOTE');
			$sql->where($where);
			$sql->count();
			$count = $sql->data;

			if ($count == 0 or $count > 0) {
				$d['id_vote']     = $quest;
				$d['id_question'] = $answer;
				$d['author']      = $_SESSION['USER']->user->hash_key;
				$insert = new BDD;
				$insert->table('TABLE_SURVEY_VOTE');
				$insert->insert($d);

				$countVote = new BDD;
				$countVote->table('TABLE_SURVEY');
				$countVote->where(array('name' => 'id', 'value' => $answer));
				$countVote->queryOne();
				$surveyCountVote = $countVote->data->vote;
				$surveyCountVote = $surveyCountVote +1;

				$update['vote'] = $surveyCountVote;
				$onePlus = new BDD;
				$onePlus->table('TABLE_SURVEY');
				$onePlus->where(array('name' => 'id', 'value' => $answer));
				$onePlus->update($update);


				$addVote = new BDD;
				$addVote->table('TABLE_SURVEY_QUEST');
				$addVote->where(array('name' => 'id', 'value' => $idanswer));
				$addVote->queryOne();
				$addVoteCountVote = $addVote->data->vote;
				$addVoteCountVote = $addVoteCountVote +1;

				$up['count_vote'] = $addVoteCountVote;
				$onePlus = new BDD;
				$onePlus->table('TABLE_SURVEY_QUEST');
				$onePlus->where(array('name' => 'id', 'value' => $idanswer));
				$onePlus->update($up);

				$return = 'Vote pris en compte';
			} else {
				$return = 'Vous avez déjà voté';
			}
			return $return;
		}
	}

	public function getAllSurvey ()
	{
		$sql = new BDD;
		$sql->table('TABLE_SURVEY');
		$sql->queryAll();
		return $sql->data;
	}

	public function newSurvey ($data)
	{
		if (is_array($data) and is_numeric($data['id'])) {
			$answer = new BDD;
			$answer->table('TABLE_SURVEY');
			$answer->where(array('name' => 'id', 'value' => $data['id']));
			$answer->queryOne();

			$answer_nb = $answer->data->answer_nb;

			$date = new \DateTimeImmutable($answer->data->timestop);
			$expirationDate = $date->add(new \DateInterval($answer->data->dateclose));
			$now_date = new \DateTime("now");
			$interval = $now_date->diff($expirationDate);

			if ($interval->invert == 0) {
				$sql = new BDD;
				$sql->table('TABLE_SURVEY_QUEST');
				$sql->where(array('name' => 'id_question', 'value' => $data['id']));
				$sql->count();
				$insertData['id_question'] = $data['id'];
				$insertData['answer'] = Common::VarSecure($data['name'], '');
				if ($sql->data < $answer_nb) {
					$insert = new BDD;
					$insert->table(('TABLE_SURVEY_QUEST'));
					$insert->insert($insertData);
					self::vote($data['id']);
				}
				return true;
			} else {
				return false;
			}
		}
	}
}