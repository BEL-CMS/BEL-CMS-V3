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

use BelCMS\Config\Config;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsThemes
{
	public function getTpl ()
	{
		$return = Common::ScanDirectory(constant('DIR_TPL'));
		return $return;
	}

	public function getTplActive ()
	{
		$sql = New BDD();
		$sql->table('TABLE_CONFIG');
		$sql->where(array('name'=>'name','value'=> 'CMS_TPL_WEBSITE'));
		$sql->queryOne();
		if ($sql->rowCount == 0) {
			$return = 'default';
		} else {
			$return = $sql->data;
		}
		return $return;
	}

	public function getTplImg ()
	{
		$scan = Common::ScanDirectory(constant('DIR_TPL'));

		if (count($scan) !== 0):
			foreach ($scan as $k => $n):
				if (is_file('templates'.DS.$n.DS.'screen.png')):
					$return[$n] = 'templates'.DS.$n.DS.'screen.png';
				else:
					$return[$n] = 'assets'.DS.'img'.DS.'no_screen.png';
				endif;
			endforeach;
		else:
			$return = null;
		endif;

		return $return;		
	}

	public function getInfos ($n = null)
	{
		$file = constant('DIR_TPL').$n.DS.'infos.php';
		if (is_file($file)):
			require_once $file;
			return $description;
		endif;
	}

	public function sendTpl ($data)
	{
		$sql = New BDD;
		$sql->table('TABLE_CONFIG');
		$sql->where(array('name'=>'name','value'=>'CMS_TPL_WEBSITE'));
		$sql->update(array('value' => $data));
		$return = array('type' => 'success', 'text' => 'le Theme principale a été changé', 'title' => 'Templates');

		new Config;

		return $return;
	}

	public function sendPages ()
	{
		if (isset($_POST['full'])) {
			$data = implode(',', $_POST['full']);
		} else {
			$data = null;
		}
		$sql = New BDD;
		$sql->table('TABLE_CONFIG');
		$sql->where(array('name'=>'name','value'=> 'CMS_TPL_FULL'));
		$sql->update(array('value' => $data));
		$return = array('type' => 'success', 'text' => 'les templates en full ont été changer', 'title' => 'Templates');
		return $return;
	}

	public function listPages ()
	{
		$return = Common::ScanDirectory(constant('DIR_PAGES'));
		return $return;
	}

	public function searchPages ()
	{
		$sql = New BDD;
		$sql->table('TABLE_CONFIG');
		$sql->where(array('name'=>'name','value'=> 'CMS_TPL_FULL'));
		$sql->queryOne();
		$data = $sql->data;
		$return = explode(',', $data->value);
		return $return;
	}

	public function sendPrimayPage ($data)
	{
		if (isset($data['landing']) and $data['landing'] == '1') {
			$update['value'] = 'landing';
		} else {
			$update['value'] = Common::VarSecure($data['page']);
		}
		$sql = New BDD;
		$sql->table('TABLE_CONFIG');
		$sql->where(array('name'=>'name','value'=> 'CMS_DEFAULT_PAGE'));
		$sql->update($update);
		if ($sql->rowCount == true) {
			if ($update['value'] == 'landing') {
				$return = array('type' => 'success', 'text' => constant('ACTIVE_LANDIN_PAGE'), 'title' => 'Templates');
			} else {
				$return = array('type' => 'success', 'text' => constant('DEFAULT_PAGE_SAVED'), 'title' => 'Templates');
			}
		} else {
			$return = array('type' => 'error', 'text' => constant('EDIT_PARAM_ERROR'), 'title' => 'Templates');
		}
		return $return;
	}
}