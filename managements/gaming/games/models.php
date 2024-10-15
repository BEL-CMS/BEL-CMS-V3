<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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

use BelCMS\Requires\Common;
use BelCMS\PDO\BDD;
use BelCMS\Core\Config;

final class ModelsGames
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_PAGES_GAMES
	#####################################
	# récupère les jeux
	#####################################
	public function getGames ($id = null)
	{
		$return = (object) array();
		$sql    = New BDD();
		$sql->table('TABLE_PAGES_GAMES');

		if ($id !== null && is_numeric($id)) {
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
		} else {
			$sql->queryAll();
			if (empty($sql->data)) {
				$return = (object) array();
			} else {
				$return = $sql->data;
			}
		}
		return $return;
	}
	#####################################
	# Ajoute un jeu
	#####################################
	public function addGame ($data = false)
	{
		$error  = 0;
		$error1 = 0;
		$dir    = 'uploads/games/';
		$extensions = array('.png', '.gif', '.jpg', '.jpeg');

		if ($_FILES['banner']['size'] != 0) {
			$extension = strrchr($_FILES['banner']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error;
				$return['type'] = 'alert';
			}
			if (move_uploaded_file($_FILES['banner']['tmp_name'], $dir.$_FILES['banner']['name'])) {
				$send['banner'] = $dir.$_FILES['banner']['name'];
			} else {
				$return['msg']  = 'Echec de l\'upload !';;
				$return['type'] = 'warning';
			}
		} else {
			$send['banner'] = null;
		}
		if ($_FILES['ico']['size'] != 0) {
			$extension = strrchr($_FILES['ico']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error1;
				$return['type'] = 'alert';
			}
			if ($error1 == 0) {
				if (move_uploaded_file($_FILES['ico']['tmp_name'], $dir.$_FILES['ico']['name'])) {
					$send['ico'] = $dir.$_FILES['ico']['name'];
				} else {
					$return['msg']  = 'Echec de l\'upload !'; ++$error1;
					$return['type'] = 'warning';
				}
			}
		} else {
			$send['ico'] = null;
		}

		/* Secure data before insert BDD */
		$send['name'] = Common::VarSecure($data['name'], '');

		$sql = New BDD();
		$sql->table('TABLE_PAGES_GAMES');
		$sql->insert($send);
		$sql->insert();
		$countRowUpdate = $sql->rowCount;

		if ($countRowUpdate != 0) {
			$return['msg']  = 'Vos informations ont été sauvegardées avec succès';
			$return['type'] = 'success';
		} else {
			$return['msg']  = 'Vos informations n\'ont pas été sauvegardées ou partiellement';
			$return['type'] = 'warning';
		}

		return $return;
	}

	public function editGame ($data)
	{
		$error  = 0;
		$error1 = 0;
		$dir = 'uploads/games/';

		$extensions = array('.png', '.gif', '.jpg', '.jpeg');

		if ($_FILES['banner']['size'] != 0) {
			$extension = strrchr($_FILES['banner']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error;
				$return['type'] = 'alert';
			}
			if ($error == 0) {
				if (move_uploaded_file($_FILES['banner']['tmp_name'], $dir.$_FILES['banner']['name'])) {
					$edit['banner'] = $dir.$_FILES['banner']['name'];
				} else {
					$return['msg']  = 'Echec de l\'upload !'; ++$error;
					$return['type'] = 'warning';
				}
			}
		}

		if ($_FILES['ico']['size'] != 0) {
			$extension = strrchr($_FILES['ico']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error1;
				$return['type'] = 'alert';
			}
			if ($error1 == 0) {
				if (move_uploaded_file($_FILES['ico']['tmp_name'], $dir.$_FILES['ico']['name'])) {
					$edit['ico'] = $dir.$_FILES['ico']['name'];
				} else {
					$return['msg']  = 'Echec de l\'upload !'; ++$error1;
					$return['type'] = 'warning';
				}
			}
		}

		/* Secure data before insert BDD */
		$id                  = (int) $data['id'];
		$edit['name']        = Common::VarSecure($data['name'], '');

		$sql = New BDD();
		$sql->table('TABLE_PAGES_GAMES');
		$sql->where(array('name'=>'id','value'=> $id));
		$sql->update($edit);

		if ($sql->rowCount != 0) {
			$return['msg']  = 'Vos informations ont été sauvegardées avec succès';
			$return['type'] = 'success';
		} else {
			$return['msg']  = 'Vos informations n\'ont pas été sauvegardées ou partiellement';
			$return['type'] = 'warning';
		}

		return $return;
	}

	public function delGame ($id = null)
	{
		if ($id && is_numeric($id)) {
			$game = self::getGames ($id);
			// delete file
			if (!empty($game->banner)) {
				if (is_file($game->banner)) {
					@unlink($game->banner);
				}
			}
			// delete file
			if (!empty($game->ico)) {
				if (is_file($game->ico)) {
					@unlink($game->ico);
				}
			}
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_GAMES');
			$sql->where(array('name'=>'id','value' => $id));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_GAME_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_GAME_ERROR')
				);
			}
			return $return;
		}
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['MAX_GAMING_PAGE'] = (int) $data['MAX_GAMING_PAGE'];
			$opt                     = array('MAX_GAMING_PAGE' => $data['MAX_GAMING_PAGE']);
			$data['admin']           = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']          = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']           = Common::transformOpt($opt, true);
			$upd['active']           = isset($data['active']) ? 1 : 0;
			$upd['access_admin']     = implode("|", $data['admin']);
			$upd['access_groups']    = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'games'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_GAME_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_GAME_PARAM_ERROR')
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