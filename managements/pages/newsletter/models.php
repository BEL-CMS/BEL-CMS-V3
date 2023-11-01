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
###  TABLE_NEWSLETTER
#-> id, name, email, sendmail
#	TABLE_NEWSLETTER_TPL
#-> id, name, template, author, date
#	TABLE_NEWSLETTE_SEND
#->	id, template, author, date 
final class ModelsNewsletter
{
	public function addnewtpl ($data)
	{
		if ($data !== false) {
			// SECURE DATA
			$send['name']     = Common::VarSecure($data['name'], ''); // autorise que du texte
			$send['template'] = Common::VarSecure($data['template'], 'html'); // autorise que les balises HTML
			$send['author']   = $_SESSION['USER']['HASH_KEY'];
			// SQL INSERT
			$sql = New BDD();
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->insert($send);
			$sql->insert();
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_TEMPLATE_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_TEMPLATE_ERROR
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

	public function getAllNewser ()
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_NEWSLETTER');
		$sql->queryAll();

		if ($sql->data) {
			$return = $sql->data;
		}

		return $return;	
	}

	public function getAllTpl ()
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_NEWSLETTER_TPL');
		$sql->queryAll();

		if ($sql->data) {
			$return = $sql->data;
		}

		return $return;
	}

	public function getTpl ($id)
	{
		$id     = (int) $id;
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_NEWSLETTER_TPL');
		$where = array('name' => 'id', 'value' => $id );
		$sql->where($where);
		$sql->queryOne();

		if ($sql->data) {
			$return = $sql->data;
		}

		return $return;
	}

	public function sendEdit ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$edit['name']     = Common::VarSecure($data['name'], ''); // autorise que du texte
			$edit['template'] = Common::VarSecure($data['template'], 'html'); // autorise que les balises HTML
			$send['author']   = $_SESSION['USER']['HASH_KEY'];
			// SQL UPDATE
			$sql = New BDD();
			$sql->table('TABLE_NEWSLETTER_TPL');
			$id = Common::SecureRequest($data['id']);
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->insert($edit);
			$sql->update();
			// SQL RETURN NB UPDATE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_TEMPLATE_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_TEMPLATE_ERROR
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

	public function deletetpl ($data = false)
	{
		if ($data !== false) {
			// SECURE DATA
			$delete = (int) $data;
			// SQL DELETE
			$sql = New BDD();
			$sql->table('TABLE_NEWSLETTER_TPL');
			$sql->where(array('name'=>'id','value' => $delete));
			$sql->delete();
			// SQL RETURN NB DELETE
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => DEL_TEMPLATE_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => DEL_TEMPLATE_ERROR
				);
			}
		} else {
			$return = array(
				'type' => 'error',
				'text' => ERROR_NO_DATA
			);
		}
		return $return;
	}

}