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

use BelCMS\Core\Interaction;
use BelCMS\Core\Secures;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\Templates\Templates;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
###  TABLE_NEWSLETTER
#-> id, name, email, registered
#	TABLE_NEWSLETTER_TPL
#-> id, name, template, date
#	TABLE_NEWSLETTER_SEND
#->	id, template, author, date 
final class ModelsNewsletter
{
	#####################################
	# Récupère le template depuis la BDD
	#####################################
	public function getTpl ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_TPL');
		if (is_numeric($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
		} else {
			$sql->queryAll();
		}
		return $sql->data;
	}
	#####################################
	# Enregistrement en BDD du template
	#####################################
	public function sendNewTpl ($data) : array
	{
		if (is_array($data)) {
			$insert['name']     = Common::VarSecure($data['name'], null);
			$insert['template'] = Common::VarSecure($data['tpl'], 'html');
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->insert($insert);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('ADD_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('ADD_TPL_ERROR')
				);
			}
		} else {
			new Interaction ('error', 'Erreur d\'array', constant('ADD_TPL_ERROR_ARRAY'));
			$return = array(
				'type' => 'error',
				'text' => constant('ADD_TPL_ERROR_ARRAY')
			);
		}
		return $return;
	}
	#####################################
	# Edition du TPL en BDD
	#####################################
	public function sendeditpl ($data) : array
	{
		if (is_array($data)) {
			$update['name']     = Common::VarSecure($data['name'], null);
			$update['template'] = Common::VarSecure($data['tpl'], 'html');
			$id                 = is_numeric($data['id']) ? $data['id'] : 0;
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($update);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('EDIT_TPL_ERROR')
				);
			}
		} else {
			new Interaction ('error', 'Erreur d\'array', constant('ADD_TPL_ERROR_ARRAY'));
			$return = array(
				'type' => 'error',
				'text' => constant('ADD_TPL_ERROR_ARRAY')
			);
		}
		return $return;
	}
	#####################################
	# Suppression du TPL
	#####################################
	public function deltpl ($id = null) : array
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->delete();
			if ($sql->data === true) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('DEL_TPL_ERROR')
				);
			}
		} else {
			$return = array (
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);
		}
		return $return;
	}
	#####################################
	# Récupère les utilisateur inscrit
	#####################################
	public function getUsersNewsletter ($id = null) : array
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER');
		if (is_numeric($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
		} else {
			$sql->queryAll();
		}
		return $sql->data;
	}
	#####################################
	# Récupère les information des envoies
	#####################################
	public function getAdd ($id = null)
	{
		$sql = new BDD;
		$sql->table('TABLE_NEWSLETTER_SEND');
		if (is_numeric($id)) {
			$where = array('name' => 'id', 'value' => $id);
			$sql->where($where);
			$sql->queryOne();
			$sql->data->nametpl = self::getTpl($sql->data->template);
		} else {
			$sql->queryAll();
			foreach ($sql->data as $key => $value) {
				$sql->data[$key]->nametpl = self::getTpl($value->template);
			}
		}
		return $sql->data;

	}
	#####################################
	# Enregistre dans la BDD
	# la préparation d'envoie
	#####################################
	public function sendPrepa ($data = null) : array
	{
		if (is_array($data)) {
			$insert['receiver'] = Common::VarSecure($data['send'], null);
			$insert['template'] = Common::VarSecure($data['tpl'], null);
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_SEND');
			$sql->insert($insert);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('PREPA_TPL_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('PREPA_TPL_ERROR')
				);
			}
		} else {
			$return = array (
				'type' => 'error',
				'text' => constant('ID_ERROR')
			);
			new Interaction('error', constant('ID_ERROR_TITLE'), constant('ID_ERROR'));
		}
		return $return;
	}
	#####################################
	# Préparation du mail à envoyer
	#####################################
	public function sendMails ($id = null)
	{
		$mail = array();
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_NEWSLETTER_SEND');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$sql->data->nametpl = self::getTpl($sql->data->template);
			$test    = strpos('group_', $sql->data->receiver);
			$replace = str_replace('group_','', $sql->data->receiver);
			if ($test === false) {
				if ($test == '1') {
					$userAll = new BDD;
					$userAll->table('TABLE_USERS');
					$userAll->queryAll();
					foreach ($userAll->data as $user) {
						$mail[] = $user->mail;
					}
				} else if ($test == '2') {
					$userNewsletter = new BDD;
					$userNewsletter->table('TABLE_NEWSLETTER');
					$userNewsletter->queryAll();
					foreach ($userNewsletter->data as $user) {
						$mail[] = $user->mail;
					}
				} else if (is_numeric($replace)) {
					$mail = self::getUsersForMail($replace);
				}
			}
			$tpl = new BDD;
			$tpl->table('TABLE_NEWSLETTER_TPL');
			$tpl->where(array('name' => 'id', 'value' => $sql->data->template));
			$tpl->queryOne();
			$template = $tpl->data->template;
			if (self::getReadyMail($tpl->data->name, $mail, $template) === true) {
				$return = array(
					'type' => 'success',
					'text' => constant('MAIL_SEND_OK')
				);
			} else {
				$return = array(
					'type' => 'error',
					'text' => constant('MAIL_SEND_NOK')
				);
			}
			return $return;
		}
	}
	#####################################
	# Envoie des mails
	#####################################
	private function getReadyMail ($subject, $mails, $template)
	{
		$i     = 0;
		$count = count($mails);
		$template = Common::VarSecure($template, 'html');
		foreach ($mails as $key => $value) {
			$destinataire     = $value->user->mail;
			$data['name']     = $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
			$data['mail']     = $_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'];
			$data['subject']  = $subject;
			$data['sendMail'] = $destinataire;
			$template  = str_replace('{{user}}', $value->user->username, $template);
			$template  = str_replace('{{lastvisit}}', $value->page->last_visit, $template);
			$template  = str_replace('{{maingroup}}', $value->groups->user_group, $template);
			$data['content'] = $template;
			if ($count <= $i) {
				$i = $i + 1;
				return Common::SendMail($data);
			}
		}
	}
	#####################################
	# Récupere tout les utilisateur 
	# par groupe principal
	#####################################
	private function getUsersForMail ($group = null)
	{
		$group = (int) $group;
		$sql = new BDD;
		$sql->table('TABLE_USERS_GROUPS');
		$sql->where(array('name' => 'user_group', 'value' => $group));
		$sql->queryAll();

		foreach ($sql->data as $key => $value) {
			$return[$key] = User::getInfosUserAll($value->hash_key);
		}
		return $return;
	}


	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'newsletter'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('PARAMETER_EDITING_SUCCESS')
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