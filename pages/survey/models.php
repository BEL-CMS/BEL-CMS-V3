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
#	TABLE_SURVEY
#->	id, number, content, vote
#	TABLE_SURVEY_QUEST
#->	id, name, date
#	TABLE_SURVEY_AUTHOR
#->	id, idvote, author, date
final class ModelsSurvey
{
	public function addVote ($data)
	{
		$return = null;

		if (self::checkVote($data['id']) == false) {
			$return['text']	= 'Vous deja voté';
			$return['type']	= 'warning';
		} else {
			$insert['idvote'] = (int) $data['id'];
			$insert['author'] = $_SESSION['USER']['HASH_KEY'];
			$sql = New BDD;
			$sql->table('TABLE_SURVEY_AUTHOR');
			$sql->insert($insert);
			$_id = $_POST['vote'];
			if ($sql->rowCount == 1) {

				$select = New BDD;
				$select->table('TABLE_SURVEY');
				$where = array('name' => 'number', 'value' => $_id);
				$select->where($where);
				$select->queryOne();
				$select = $select->data;
				$oneplus['vote'] = $select->vote +1;

				$upd = New BDD;
				$upd->table('TABLE_SURVEY');
				$where = array('name' => 'number', 'value' => $_id);
				$upd->where($where);
				$upd->update($oneplus);

				$return['text']	= 'Vous avez voté avec succès.';
				$return['type']	= 'success';
			} else {
				$return['text']	= 'Impossible de voter erreur BDD';
				$return['type']	= 'error';
			}
		}

		return $return;
	}

	public function checkVote ($id = null)
	{
		if ($id != null && is_numeric($id)) {
			$sql = New BDD();
			$sql->table('TABLE_SURVEY_AUTHOR');
			$where[] = array('name'=>'idvote','value'=>$id);
			$where[] = array('name'=>'author','value'=>$_SESSION['USER']['HASH_KEY']);
			$sql->where($where);
			$sql->count();
			$returnCheckName = (int) $sql->data;
			if ($returnCheckName >= 1) {
				return false;
			} else {
				return true;
			}
		}
	}

	public function getSurvey ()
	{
		$return = array();

		$sql = New BDD();
		$sql->table('TABLE_SURVEY_QUEST');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryAll();
		if (!empty($sql->data)) {
			$return = $sql->data;
		}

		return $return;
	}
}