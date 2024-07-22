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
use BelCMS\Core\Secure;
use BelCMS\User\User;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
###################
# TABLE_LINKS
# TABLE_LINKS_CAT
###################
final class links
{
	public function getCat ()
	{
		$sql = New BDD;
		$sql->table('TABLE_LINKS_CAT');
		$sql->queryAll();
		foreach ($sql->data as $key => $value) {
			$sql->data[$key]->countLinks = self::getNbLLinkCount($value->id);
		}
		return $sql->data;
	}

	private function getCatName ($id = null)
	{
		if (is_int($id)) {
			$sql = New BDD;
			$sql->table('TABLE_LINKS_CAT');
			$sql->where(array('name'=> 'id', 'value' => $id));
			$sql->queryOne();
			return $sql->data;
		}
	}

	public function getNbLinks ()
	{
		$sql = New BDD;
		$sql->table('TABLE_LINKS');
		$sql->where(array('name' => 'valid', 'value' => 1));
		$sql->count();
		$return = $sql->data;
		return $return;
	}

	private function getNbLLinkCount ($id = null)
	{
		$return = 0;
		if ($id and is_int($id)) {
			$sql = New BDD;
			$sql->table('TABLE_LINKS');
			$sql->where(array('name' => 'cat', 'value' => $id));
			$sql->count();
			$return = $sql->data;
		}
		return $return;
	}

	public function getNbNewLinks ()
	{
		$sql = New BDD;
		$sql->table('TABLE_LINKS');
		$sql->where(array('name' => 'valid', 'value' => 1));
		$sql->orderby('ORDER BY `'.TABLE_LINKS.'`.`id` DESC', true);
		$sql->limit(3);
		$sql->queryAll();
		return $sql->data;
	}

	public function getNbPopular ()
	{
		$sql = New BDD;
		$sql->table('TABLE_LINKS');
		$sql->where(array('name' => 'valid', 'value' => 1));
		$sql->orderby('ORDER BY `'.TABLE_LINKS.'`.`view` DESC', true);
		$sql->limit(3);
		$sql->queryAll();
		return $sql->data;
	}

	public function sendform($data = null) {
		if ($data !== null && is_array($data)) {
			$insert['name']        = Common::VarSecure($data['name'], null);
			$insert['link']        = Secure::isUrl($data['url']);
			$insert['description'] = Common::VarSecure($data['description'], 'html');
			$insert['valid']       = 0;
			$insert['author']      = User::isLogged() ? $_SESSION['USER']->user->hash_key : Common::GetIp();

			$sql = New BDD;
			$sql->table('TABLE_LINKS');
			$sql->insert($insert);

			$return['text'] = 'Lien envoyé en base de données en attente de validation';
			$return['type'] = 'success';

			return $return;
		}
	}

	public function getLinksCat ($id = null) : array
	{
		$return = array();
		if (is_numeric($id) === true) {
			$where[] = array('name' => 'cat', 'value' => $id);
			$where[] = array('name' => 'valid', 'value' => 1);
			$sql = new BDD;
			$sql->table('TABLE_LINKS');
			$sql->where($where);
			$sql->queryAll();
			$return = $sql->data;
			foreach ($return as $key => $value) {
				$return[$key]->nameCat = self::getCatName($value->cat);
			}
		}
		return $return;
	}

	public function getView ($id = null)
	{
		$return = array();
		$id = (int) $id;
		if (is_numeric($id) === true) {
			$where[] = array('name' => 'id', 'value' => $id);
			$sql = new BDD;
			$sql->table('TABLE_LINKS');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
			$return->nameCat = self::getCatName($return->cat);
		}
		return $return;
	}
	public function visit ($id = null)
	{
		$id = (int) $id;
		if (is_numeric($id) === true) {
			$where[] = array('name' => 'id', 'value' => $id);
			$sql = new BDD;
			$sql->table('TABLE_LINKS');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
			$view['view'] = $return->view + 1;

			$update = new BDD;
			$update->table('TABLE_LINKS');
			$update->where($where);
			$update->update($view);
		}
	}

	public function getExit ($id = null)
	{
		$id = (int) $id;
		if (is_numeric($id) === true) {
			$where[] = array('name' => 'id', 'value' => $id);
			$sql = new BDD;
			$sql->table('TABLE_LINKS');
			$sql->where($where);
			$sql->queryOne();
			$return = $sql->data;
			$view['click'] = $return->click + 1;

			$update = new BDD;
			$update->table('TABLE_LINKS');
			$update->where($where);
			$update->update($view);
			return $return->link;
		}
	}
}