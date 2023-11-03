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

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsArticles
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_PAGES_ARTICLES
	#####################################
	public function getAllArticles ()
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_PAGES_ARTICLES');
		$sql->queryAll();

		if ($sql->data) {
			$return = $sql->data;
		}

		return $return;
	}

	public function getArticles ($id = false)
	{
		$sql = New BDD();
		$sql->table('TABLE_PAGES_ARTICLES');

		if ($id) {
			$request = Common::secureRequest($id);
			if (is_numeric($id)) {
				$sql->where(array(
					'name'  => 'id',
					'value' => $request
				));
			} else {
				$sql->where(array(
					'name'  => 'rewrite_name',
					'value' => $request
				));
			}
			$sql->queryOne();
			if (!empty($sql->data)) {
				$sql->data->link = 'article/readmore/'.$sql->data->rewrite_name.'?id='.$sql->data->id;
				if (empty($sql->data->tags)) {
					$sql->data->tags = array();
				} else {
					$sql->data->tags = explode(',', $sql->data->tags);
				}
				$author =  User::getInfosUserAll($sql->data->author);
				if ($author == false) {
					$sql->data->username = constant('MEMBER_DELETE');
					$sql->data->avatar   = constant('DEFAULT_AVATAR');
				} else {
					$sql->data->username = $author->user->username;
					$sql->data->avatar   = $author->profils->avatar;					
				}
			} else {
				$sql->data = null;
			}
		}
		return $sql->data;
	}

	public function sendEdit ($data = false)
	{
		if ($data !== false) {
			if (empty($data['name'])) {
				$return = array(
					'type' => 'error',
					'text' => constant('ADD_BLOG_EMPTY')
				);
				return $return;
			}
			if (empty($data['content'])) {
				$return = array(
					'type' => 'error',
					'text' => constant('ADD_BLOG_EMPTY_CONTENT')
				);
				return $return;
			}
			// SECURE DATA
			$edit['rewrite_name']      = Common::MakeConstant($data['name']);
			$edit['name']              = Common::VarSecure($data['name'], ''); // autorise que du texte
			$edit['content']           = Common::VarSecure($data['content'], 'html'); // autorise que les balises HTML
			$edit['additionalcontent'] = Common::VarSecure($data['additionalcontent'], 'html'); // autorise que les balises HTML
			$edit['author']            = strlen($data['author']) == 32 ? $data['author'] : $_SESSION['USER']->user->hash_key;
			$edit['authoredit']        = $_SESSION['USER']->user->hash_key;
			$edit['tags']              = Common::VarSecure($data['tags'], ''); // autorise que du texte
			$edit['tags']              = str_replace(' ', '', $edit['tags']);
			$edit['cat']               = ''; // à implanter
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_ARTICLES');
			$id = Common::SecureRequest($data['id']);
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->update($edit);
			// SQL RETURN NB UPDATE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => EDIT_BLOG_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => EDIT_BLOG_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => ERROR_NO_DATA
			);
		}

		return $return;
	}

	public function sendEditPost ($d)
	{
		$data['info_text'] = Common::VarSecure($d['info_text']);
		$update = New BDD();
		$update->table('TABLE_FORUM_POSTS');
		$where = array(
			'name'  => 'id',
			'value' => Common::SecureRequest($d['id'])
		);
		$update->where($where);
		$options = $data['info_text'];
		$update->update(array('content' => $options));
		if ($update->rowCount == 1) {
			$return['msg']  = EDIT_SUCCESS;
			$return['type'] = 'success';
		} else {
			$return['msg']  = EDIT_FALSE;
			$return['type'] = 'error';
		}
		return $return;	
	}

	public function sendnew ($data = false)
	{
		if (empty($data['name'])) {
			$return = array(
				'type' => 'error',
				'text' => ADD_BLOG_EMPTY
			);
			return $return;
		}
		if (empty($data['content'])) {
			$return = array(
				'type' => 'error',
				'text' => ADD_BLOG_EMPTY_CONTENT
			);
			return $return;
		}
		if ($data !== false) {
			// SECURE DATA
			$send['rewrite_name']      = Common::MakeConstant($data['name']);
			$send['name']              = Common::VarSecure($data['name'], ''); // autorise que du texte
			$send['content']           = Common::VarSecure($data['content'], 'html'); // autorise que les balises HTML
			$send['additionalcontent'] = Common::VarSecure($data['additionalcontent'], 'html'); // autorise que les balises HTML
			$send['author']            = $_SESSION['USER']->user->hash_key;
			$send['authoredit']        = null;
			$send['tags']              = Common::VarSecure($data['tags'], ''); // autorise que du texte
			$send['tags']              = str_replace(' ', '', $send['tags']);
			$send['cat']               = ''; // à implanter
			$send['view']              = 0;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_PAGES_ARTICLES');
			$sql->insert($send);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_BLOG_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_BLOG_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => ERROR_NO_DATA
			);
		}

		return $return;
	}

	public function getNbArticles ()
	{
		$return = 0;

		$sql = New BDD();
		$sql->table('TABLE_PAGES_ARTICLES');
		$sql->count();

		if (!empty($sql->data)) {
			$return = $sql->data;
		}

		return $return;
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['MAX_ARTICLES'] = (int) $data['MAX_ARTICLES'];
			$opt                  = array('MAX_ARTICLES' => $data['MAX_ARTICLES']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'articles'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_BLOG_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_BLOG_PARAM_ERROR')
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

	public function delete ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_ARTICLES');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_BLOG_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('DEL_BLOG_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}
}