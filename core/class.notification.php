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

#########################################
# Notification Alert (red, blue, green, orange, grey)
#########################################
final class Notification
{
	public static function alert ($text = null, $title = null, $full = false)
	{
		$title = $title != null ? $title : defined('INFO');
		$text  = $text  != null ? $text  : defined('NO_TEXT_DEFINED');
		if ($full === true) {
			echo self::renderFull('error', $text, $title);
			die();
		} else {
			echo self::render ('error', $text, $title);
		}
	}
	public static function error ($text = null, $title = null, $full = false)
	{
		$title = $title != null ? $title : defined('INFO');
		$text  = $text  != null ? $text  : defined('NO_TEXT_DEFINED');
		if ($full === true) {
			echo self::renderFull('error', $text, $title);
			die();
		} else {
			echo self::render ('error', $text, $title);
		}
	}
	public static function warning ($text = null, $title = null, $full = false)
	{
		$title = $title != null ? $title : defined('INFO');
		$text  = $text  != null ? $text  : defined('NO_TEXT_DEFINED');
		if ($full === true) {
			echo self::renderFull('warning', $text, $title);
			die();
		} else {
			echo self::render ('warning', $text, $title);
		}
	}
	public static function success ($text = null, $title = null, $full = false)
	{
		$title = $title != null ? $title : defined('INFO');
		$text  = $text  != null ? $text  : defined('NO_TEXT_DEFINED');
		if ($full === true) {
			echo self::renderFull('success', $text, $title);
			die();
		} else {
			echo self::render ('success', $text, $title);
		}
	}
	public static function infos ($text = null, $title = null, $full = false)
	{
		$title = $title != null ? $title : defined('INFO');
		$text  = $text  != null ? $text  : defined('NO_TEXT_DEFINED');
		if ($full === true) {
			echo self::renderFull('infos', $text, $title);
			die();
		} else {
			echo self::render ('infos', $text, $title);
		}
	}
	private static function render ($type = null, $text = 'BEL-CMS : Alert neutral', $title = 'Alert !')
	{
		switch ($type) {
			case 'alert':
				$bg = 'background-color: rgba(223, 83, 73, .8) !important;';
			break;

			case 'error':
				$bg = 'background-color: rgba(223, 83, 73, .8) !important;';
			break;

			case 'success':
				$bg = 'background-color: rgba(106, 189, 110, .8) !important;';
			break;

			case 'warning':
				$bg = 'background-color: rgba(255, 170, 43, .8) !important;';
			break;

			case 'infos':
				$bg = 'background-color: rgba(42, 167, 246, .8) !important;';
			break;

			default:
				$bg = 'background-color: rgba(102, 97, 90, 1) !important;';
			break;
		}
		$render  = '<section style="border: 1px solid rgba(209, 207, 207, 1);background:rgba(248, 248, 248, 1);margin: 15px  auto;width:100%;overflow:hidden;">'.PHP_EOL;
		$render .= '<header style="display: block;width:100%;padding:15px;overflow:hidden;color:rgba(255, 255, 255, 0.95);min-height:auto !important;'.$bg.'">'.PHP_EOL;
		$render .= '<span style="display:block;float:left;margin-left:15px;line-height:24px;font-size:16px;font-weight: bold;">'.$title.'</span>'.PHP_EOL;
		$render .= '</header>'.PHP_EOL;
		$render .= '<div style="margin:15px;padding: 15px;text-align: justify;border: 1px solid rgba(209, 207, 207, 1);background-color:rgba(244, 242, 242, 1);font-weight:13px;color:var(--gray-dark);">'.PHP_EOL;
		$render .= $text;
		$render .= '</div>'.PHP_EOL;
		$render .= '</section>'.PHP_EOL;
		return $render;
	}
	################################################
	# Notification Full page| error - warning - success
	################################################
	public static function renderFull ($type = null, $text = 'BEL-CMS : Alert neutral', $title = 'Alert !')
	{
		$render  = '<!DOCTYPE html>';
		$render .= '<html lang="fr">';
		$render .= '<head>';
		$render .= '<meta charset="utf-8">';
		$render .= '<title>Error : '.$title.'</title>';
		$render .= '<link rel="stylesheet" href="/assets/css/belcms.notification.css">';
		$render .= '<style type="text/css">';
		$render .= 'body {background-image: url("/assets/img/patern_notif.png");}section#error {width: 100%;max-width: 700px;margin: 300px calc(50% - 350px) auto;height: 300px;}';
		$render .= '</style>';
		$render .= '</head>';
		$render .= '<body>';
		$render .= '<section id="error">';
		$render .= '<section class="belcms_notification">';
		$render .= '<header class="belcms_notification_header '.$type.'">';
		$render .= '<span>'.$title.'</span>';
		$render .= '</header>';
		$render .= '<div class="belcms_notification_msg">';
		$render .= $text;
		$render .= '</div> ';
		$render .= '</section>';
		$render .= '</section>';
		$render .= '</body>';
		$render .= '</html>';
		return $render;
	}
}
