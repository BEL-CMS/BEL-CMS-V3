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

use BelCMS\Core\Config;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsForum
{
	public function GetThreads($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM_THREADS');
		if ($id === null) {
			$sql->orderby(array(array('name' => 'id_forum', 'type' => 'ASC')));
			$sql->queryAll();
			$return = $sql->data;
			foreach ($return as $k => $v) {
				$return[$k]->id_forum = self::GetForum($v->id_forum);
				$return[$k]->options  = Common::transformOpt($v->options);
			}
		} else {
			$tmp_where[] = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$sql->where($tmp_where);
			$sql->queryOne();
			$return = $sql->data;
			$return->options  = Common::transformOpt($return->options);
			$return->id_forum = self::GetForum($return->id_forum);
		}
		return $return;
	}

	public function GetForum ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		if ($id === null) {
			$sql->orderby(array(array('name' => 'title', 'type' => 'ASC')));
			$sql->queryAll();
		} else {
			$tmp_where = array(
				'name'  => 'id',
				'value' => (int) $id
			);
			$sql->where($tmp_where);
			$sql->queryOne();
			if ($sql->data) {
				$sql->data->access_groups = explode('|', $sql->data->access_groups);
				$sql->data->access_admin  = explode('|', $sql->data->access_admin);
			}
		}
		$return = $sql->data;
		return $return;
	}

	public function isCat ($data)
	{
		$return = true;

		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		$sql->queryAll();

		foreach ($sql->data as $k => $v) {
			if ($data == $v->title) {
				$return = false;
				break;
			}
		}

		return $return;
	}

	public function sendAddForum ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$insert['title']    = Common::VarSecure($data['title'], '');
			$insert['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$insert['orderby']  = (int) $data['orderby'];
			$insert['icon']     = Common::VarSecure($data['icon'], '');
			$insert['id_forum'] = (int) $data['id_forum'];
			$insert['options']  = 'lock==0';
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_FORUM_THREADS');
			$sql->insert($insert);
			$sql->insert();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('NEW_THREADS_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => constant('NEW_THREADS_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}

	public function sendEditForum ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$id               = (int) $data['id'];
			$edit['title']    = Common::VarSecure($data['title'], '');
			$edit['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$edit['orderby']  = (int) $data['orderby'];
			$edit['icon']     = Common::VarSecure($data['icon'], '');
			$edit['id_forum'] = (int) $data['id_forum'];
			$data['lock']     = (isset($data['lock']) && $data['lock'] ==1) ? 1 : 0;
			$opt              = array('lock' => $data['lock']);
			$edit['options']  = Common::transformOpt($opt, true);

			if (empty($edit['title'])) {
				$return = array(
					'type' => 'success',
					'text' => constant('ERROR_TITLE_EMPTY')
				);
			} else {
				// SQL EDIT
				$where = array('name' => 'id','value' => $id);
				$sql = New BDD();
				$sql->table('TABLE_FORUM_THREADS');
				$sql->where($where);
				$sql->update($edit);
				// SQL RETURN NB INSERT
				if ($sql->rowCount == 1) {
					$return = array(
						'type' => 'success',
						'text' => constant('EDIT_THREADS_SUCCESS')
					);
				} else {
					$return = array(
						'type' => 'alert',
						'text' => constant('EDIT_THREADS_ERROR')
					);
				}
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}

	public function delThreads ($id = false)
	{
		if ($id !== false) {
			// Secure ID
			$id = (int) $id;
			// SQL DELETE
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM_THREADS');
			$sql->where($where);
			$sql->delete();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_THREADS_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => constant('DEL_THREADS_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_ID_EMPTY_INT')
			);
		}
		return $return;
	}

	public function sendAddCat ($data = false)
	{
		if ($data !== false && is_array($data)) {
			// SECURE DATA
			$insert['title']    = Common::VarSecure($data['title'], '');
			$insert['subtitle'] = Common::VarSecure($data['subtitle'], '');
			$insert['orderby']  = (int) $data['orderby'];
			$insert['activate'] = (int) $data['activate'];
			$insert['access_groups'] = isset($data['access_groups']) ? implode('|', $data['access_groups']) : 1;
			$insert['access_admin']  = isset($data['access_admin']) ? implode('|', $data['access_admin']) : 1;
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->insert($insert);
			$sql->insert();
			// SQL RETURN NB INSERT 
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('NEW_CAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => constant('NEW_CAT_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_NO_DATA')
			);
		}
		return $return;
	}

	public function delCat ($id = false)
	{
		if ($id !== false) {
			// Secure ID
			$id = (int) $id;
			// SQL DELETE
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->where($where);
			$sql->delete();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('DEL_CAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => constant('DEL_CAT_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_ID_EMPTY_INT')
			);
		}
		return $return;
	}

	public function SendEditCat ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$id                    = (int) $data['id'];
			$edit['title']         = Common::VarSecure($data['title'], '');
			$edit['subtitle']      = Common::VarSecure($data['subtitle'], '');
			$edit['access_admin']  = implode('|', $data['access_admin']);
			$edit['access_groups'] = implode('|', $data['access_groups']);
			$edit['activate']      = isset($data['activate']) ? $data['activate'] : 0;
			$edit['orderby']       = (int) $data['orderby'];
			// SQL EDIT
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM');
			$sql->where($where);
			$sql->update($edit);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_CAT_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_CAT_ERROR')
				);
			}
		} else {
			$return = array(
				'type' => 'warning',
				'text' => constant('ERROR_ID_EMPTY_INT')
			);
		}
		return $return;
	}

	public function SecureCat($id)
	{
		$userGroups = $_SESSION['USER']->groups->all_groups;
		if (in_array(1, $userGroups)) {
			return true;
		}
		$return = false;
		$sql = New BDD();
		$sql->table('TABLE_FORUM');
		$sql->where(array('name' => 'id', 'value' => (int) $id));
		$sql->queryOne();
		if ($sql->data) {
			$sql->data->access_admin  = explode('|', $sql->data->access_admin);
			$myGroup = $_SESSION['USER']->groups->all_groups;
			foreach ($sql->data->access_admin as $k => $v) {
				if (in_array($v, $myGroup)) {
					return true;
					break;
				}
			}
		}
		return $return;
	}

	public function GettAllPosts()
	{
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POSTS');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->queryAll();
		$return = $sql->data;
		foreach ($return as $key => $value) {
			$return[$key]->options = Common::transformOpt($value->options);
		}
		return $return;
	}

	public function GetEditPost ($id)
	{
		$id  = Common::SecureRequest($id);
		$sql = New BDD();
		$sql->table('TABLE_FORUM_POSTS');
		$sql->where(array('name' => 'id', 'value' => $id));
		$sql->queryOne();
		$return = $sql->data;
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
		$update->insert(array('content' => $options));
		$update->update();
		if ($update->rowCount == 1) {
			$return['msg']  = constant('EDIT_SUCCESS');
			$return['type'] = 'success';
		} else {
			$return['msg']  = constant('EDIT_FALSE');
			$return['type'] = 'error';
		}
		return $return;	
	}

	public function sendDelPost ($id)
	{
		if ($id !== false) {
			// Secure ID
			$id = (int) $id;
			// SQL DELETE
			$where = array('name' => 'id','value' => $id);
			$sql = New BDD();
			$sql->table('TABLE_FORUM_POSTS');
			$sql->where($where);
			$sql->delete();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('SUPP_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'alert',
					'text' => constant('SUPP_FALSE')
				);
			}
		} else {
			$return = array(
				'type' => 'alert',
				'text' => constant('ERROR_ID_EMPTY_INT')
			);
		}
		return $return;
	}

	public function sendparameter($data = null)
	{
		if ($data !== false) {
			$data['NB_MSG_FORUM'] = (int) $data['NB_MSG_FORUM'];
			$opt = array('NB_MSG_FORUM' => $data['NB_MSG_FORUM']);
			$data['admin']        = isset($data['admin']) ? $data['admin'] : array(1);
			$data['groups']       = isset($data['groups']) ? $data['groups'] : array(1);
			$upd['config']        = Common::transformOpt($opt, true);
			$upd['active']        = isset($data['active']) ? 1 : 0;
			$upd['access_admin']  = implode("|", $data['admin']);
			$upd['access_groups'] = implode("|", $data['groups']);
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_PAGES_CONFIG');
			$sql->where(array('name' => 'name', 'value' => 'forum'));
			$sql->update($upd);
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => constant('EDIT_FORUM_PARAM_SUCCESS')
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => constant('EDIT_FORUM_PARAM_ERROR')
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