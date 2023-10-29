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
#->  id, name, email, sendmail
final class ModelsNewsletter
{
	public function getuUersList ()
	{
		$return = array();

		$sql = New BDD;
		$sql->table('TABLE_NEWSLETTER');
		$sql->orderby(array(array('name' => 'name', 'type' => 'DESC')));
		$sql->queryAll();
		$return = $sql->data;
		unset($sql);

		return $return;		
	}

	public function sendNew ($data)
	{
		$return = array();

		$send['name']     = $_SESSION['USER']['HASH_KEY'];
		$send['email']    = Secure::isMail($data['email']);
		$send['sendmail'] = 0;

		$get = New BDD;
		$get->table('TABLE_NEWSLETTER');
		$where = array(
			'name'  => 'email',
			'value' => $send['email']
		);
		$get->where($where);
		$get->queryAll();
		$get = $get->data;

		if (empty($get)){
			$sql = New BDD;
			$sql->table('TABLE_NEWSLETTER');
			$sql->insert($send);
			// SQL RETURN NB INSERT
			if ($sql->rowCount == 1) {
				$return = array(
					'type' => 'success',
					'text' => SEND_NEWSLETTER_SUCCESS
				);
			} else {
				$return = array(
					'type' => 'warning',
					'text' => SEND_NEWSLETTER_ERROR
				);
			}			
		} else {
			$return = array(
				'type' => 'warning',
				'text' => SEND_EXIST_USER_ERROR
			);
		}

		return $return;
	}
}