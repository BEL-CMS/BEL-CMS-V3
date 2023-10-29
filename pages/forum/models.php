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

namespace Belcms\Pages\Models;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;
use BelCMS\User\User as User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
###  TABLE_FORUM_POST
###  TABLE_FORUM_POSTS
###  TABLE_FORUM_THREADS
final class Forum
{
	#####################################
	# Récupère les noms des forums
	#####################################
	public function getForum ()
	{
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		$sql->orderby(array(array('name' => 'orderby', 'type' => 'ASC')));
		$where = array(
			'name' => 'activate',
			'value' => 1
		);
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;

		if (!empty($return)) {

			foreach ($return as $k => $v) {
				$access = false;
				$groups = explode('|', $v->access_groups);
				if (in_array(1, $groups)) {
					$access = true;
				}
				foreach ($groups as $v_access) {
					if ($v_access == 0) {
						$access = true;
						break;
					} else {
						if (User::getInfosUserAll($_SESSION['USER']->user->hash_key) !== false) {
							$v_access = explode('|', $v_access);
							foreach ($v_access as $key_access => $value_access) {
								if (in_array($value_access, $_SESSION['USER']->groups->all_groups)) {
									$access = true;
									break;
								}
							}
						}
					}
				}
			}

			if ($access === false) {
				unset($return[$k]);
			}
		}


		return $return;
	}
	#####################################
	# Récupère les noms des forums
	#####################################
	public function getAccessForum ($data)
	{
		$data = (int) $data;
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		$sql->orderby(array(array('name' => 'orderby', 'type' => 'ASC')));
		$where = array(
			'name' => 'id',
			'value' => $data
		);
		$sql->where($where);
		$sql->queryOne();
		$return = $sql->data;
		if ($return) {
			$return = explode('|', $return->access_admin);
		}
		return $return;
	}
	#####################################
	# Récupère les catégories du forum
	#####################################
	public function getCatForum ($id)
	{
		$id = (int) $id;
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM_THREADS');
		$sql->orderby(array(array('name' => 'orderby', 'type' => 'ASC')));
		$where = array(
			'name' => 'id_forum',
			'value' => $id
		);
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère le dernier post
	#####################################
	public function getLastPostForum ($id)
	{
		$id = (int) $id;
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$where = array(
			'name' => 'id_threads',
			'value' => $id
		);
		$sql->where($where);
		$sql->limit(1);
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère le nombre de post
	#####################################
	public function CountSjForum ($id)
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$where = array(
			'name' => 'id_threads',
			'value' => $id
		);
		$sql->where($where);
		$sql->count();
		$return = $sql->data;
		return $return;
	}
	public function CountPosts ()
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$where = array(
			'name' => 'author',
			'value' => $id
		);
		$sql->where($where);
		$sql->count();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère les posts
	#####################################
	public function GetThreadsPost ($id)
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$where = array(
			'name' => 'id_threads',
			'value' => $id
		);
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}
	public function GetThreadName ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM_THREADS');
		$whereThreads = array(
			'name'  => 'id',
			'value' => (int) $id
		);
		$sql->where($whereThreads);
		$sql->fields('title');
		$sql->queryOne();
		$return = $sql->data;
		if (empty($return)) {
			$return = null;
		}
		return $return;
	}
	
	#####################################
	# Récupère le dernier posts
	#####################################
	public function getLastPostsForum ($id)
	{
		$id = (int) $id;
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POSTS');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$where = array(
			'name' => 'id_post',
			'value' => $id
		);
		$sql->where($where);
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	#####################################
	# Récupère le post origine
	#####################################
	public function getLastPostsOriginForum ($id, $id_threads)
	{
		$id = Common::SecureRequest($id);
		$return = array();
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$where[] = array(
			'name' => 'id',
			'value' => $id
		);
		$where[] = array(
			'name' => 'id_threads',
			'value' => $id_threads
		);
		$sql->where($where);
		$sql->queryOne();
		$return = $sql->data;
		return $return;
	}
	public function editpost ($id = null)
	{
		$return = null;
		if ($id != null) {
			$id   = Common::SecureRequest($id);
			$sql  = New BDD();
			$sql->table('TABLE_FORUM_POSTS');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
		}
		return $return;
	}

	public function editpostprimary ($id = null)
	{
		$return = null;
		if ($id != null) {
			$id   = Common::SecureRequest($id);
			$sql  = New BDD();
			$sql->table('TABLE_FORUM_POST');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
		}
		return $return;
	}

	public function sendEditPost ($d)
	{
		$data['content'] = Common::VarSecure($d['content']);
		$update = New BDD();
		$update->table('TABLE_FORUM_POSTS');
		$where[] = array(
			'name'  => 'id',
			'value' => Common::SecureRequest($d['id'])
		);
		$where[] = array(
			'name'  => 'id_post',
			'value' => Common::SecureRequest($d['id_post'])
		);
		$update->where($where);
		$text = $data['content'];
		$update->update(array('content' => $text));
		if ($update->rowCount == 1) {
			$return['msg']  = constant('EDIT_SUCCESS');
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('EDIT_FALSE');
			$return['type'] = 'error';
		}
		return $return;	
	}

	public function SendEditPostPrimary ($d)
	{
		$data['content'] = Common::VarSecure($d['content']);
		$update = New BDD();
		$update->table('TABLE_FORUM_POST');
		$where = array(
			'name'  => 'id_threads',
			'value' => Common::SecureRequest($d['id_threads'])
		);
		$update->where($where);
		$text = $data['content'];
		$update->update(array('content' => $text));
		if ($update->rowCount == 1) {
			$return['msg']  = constant('EDIT_SUCCESS');
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('EDIT_FALSE');
			$return['type'] = 'error';
		}
		return $return;
	}
	#####################################
	# Récupère les posts
	#####################################
	public function GetPosts($id = false, $id_supp = null)
	{
		$return = false;
		if ($id && $id_supp) {
			$id_supp = (int) $id_supp;
			// Récupère le 1er message du post //
			$sql = New BDD();
			$sql->table('TABLE_FORUM_POST');
			$sql->where(array('name' => 'id', 'value' => $id_supp));
			$sql->limit(1);
			$sql->queryAll();
			$firstPost = $sql->data;
			unset($sql);
			// Récupère les reponses du post //
			$sql = New BDD();
			$sql->table('TABLE_FORUM_POSTS');
			$sql->where(array('name' => 'id_post', 'value' => $id_supp));
			$sql->orderby(array(array('name' => 'date_post', 'type' => 'ASC')));
			$sql->queryAll();
			$posts = $sql->data;
			// Assemble les deux tableaux
			$return = array_merge($firstPost, $posts);
			foreach ($return as $k => $v) {
				$author = User::getInfosUserAll($v->author);
				// Fait corrépondre leurs ID avec leur username
				$return[$k]->author       = $author->user->username;
				// Fait corrépondre leurs ID avec leur avatar
				$return[$k]->avatar       = $author->profils->avatar;
				// Fait corrépondre leurs ID avec leur date d'inscription
				$return[$k]->registration = (isset($author->date_registration)) ? Common::TransformDate($author->date_registration) : '';
				$return[$k]->group        = $author->groups->user_group;
				$return[$k]->authorId     = $v->author;
				$return[$k]->countPost    = self::nbUserForum($v->author);
				// Récupère les options et les transformer en Booleen
				// Les like sont transoformer en (int)
				$options = explode('|', $v->options);
				foreach ($options as $k_opt => $v_opt) {
					$tmp_opt = explode('=', $v_opt);
					$options[$tmp_opt[0]] = $tmp_opt[1] == 1 ? true : false;
					if (isset($options['like'])) {
						$options['like'] = $options['like'] == false ? (int) 0 : $options['like'];
					}
					unset($options[$k_opt], $tmp_opt);
				}
				$return[$k]->options = $options;
			}
		}
		return $return;
	}
	#####################################
	# Ajoute une vue supplèmentaire au post
	#####################################
	public function addView ($id = false) {
		if ($id && is_int($id)) {
			$get = New BDD();
			$get->table('TABLE_FORUM_POST');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			$data = $get->data;

			if ($get->rowCount != 0) {
				$options = Common::transformOpt($data->options);
				$options['view'] = (int) $options['view'] + 1;
				$options = Common::transformOpt($options, true);

				$update = New BDD();
				$update->table('TABLE_FORUM_POST');
				$update->where($where);
				$update->update(array('options' => $options));
			}
		}
	}
	#####################################
	# Lock le post
	#####################################
	public function lock ($id = false)
	{
		if ($id) {
			$id = Common::SecureRequest($id);
			$where = array('name' => 'id', 'value' => $id);
			# recupere le post
			$get = New BDD();
			$get->table('TABLE_FORUM_POST');
			$get->where($where);
			$get->queryOne();
			$data = $get->data;

			$options = Common::transformOpt($data->options);
			$options['lock'] = (int) 1;
			$options = Common::transformOpt($options, true);

			# update le post
			$update = New BDD;
			$update->table('TABLE_FORUM_POST');
			$update->where($where);
			$update->update(array('options' => $options));
			# verifie si c'est bien inserer
			if ($update->rowCount == 1) {
				$return['msg']  = constant('LOCK_SUCCESS');
				$return['type'] = 'success';
			} else {
				$return['msg']  = constant('ERROR_LOCK_BDD');
				$return['type'] = 'error';
			}
			# return le resulat
			return $return;
		}
	}
	#####################################
	# Delock le post
	#####################################
	public function unlock ($id = false)
	{
		if ($id) {
			$id = (int) $id;
			$where = array('name' => 'id', 'value' => $id);
			# recupere le post
			$get = New BDD();
			$get->table('TABLE_FORUM_POST');
			$get->where($where);
			$get->queryOne();
			$data = $get->data;

			$options = Common::transformOpt($data->options);
			$options['lock'] = (int) 0;
			$options = Common::transformOpt($options, true);

			# update le post
			$update = New BDD;
			$update->table('TABLE_FORUM_POST');
			$update->where($where);
			$update->update(array('options' => $options));
			# verifie si c'est bien inserer
			if ($update->rowCount == 1) {
				$return['msg']  = constant('UNLOCK_SUCCESS');
				$return['type'] = 'success';
			} else {
				$return['msg']  = constant('ERROR_UNLOCK_BDD');
				$return['type'] = 'error';
			}
			# return le resulat
			return $return;
		}
	}
	#####################################
	# Supprime le(s) post(s)
	#####################################
	public function delpost ($id = false)
	{
		if ($id) {
			$id = (int) $id;
			$where = array('name' => 'id', 'value' => $id);
			$del = New BDD();
			$del->table('TABLE_FORUM_POST');
			$del->where($where);
			$del->delete();
			$true = $del->rowCount;
			unset($del);
			$where = array('name' => 'id_post', 'value' => $id);
			$del = New BDD();
			$del->table('TABLE_FORUM_POSTS');
			$del->where($where);
			$del->delete();
			# verifie si c'est bien supprimer
			if ($true == 1) {
				$return['msg']  = constant('DEL_POST_SUCCESS');
				$return['type'] = 'success';
			} else {
				$return['msg']  = constant('DEL_POST_ERROR');
				$return['type'] = 'error';
			}
			# return le resulat
			return $return;
		}
	}
	#####################################
	# Réponse au post
	#####################################
	public function SubmitPost($data)
	{
		if (User::getInfosUserAll($_SESSION['USER']->user->hash_key) === false) {
			$return['msg']  = constant('ERROR_LOGIN');
			$return['type'] = 'warning';
			return $return;
		}

		if (!isset($_SESSION['REPLYPOST'])) {
			$return['msg']  = constant('ERROR_ID');
			$return['type'] = 'warning';
			return $return;
		}

		if ($_SESSION['REPLYPOST'] != $data['id']) {
			$return['msg']  = constant('ERROR_ID');
			$return['type'] = 'warning';
			return $return;
		} else {
			unset($_SESSION['REPLYPOST']);
		}

		$upload = Common::Upload('file', 'forum');
		if ($upload == constant('UPLOAD_FILE_SUCCESS')) {
			$insert['attachment'] = 'uploads/forum/'.Common::FormatName($_FILES['file']['name']);
			$upload = '<br>'.$upload;
		} else if ($upload == constant('UPLOAD_NONE')) {
			$insert['attachment'] = '';
			$upload = '';
		} else {
			$insert['attachment'] = '';
			$upload = '';
		}

		$insert['content'] = Common::VarSecure($data['info_text']);
		$insert['id_post'] = (int) $data['id'];
		$insert['author']  = $_SESSION['USER']['HASH_KEY'];
		$insert['options'] = 'like=0|report=0';

		$BDD = New BDD();
		$BDD->table('TABLE_FORUM_POSTS');
		$BDD->insert($insert);

		if ($BDD->rowCount == 1) {
			self::addPlusPost($insert['id_post']);
			$return['msg']  = 'Enregistrement de la réponse en cours...'.$upload;
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('ERROR_BDD');
			$return['type'] = 'danger';
		}

		return $return;
	}
	#####################################
	# Crée un nouveau post
	#####################################
	public function SubmitThread($id, $data)
	{
		# teste si utilisateur est connecté
		if (User::isLogged($_SESSION['USER']->user->hash_key) === false) {
			$return['msg']  = constant('ERROR_LOGIN');
			$return['type'] = 'info';
			return $return;
		}
		# check ID du forum
		if ($_SESSION['NEWTHREADS'] != $id) {
			$return['msg']  = constant('ERROR_ID');
			$return['type'] = 'warning';
			return $return;
		} else {
			unset($_SESSION['NEWTHREADS']);
		}
		# les données à inserer
		$insert['id']         = NULL;
		$insert['id_threads'] = (int) $id;
		$insert['title']      = Common::MakeConstant($data['title']);
		$insert['author']     = $_SESSION['USER']['HASH_KEY'];
		$insert['options']    = 'lock=0|like=0|report=0|pin=0|view=0|post=0';
		$insert['date_post']  = date("Y-m-d H:i:s");
		$insert['attachment'] = '';
		$insert['content']    = Common::VarSecure(trim($data['content']));
		if ($insert['content'] == '') {
			$insert['content'] = 'null';
		}
		# insert en BDD
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$sql->insert($insert);
		# verifie si c'est bien inserer
		if ($sql->rowCount == 1) {
			$return['msg']  = 'Enregistrement du nouveau post en cours...';
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('ERROR_BDD');
			$return['type'] = 'error';
		}
		# return le resulat
		return $return;
	}
	#####################################
	# Ajoute un +1 au post 
	#####################################
	public function addPlusPost ($id = false) {
		if ($id && is_int($id)) {
			$get = New BDD();
			$get->table('TABLE_FORUM_POST');
			$where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$get->where($where);
			$get->queryOne();
			$data = $get->data;

			$options = Common::transformOpt($data->options);
			$options['post'] = (int) $options['post'] + 1;
			$options = Common::transformOpt($options, true);

			$update = New BDD();
			$update->table('TABLE_FORUM_POST');
			$update->where($where);
			$update->update(array('options' => $options));

		}
	}
	#####################################
	# Secutity level +1
	#####################################
	public function securityPost ($id)
	{
		$return = false;

		if ($id && is_int($id)) {
			$sqlThreads = New BDD();
			$sqlThreads->table('TABLE_FORUM_THREADS');
			$whereThreads = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$sqlThreads->where($whereThreads);
			$sqlThreads->queryOne();
			$dataThreads = $sqlThreads->data;
			if (!empty($dataThreads)) {
				$idForum  = $dataThreads->id_forum;
				$sqlForum = New BDD();
				$sqlForum->table('TABLE_FORUM');
				$whereForum = array(
					'name'  => 'id',
					'value' => (int) $idForum
				);
				$sqlForum->where($whereForum);
				$sqlForum->queryOne();
				$dataForum = $sqlForum->data;
				if (!empty($dataForum)) {
					if ($dataForum->access_groups == 0) {
						$return = true;
					} else {
						$return = explode('|', $dataForum->access_groups);
					}
				}
			}
		}

		return $return;
	}

	public function getCountPost ($id = null)
	{
		$id = (int) $id;
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POST');
		$where = array(
			'name' => 'id_threads',
			'value' => $id
		);
		$sql->where($where);
		$sql->count();
		$return = $sql->data;
		return $return;
	}

	public function nbUserForum ($hash)
	{
		$int = null;
		$secure = Common::hash_key($hash) ? true : false;
		if ($secure === true):
			$sql = New BDD();
			$sql->table('TABLE_FORUM_POST');
			$where = array(
				'name' => 'author',
				'value' => $hash
			);
			$sql->where($where);
			$sql->count();
			$return = $sql->data;
			if ($return == 0) {
				$int = 0;
			} else {
				$int = (int) $return;
			}
			$sql_count = New BDD();
			$sql_count->table('TABLE_FORUM_POSTS');
			$where = array(
				'name' => 'author',
				'value' => $hash
			);
			$sql_count->where($where);
			$sql_count->count();
			$return_count = $sql_count->data;
			if ($return_count == 0) {
				$int_count = 0;
			} else {
				$int + (int) $return_count;
			}
		endif;
		return $int;
	}
}