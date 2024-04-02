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

namespace Belcms\Widgets\Models\Survey;
use BelCMS\PDO\BDD;

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
class Survey
{
    public function getSurvey ()
    {
        $sql = new BDD;
        $sql->table('TABLE_SURVEY');
        $sql->limit(1);
        $sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
        $sql->queryOne();
        $sql->data->answer = self::getAnswer($sql->data->id, $sql->data->answer_nb, $sql->data->question);
        $return = $sql->data;
        return $return;
    }

    private function getAnswer ($id, $limit, $question)
    {
        if (is_numeric($id)) {
            $sql = new BDD;
            $sql->table('TABLE_SURVEY_QUEST');
            $sql->orderby(array(array('name' => 'id', 'type' => 'ASC')));
            $sql->where(array('name' => 'id_question', 'value' => $id));
            $sql->limit($limit);
            $sql->queryAll();
            foreach ($sql->data as $key => $value) {
                $sql->data[$key]->question = $question;
                $sql->data[$key]->userVote = self::getUserVote($value->id_question);
            }
            $return = $sql->data;
            return $return;
        }
    }

    private function getVote ($id)
    {
        if (is_numeric($id)) {
            $sql = new BDD;
            $sql->table('TABLE_SURVEY_VOTE');
            $sql->where(array('name' => 'id_question', 'value' => $id));
            $sql->count();
            return $sql->data;
        }
    }

    private function getUserVote ($id)
    {
        if (is_numeric($id)) {
            $where[] = array('name' => 'id_question', 'value' => $id);
            $where[] = array('name' => 'author', 'value' => $_SESSION['USER']->user->hash_key);
            $sql = new BDD;
            $sql->table('TABLE_SURVEY_VOTE');
            $sql->where($where);
            $sql->count();
            if ($sql->data >= 1) {
                return false;
            } else {
                return true;
            }
        }
    }
}