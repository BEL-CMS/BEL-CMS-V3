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
use BelCMS\Core\Dispatcher;
use BelCMS\PDO\BDD;
use BelCMS\User\User;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Games
{
	public function GetGames ($where = false)
	{
		$config = Config::GetConfigPage('games');
		if (isset($config->config['MAX_GAMING_PAGE'])) {
			$nbpp = (int) $config->config['MAX_GAMING_PAGE'];
		} else {
			$nbpp = (int) 4;
		}

		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

		$return = (object) array();

		$sql = New BDD();
		$sql->table('TABLE_PAGES_GAMES');
		$sql->orderby(array(array('name' => 'name', 'type' => 'ASC')));
        $sql->isObject(false);
		$sql->limit(array(0 => $page, 1 => $nbpp), true);
		$sql->queryAll();
		$returnGames = $sql->data;
        if (!empty($returnGames)) {
            foreach ($returnGames as $k => $v) {
                $getUser = New BDD();
                $getUser->where(array(
                    'name'  => 'name_game',
                    'value' => $v['id']
                ));
                $getUser->table('TABLE_USERS_GAMING');
                $getUser->isObject(false);
                $getUser->queryAll();
                if ($getUser->rowCount == false) {
                    $returnGames[$k]['users'] = (object) array();
                } else {
                    $returnGames[$k]['users'] = (object) $getUser->data;
                    foreach ($returnGames[$k]['users'] as $key => $value) {
                        $returnGames[$k]['users']->$key = (object) $value;
                    }
                }
            }
        } else {
            $returnGames = array();
        }
        foreach ($returnGames as $key => $name) {
            $return->$key = (object) $name;
        }
		unset($sql,$getUser);
		return $return;
	}
}
