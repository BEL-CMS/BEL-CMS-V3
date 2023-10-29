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
use BelCMS\Core\Dispatcher as Dispatcher;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class Visitors
{
    public  $json;
	private $visitorHour,
			$visitorMinute,
			$visitorDay,
			$visitorMonth,
			$visitorYear,
			$visitorBrowser,
			$visitorRefferer,
			$visitedPage,
			$visitedUser,
			$return;

	function __construct ($json = null)
	{
		# json {Android}
		if (!empty($json)) {
			$this->visitorBrowser  = constant('MOBILE');
		} else {
			$this->visitorBrowser  = self::getBrowserType()->name;
		}
		# Var
		$this->visitorHour     = date('G');
		$this->visitorMinute   = date('i');
		$this->visitorDay      = date('d');
		$this->visitorMonth    = date('m');
		$this->visitorYear     = date('Y');
		$this->visitorRefferer = gethostbyname(Common::GetIp());
		$this->visitedPage     = Dispatcher::page();
		if (!empty($json)) {
			$this->visitedUser = $json->hash_key;
		} else {
			if (Users::isLogged() === true) {
				$this->visitedUser = $_SESSION['USER']->user->hash_key;
			} else {
				if (preg_match('/([bB]ot|[sS]pider|[yY]ahoo|[gG]oggle)/i', $_SERVER["HTTP_USER_AGENT"] )) {
					$this->visitedUser = $_SERVER["HTTP_USER_AGENT"];
				} else {
					$this->visitedUser = Users::isLogged() === true ? $_SESSION['USER']->user->hash_key : constant('VISITOR');
				}
			}
		}
		# data insert
		$this->insertBdd();
	}

	private function insertBdd () {
		# Where datetime - 5min
		$where[] = array(
			'name' => 'visitor_ip',
			'value'=> Common::GetIp()
		);
		$where[] = array(
			'name' => 'visitor_day',
			'value'=> $this->visitorDay
		);
		$where[] = array(
			'name' => 'visitor_month',
			'value'=> $this->visitorMonth
		);
		$where[] = array(
			'name' => 'visitor_year',
			'value'=> $this->visitorYear
		);
		# table count <1
		$sql = New BDD;
		$sql->table('TABLE_VISITORS');
		$sql->where($where);
		$sql->queryAll();
		$return = $sql->rowCount;
		unset($sql);
		# Mise à jour
		if ($return == 0) {
			# data insert
			$insert['visitor_ip']       = Common::GetIp();
			$insert['visitor_user']     = $this->visitedUser;
			$insert['visitor_browser']  = $this->visitorBrowser;
			$insert['visitor_hour']     = $this->visitorHour;
			$insert['visitor_minute']   = $this->visitorMinute;
			$insert['visitor_date']     = date("Y-m-d H:i:s");
			$insert['visitor_day']      = $this->visitorDay;
			$insert['visitor_month']    = $this->visitorMonth;
			$insert['visitor_year']     = $this->visitorYear;
			$insert['visitor_refferer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			$insert['visitor_page']     = $this->visitedPage;
			# SQL Insert
			$sql = New BDD;
			$sql->table('TABLE_VISITORS');
			$sql->insert($insert);
		} else {
			$where[] = array(
				'name'  => 'visitor_ip',
				'value' => Common::GetIp()
			);
			$where[] = array(
				'name' => 'visitor_day',
				'value'=> date('d')
			);
			$where[] = array(
				'name' => 'visitor_month',
				'value'=> date('m')
			);
			$where[] = array(
				'name' => 'visitor_year',
				'value'=> date('Y')
			);
			$update['visitor_user']   = $this->visitedUser;
			$update['visitor_hour']   = $this->visitorHour;
			$update['visitor_hour']   = $this->visitorHour;
			$update['visitor_minute'] = $this->visitorMinute;
			$update['visitor_page']   = $this->visitedPage;
			$update['visitor_date']   = date("Y-m-d H:i:s");
			# SQL Update
			$sql = new BDD;
			$sql->table('TABLE_VISITORS');
			$sql->where($where);
			$sql->update($update);
		}
	}

	public static function getVisitorDay () {
		$sql = new BDD;
		$sql->table('TABLE_VISITORS');
		$sql->where(array(
			'name'  => 'visitor_day',
			'value' => date('d'),
			'op'    => ' = '
		));
		$sql->queryAll();
		$data   = $sql->data;
		$count  = count($sql->data);

		$return = (object) array(
			'data'  => $data,
			'count' => $count
		);

		return $return;
	}

	public static function getVisitorConnected () {
		# connected current time < -5min
		$sql = New BDD;
		$sql->table('TABLE_VISITORS');
		$sql->where(array(
			'name'  => 'visitor_date',
			'value' => date('Y-m-d H:i:s', strtotime('-5 min')),
			'op'    => ' >= '
		));
		$sql->queryAll();
		$data   = $sql->data;
		$count  = count($sql->data);

		$return = (object) array(
			'data'  => $data,
			'count' => $count
		);

		return $return;
	}

	public static function getVisitorYesterday () {
		# connected current time < - 1 day
		$visitor_last = date('d', strtotime('-1 days'));

		$sql = New BDD;
		$sql->table('TABLE_VISITORS');
		$sql->where(array(
			'name'  => 'visitor_day',
			'value' => $visitor_last
		));
		$sql->queryAll();
		$data   = $sql->data;
		$count  = count($sql->data);

		$return = (object) array(
			'data'  => $data,
			'count' => $count
		);

		return $return;
	}

	private function selfURL () {
		if (empty($_SERVER["HTTPS"])) {
			$s = '';
		} else if ($_SERVER["HTTPS"] == "on") {
			$s = 's';
		}
		$protocol = self::strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
		return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}

	private function strleft ($s1, $s2)
	{
		return substr($s1, 0, strpos($s1, $s2));
	}

	private function getBrowserType ()
	{
		$u_agent  = $_SERVER['HTTP_USER_AGENT'];
		$bname    = 'Unknown';
		$platform = 'Unknown';
		$version  = '';

		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} else if (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} else if (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} else if(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} else if(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} else if(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		} else if(preg_match('/Opera/i',$u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		}
		else if(preg_match('/Netscape/i',$u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		} else {
			$bname = 'Inconnu';
			$ub = "Inconnu";
		}

		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) { }

	   	if ($bname != 'Inconnu') {
			$i = count($matches['browser']);
			if ($i != 1) {
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)) {
					$version = $matches['version'][0];
				} else {
					$version = $matches['version'][1];
				}
			}
			else {
				$version = $matches['version'][0];
			}
		} else {
			$version = null;
		}

		if ($version == null || $version=="") 
			{$version="?";
		}

		return (object) array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'   => $pattern
		);
	}
}
