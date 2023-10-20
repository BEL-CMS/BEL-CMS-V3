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
}