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
use BelCMS\PDO\BDD as BDD;
use BelCMS\Core\Secures;
use BelCMS\Requires\Common as Common;
use BelCMS\Core\Dispatcher;
use BelCMS\Core\Config;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Gallery
{
    public function getImg ($id = null)
    {
		$sql = New BDD();
		$sql->table('TABLE_GALLERY');
		if ($id === null) {
            $sql->where(array('name' => 'cat', 'value' => 0));
			$sql->queryAll();
			if (!empty($sql->data)) {
				$data = $sql->data;
				foreach ($data as $key => $value) {
					if (!empty($value->cat)) {
						$data[$key]->cat = self::getCat($value->cat)->name;
					}
				}
				return $data;
			}
		} else if (is_integer($id)) {
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			if (!empty($sql->data)) {
				$data = $sql->data;
			}
			return $data;
		}
    }

	public function getCat ($id = null)
	{
		$sql = New BDD();
		$sql->table('TABLE_GALLERY_CAT');

		if ($id !== null) {
			$where = array(
				'name' => 'id',
				'value' => $id
			);
			$sql->where($where);
			$sql->queryOne();
			if (!empty($sql->data)){
				return $sql->data;
			}
		} elseif ($id == null) {
			$sql->queryAll();
			return $sql->data;
		}
	}

    public function getImgCat ($id = null)
    {
		$config = Config::GetConfigPage('gallery');
		if (isset($config->config['MAX_IMG'])) {
			$nbpp = (int) $config->config['MAX_IMG'];
		} else {
			$nbpp = (int) 6;
		}

		$page = (Dispatcher::RequestPages() * $nbpp) - $nbpp;

        if (is_numeric($id)) {
            $sql = New BDD();
            $sql->table('TABLE_GALLERY');
            $sql->where(array('name' => 'cat', 'value' => $id));
			$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
			$sql->limit(array(0 => $page, 1 => $nbpp), true);
            $sql->queryAll();
            if (!empty($sql->data)) {
                $data = $sql->data;
                foreach ($data as $key => $value) {
                    if (!empty($value->cat)) {
                        $data[$key]->cat = self::getCat($value->cat)->name;
                    }
                }
                return $data;
            }

        }
    }
}