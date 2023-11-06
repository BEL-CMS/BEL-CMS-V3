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

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

function error_handler($t, $m, $f, $l, $e = true)
{
	ob_start();
	switch ($t) {
		case E_ERROR:
		case E_PARSE:
		case E_CORE_ERROR:
		case E_CORE_WARNING:
		case E_COMPILE_ERROR:
		case E_COMPILE_WARNING:
		case E_USER_ERROR:
			$c = "Fatal Error";
		break;
		case E_WARNING:
		case E_USER_WARNING:
			$c = "Warning";
		break;
		case E_NOTICE:
		case E_USER_NOTICE:
			$c = "Notice";
		break;
		case E_STRICT:
			$c = "Wrong Syntax";
		break;
		default:
			$c = "Unknow Error";
		break;
	}
	$e  = '<!DOCTYPE HTML>'.PHP_EOL;
	$e  = '<html lang="fr">'.PHP_EOL;
	$e  = '<head>'.PHP_EOL;
	$e  = '<body>'.PHP_EOL;
	$e  = '<pre style="z-index:1;">'.PHP_EOL;
	$e .= str_pad('', 100, '-',STR_PAD_RIGHT).'<br>';
	$e .= str_pad('Date Time', 20, ' ',STR_PAD_RIGHT) .date("H:i:s").'<br>';
	$e .= str_pad('Error Type', 20, ' ',STR_PAD_RIGHT) .$c.'<br>';
	$e .= str_pad('Error Message', 20, ' ',STR_PAD_RIGHT) .$m.'<br>';
	$e .= str_pad('Error Ligne', 20, ' ',STR_PAD_RIGHT) .$l.'<br>';
	$e .= str_pad('Error File', 20, ' ',STR_PAD_RIGHT) .$f.'<br>';
	$e .= str_pad('Système', 20, ' ',STR_PAD_RIGHT) .PHP_OS.'<br>';
	$e .= str_pad('', 100, '-',STR_PAD_RIGHT).'<br>';
	$e .= '</pre>'.PHP_EOL;
	$e .= '</body><html>'.PHP_EOL;
	if (ob_get_length() != 0) {
		ob_end_clean();
	}
	echo $e;
}
function debug_backtrace_string() {
	foreach(debug_backtrace() as $node) {
		var_dump($node);
	}
} 
function error_exceptions($e)
{
	error_handler (E_USER_ERROR, $e->getMessage(), $e->getFile(), $e->getLine(), $e);
}
function error_fatal()
{
	if (is_array($e = error_get_last())) {
		$type    = isset($e['type']) ? $e['type'] : 0;
		$message = isset($e['message']) ? $e['message'] : '';
		$fichier = isset($e['file']) ? $e['file'] : '';
		$ligne   = isset($e['line']) ? $e['line'] : '';
		if ($type > 0) error_handler($type, $message, $fichier, $ligne, $e);
	}
}
class pdoDbException extends PDOException {
	public function __construct(PDOException $e) {
		if(strstr($e->getMessage(), 'SQLSTATE[')) {
			preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', $e->getMessage(), $matches);
			$this->code = ($matches[1] == 'HT000' ? $matches[2] : $matches[1]);
			$this->message = $matches[3];
		}
	}
}
if ($_SESSION['CMS_DEBUG'] === true) {
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	set_error_handler('error_handler');
	set_exception_handler("error_exceptions");
	register_shutdown_function('error_fatal');
} else {
	error_reporting(0);
}
?>