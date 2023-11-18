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

namespace BelCMS\Core;
use BelCMS\PDO\BDD as BDD;
use BelCMS\Requires\Common as Common;
use BelCMS\User\User as Users;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

# TABLE_INTERACTION
final class Interaction
{
	private $user,
			$type,
			$text,
			$title,
			$date;

	public function user ($hash_key = null) {
		if (Users::isLogged() === true) {
			$this->user = $_SESSION['USER']->user->hash_key;
		} else {
			$this->user = Common::GetIp();
		}
	}

	public function type ($type = null)
	{
		switch ($type) {
			case constant('INFO'):
				$type = 'infos';
			break;
			case constant('ERROR'):
				$type = 'error';
			break;
			case constant('SUCCESS'):
				$type = 'success';
			break;
			case constant('WARNING'):
				$type = 'warning';
			break;
			default:
				$type = 'infos';
			break;
		}

		$this->type = $type;
	}

	public function text ($text = null)
	{
		$this->text = Common::VarSecure($text, 'html');
	}

	public function date ()
	{
		$date = new \DateTime ('now');
		$date = $date->format('Y/m/d H:i:s');
		return $date;
	}

	public function title ($text = null)
	{
		$this->title = Common::VarSecure($text, '');
	}

	public function insert ()
	{
		/* Data */
		$insert['author'] = $this->user;
		$insert['type']   = $this->type;
		$insert['text']   = $this->text;
		$insert['date']   = self::date();
		$insert['title']  = $this->title;
		/* BDD */
		$sql = New BDD();
		$sql->table('TABLE_INTERACTION');
		$sql->insert($insert);
	}

	public static function get ()
	{
		$sql = New BDD();
		$sql->table('TABLE_INTERACTION');
		$sql->queryAll();

		return $sql->data;
	}
}