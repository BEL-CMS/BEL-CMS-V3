<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.3 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

namespace BelCMS\Core;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\Secure;
use GetHost;

if (!defined('CHECK_INDEX')) {
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
}

final class Ban
{
	var     $currentDate,
			$countDate,
			$fuseau;
	private $username,
			$email,
			$hash_key,
			$groups,
			$ipUser,
			$gold;
	private $author,
			$ipBan,
			$date,
			$endban,
			$timeban,
			$reason;
	private $_initBan,
			$ip,
			$render;
	#####################################
	# Infos tables
	#####################################
	# TABLE_BAN - TABLE_USERS
	#####################################
	#########################################
	# Constructeur
	#########################################
	function __construct()
	{
		$this->currentDate = new \DateTimeImmutable ('now');
		$this->fuseau = defined('CMS_FUSEAU') ? constant('CMS_FUSEAU') : 2;
		self::checkChangeIP ();
		self::getUserInfo ();
		self::render ();
	}
	#########################################
	# Check BAN return true or false
	#########################################
	public function positive ()
	{
		// liste le bannissement / return true or false
		if (self::getBan() === true) {
			// Vérifie l'IP ou l'auteur, si elle correspond à un des bannissements
			if (Common::GetIp() == $this->ipBan or $this->author == $_SESSION['USER']->user->hash_key)
			{
				$ban  = new \DateTimeImmutable($this->endban);
				$this->countDate = $ban->format('Y/m/d H:i:s');
				$diff = $this->currentDate->diff($ban);
				if ($diff->invert == 0) { 
					return (bool) true;
				} else {
					return (bool) false;
				}
			} else {
				return (bool) false;
			}
		} else {
			return (bool) false;
		}
	}
	#########################################
	# return les infos du ban
	#########################################
	private function getBan () : bool
	{
		$return = false;
		$author = self::isLogged() === true ? $_SESSION['USER']->user->hash_key : false;

		$sql = New BDD;
		$sql->table('TABLE_BAN');
		$where = 'WHERE 1 AND `number` >= 4 AND `ip` = "'.Common::GetIp().'" OR `author` = "'.$author.'"';
		$sql->where ($where);
		$sql->queryOne();

		if ($sql->rowCount == 0) {
			$return = false;
		} else {
			$ban = $sql->data;
			$this->author  = $ban->author;
			$this->ipBan   = $ban->ip;
			$this->date    = $ban->date;
			$this->endban  = $ban->endban;
			$this->timeban = $ban->timeban;
			$this->reason  = $ban->reason;

			$return = true;
		}

		return $return;
	}
	#########################################
	# Check in change IP
	#########################################
	private function checkChangeIP ($ip = null)
	{
		if (self::getBan() !== false) {
			if ($this->ipUser != Common::GetIp()) {
				self::changeIP ($this->ipUser);
			}
		}
	}
	#########################################
	# update IP in TABLE_USERS
	#########################################
	private function changeIP ($ip = null)
	{
		if (Secure::isIp($ip)) {
			$sql = New BDD;
			$sql->table ('TABLE_USERS');
			$sql->where ('WHERE 1 AND `ip` = "'.$this->ipBan.'"');
			$sql->update (array('ip' => $ip));
		}
	}
	#########################################
	# Get Infos User if logged
	#########################################
	private function getUserInfo ()
	{
		if (self::isLogged() === true) {
			$user = User::getInfosUserAll($_SESSION['USER']->user->hash_key);
			if ($user !== false) {
				$this->username = $user->user->username;
				$this->email    = $user->user->mail;
				$this->hash_key = $user->user->hash_key;
				$this->groups   = $user->groups->all_groups;
				$this->ipUser   = $user->user->ip;
				$this->gold     = $user->user->gold;
			}
		} else {
			$this->ip = Common::GetIp ();
		}
	}
	#########################################
	# Check is logged
	#########################################
	private function isLogged ()
	{
		if (User::isLogged () and User::ifUserExist ($_SESSION['USER']->user->hash_key)) {
			return (bool) true;
		} else {
			return (bool) false;
		}
	}
	#########################################
	# Return of rendering
	#########################################
	private function render ()
	{
		$render = null;
		$positive = self::positive();
		if ($positive === true) {
			ob_start();
			require_once ROOT.DS.'ban'.DS.'tpl'.DS.'index.php';
			$render = ob_get_contents();
			if (ob_get_length() != 0) {
				ob_end_clean();
			}
			echo $render;
			die();
		}
	}
	#########################################
	# add ban
	#########################################
	public static function addBan ($author = null,$ip = null, $email = null, $endban = null, $timeban = null, $reason = null)
	{
		$dateNow = new \DateTimeImmutable('now');
		switch ($endban) {
			case 'PT1M':
				$insert['timeban'] = 'PT1M';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT1M'));
			break;

			case 'PT5M':
				$insert['timeban'] = 'PT5M';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT5M'));
			break;

			case 'PT10M':
				$insert['timeban'] = 'PT10M';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT10M'));
			break;

			case 'PT15M':
				$insert['timeban'] = 'PT15M';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT15M'));
			break;

			case 'PT30M':
				$insert['timeban'] = 'PT30M';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT30M'));
			break;

			case 'PT1H':
				$insert['timeban'] = 'PT1H';
				$insert['endban']  = $dateNow->add(new \DateInterval('PT1H'));
			break;
			
			case 'P1D':
				$insert['timeban'] = 'P1D';
				$insert['endban']  = $dateNow->add(new \DateInterval('P1D'));
			break;

			case 'P99Y':
				$insert['timeban'] = 'P99Y';
				$insert['endban']  = $dateNow->add(new \DateInterval('P99Y'));
			break;
		}

		$currentDate  =  new \DateTimeImmutable('now');
		$currentDate  = $currentDate->format('Y-m-d H:i:s');
		$insert['endban']   = $insert['endban']->format('Y-m-d H:i:s');
		$insert['who']      = $_SESSION['USER']->user->hash_key;
		$insert['author']   = empty($author) ? $_SESSION['USER']->user->hash_key : $author;
		$insert['ip']       = empty($ip) ? Common::GetIp() : Secure::isIp($ip);
		$insert['email']    = $email;
		$insert['date']     = $currentDate;
		$insert['reason']   = empty($reason) ? constant('Vous avez ete banni') : $reason;

		$sql = New BDD;
		$sql->table('TABLE_BAN');
		$sql->insert($insert);
	}
}