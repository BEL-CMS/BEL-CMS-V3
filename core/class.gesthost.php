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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class GetHost {
	public static function getBaseUrl() {
		$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 'https://' : 'http://';
		$tmpURL   = dirname(__FILE__);
		$tmpURL   = str_replace(chr(92),'/',$tmpURL);
		$tmpURL   = str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL);
		$tmpURL   = ltrim($tmpURL,'/');
		$tmpURL   = rtrim($tmpURL, '/');

		if (strpos($tmpURL,'/')) {
			$tmpURL = explode('/',$tmpURL);
			$tmpURL = $tmpURL[0];
		}

		$tmpURL = str_replace('core', '', $tmpURL);

		if ($tmpURL !== $_SERVER['HTTP_HOST']) {
			$base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL;
		} else {
			$base_url .= $tmpURL;
		}

		return $base_url;
	}
	public static function base ($atRoot=FALSE, $atCore=FALSE, $parse=FALSE)
	{	
		if (isset($_SERVER['HTTP_HOST'])) {
			$http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			$hostname = $_SERVER['HTTP_HOST'];
			$dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	
			$core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
			$core = $core[0];
	
			$tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
			$end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
			$base_url = sprintf( $tmplt, $http, $hostname, $end );
		}	else $base_url = 'http://localhost/';
	
		if ($parse) {
			$base_url = parse_url($base_url);
			if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
		}

		return $base_url;
	}
	public static function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !='off') {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].'/';
		} else {
		 $pageURL .= $_SERVER["SERVER_NAME"].'/';
		}
		return $pageURL;
	}
}