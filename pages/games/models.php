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
                $getUser->table('TABLE_USERS_GAMING');
                $getUser->isObject(false);
                $getUser->queryAll();
                $getData = $getUser->data;

                if (!empty($getData)) {
                    $userData = $getData;
                }

                foreach ($returnGames as $keyGame => $valueGame) {
                    $valueGame['id'] = (int) $valueGame['id'];
                    $return->$keyGame = (object) $valueGame;
                    foreach ($userData as $key => $value) {
                        if (strlen($value['name_game'] == 1)) {
                            if ($valueGame['id'] == $value['name_game']) {
                                $return->keyGame->user[] = (object) $value;
                            }
                        } else {
                            $ex = explode('|', $value['name_game']);
                            if (in_array($valueGame['id'], $ex)) {
                                $return->$keyGame->user[] = (object) $value;
                            }
                        }
                    }
                }
            }
        } else {
            $return = array();
        }
		unset($sql,$getUser);
		return $return;
	}
}
