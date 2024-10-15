<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0  [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
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
			$page,
			$date;

	public function __construct($type, $title, $text)
	{
		$this->type  = self::type($type);
		$this->text  = self::text($text);
		$this->user  = self::user();
		$this->title = self::title($title);
		$this->page  = Dispatcher::name();
		self::insert();
	}

	private function user () {
		if (Users::isLogged() === true) {
			return $_SESSION['USER']->user->hash_key;
		} else {
			return Common::GetIp();
		}
	}

	public function type ($type = null)
	{
		switch ($type) {
			case 'infos':
				$return = 'infos';
			break;
			case 'error':
				$return = 'error';
			break;
			case 'success':
				$return = 'success';
			break;
			case 'warning':
				$return = 'warning';
			break;
			default:
				$return = 'infos';
			break;
		}
		return $return;
	}

	public function text ($text = null)
	{
		return Common::VarSecure($text, 'html');
	}

	public function date ()
	{
		$date = new \DateTime ('now');
		$date = $date->format('Y/m/d H:i:s');
		return $date;
	}

	public function title ($title = null)
	{
		return Common::VarSecure($title, null);
	}

	public function insert ()
	{
		/* Data */
		$insert['author'] = $this->user;
		$insert['type']   = $this->type;
		$insert['text']   = $this->text;
		$insert['date']   = self::date();
		$insert['title']  = $this->title;
		$insert['page']   = $this->page;
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