<?php
/**
 * Bel-CMS [Content management system]
 * @version 2.1.0
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2022 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsTeam
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_TEAM
	# TABLE_TEAM_USERS
	# TABLE_PAGES_GAMES
	#####################################
	# récupère les teams
	#####################################
	public function getTeam ($id = false)
	{
		$sql = New BDD();
		$sql->table('TABLE_TEAM');
		$sql->orderby(array(array('name' => 'orderby', 'type' => 'DESC')));
		if ($id !== false && is_numeric($id)) {
			$id = (int) $id;
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			return $sql->data;
		} else {
			$sql->queryAll();
			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->user = self::getUsersTeam($v->id);
			}
			foreach ($sql->data as $k => $v) {
				$sql->data[$k]->count = count($v->user);
			}

			foreach ($sql->data as $k => $v) {
				if ($v->game != 0 ) {
					$sql->data[$k]->game = self::getGames($v->game);
				}
			}

			return $sql->data;
		}
	}
	#####################################
	# récupère les jeux
	#####################################
	public function getGames ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_GAMES');

		if ($id != null && $id != 0) {
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			return $sql->data;
		}

		$sql->queryAll();
		return $sql->data;
	}
	#####################################
	# récupère les joueurs de la team
	#####################################
	public function getUsersTeam ($id)
	{
		$id = (int) $id;

		$sql = New BDD();
		$sql->table('TABLE_TEAM_USERS');
		$where = array(
			'name' => 'teamid',
			'value' => $id
		);
		$sql->where($where);
		$sql->queryAll();

		return $sql->data;
	}
	#####################################
	# Modifie la team
	#####################################
	public function SendEdit ($data)
	{
		$error = null;
		if ($_FILES['img']['size'] != 0) {
			$dir = 'uploads/team/';
			if (!file_exists($dir)) {
				if (!mkdir($dir, 0777, true)) {
					throw new Exception('Failed to create directory');
				} else {
					$fopen  = fopen($dir.'/index.html', 'a+');
					$fclose = fclose($fopen);
				}
			}
			$extensions = array('.png', '.gif', '.jpg', '.jpeg');
			$extension = strrchr($_FILES['img']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error;
				$return['type'] = 'alert';
			}
			if (move_uploaded_file($_FILES['img']['tmp_name'], $dir.$_FILES['img']['name'])) {
				$edit['img'] = $dir.$_FILES['img']['name'];
			} else {
				$return['msg']  = 'Echec de l\'upload !'; ++$error;
				$return['type'] = 'warning';
			}
		} else {
			$edit['img'] = $data['img_pre'];
		}
		if ($error == null) {
			/* Secure data before insert BDD */
			$id                  = (int) $data['id'];
			$edit['name']        = Common::VarSecure($data['name'], '');
			$edit['game']        = (int) $data['game'];
			$edit['description'] = Common::VarSecure($data['description'], 'html');
			$edit['orderby']     = (int) $data['orderby'];

			$sql = New BDD();
			$sql->table('TABLE_TEAM');
			$sql->where(array('name'=>'id','value'=> $id));
			$sql->insert($edit);
			$sql->update();
			$countRowUpdate = $sql->rowCount;

			if ($countRowUpdate != 0) {
				$return['msg']  = 'Vos informations ont été sauvegardées avec succès';
				$return['type'] = 'success';
			} else {
				$return['msg']  = 'Vos informations n\'ont pas été sauvegardées ou partiellement';
				$return['type'] = 'warning';
			}
		}

		return $return;
	}
	#####################################
	# Enregistre une nouvelle team
	#####################################
	public function SendAdd($data)
	{
		$error = null;
		if ($_FILES['img']['size'] != 0) {
			$dir = 'uploads/team/';
			if (!file_exists($dir)) {
				if (!mkdir($dir, 0777, true)) {
					throw new Exception('Failed to create directory');
				} else {
					$fopen  = fopen($dir.'/index.html', 'a+');
					$fclose = fclose($fopen);
				}
			}
			$extensions = array('.png', '.gif', '.jpg', '.jpeg');
			$extension = strrchr($_FILES['img']['name'], '.');
			if (!in_array($extension, $extensions)) {
				$return['msg']  = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg'; ++$error;
				$return['type'] = 'alert';
			}
			if (move_uploaded_file($_FILES['img']['tmp_name'], $dir.$_FILES['img']['name'])) {
				$insert['img'] = $dir.$_FILES['img']['name'];
			} else {
				$return['msg']  = 'Echec de l\'upload !'; ++$error;
				$return['type'] = 'warning';
			}
		} else {
			$insert['img'] = $data['img_pre'];
		}

			/* Secure data before insert BDD */
			$insert['name']        = Common::VarSecure($data['name'], '');
			$insert['description'] = Common::VarSecure($data['description'], 'html');
			$insert['orderby']     = (int) $data['orderby'];
			$insert['game']        = (int) $data['game'];
 
			$sql = New BDD();
			$sql->table('TABLE_TEAM');
			$sql->insert($insert);
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
	#####################################
	# Récupère tout les utilisateurs
	#####################################
	public function getUsers ()
	{
		$sql = New BDD();
		$sql->table('TABLE_USERS');
		$sql->fields(array('username', 'hash_key'));
		$sql->queryAll();

		return $sql->data;
	}
	#####################################
	# Enregistre les utilisateurs dans une team
	#####################################
	public function sendPlayerEdit ($data)
	{
		$i = 0;
		$id = (int) $_POST['id'];

		$del = New BDD();
		$del->table('TABLE_TEAM_USERS');
		$del->where(array('name'=>'teamid','value' => $id));
		$del->delete();

		if (isset($data['team'])) {
			foreach ($data['team'] as $k => $v) {
				$sql = New BDD();
				$sql->table('TABLE_TEAM_USERS');
				$insert['teamid'] = $id;
				$insert['author'] = $v;
				$sql->insert($insert);
				$sql->insert();
				$i++;
			}
		}
		if ($i != 0) {
			$return['msg']  = 'Vos informations ont été sauvegardées avec succès : ('.$i.')';
			$return['type'] = 'success';
		} else {
			$return['msg']  = 'Vos informations n\'ont pas été sauvegardées ou partiellement';
			$return['type'] = 'warning';
		}

		return $return;
	}

	public function del ($id)
	{
		$id = (int) $id;

		if ($id && is_numeric($id)) {
			// SECURE DATA
			$id = (int) $id;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_TEAM');
			$sql->where(array('name'=>'id','value' => $id));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'msg' => DEL_TEAM_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'msg' => DEL_TEAM_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'msg' => ERROR_NO_DATA
			);
		}
		return $return;
	}
}