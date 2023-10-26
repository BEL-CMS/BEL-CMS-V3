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
	$e  = '<pre>'.PHP_EOL;
	$e .= str_pad('', 100, '-',STR_PAD_RIGHT).PHP_EOL;
	$e .= str_pad('Date Time', 20, ' ',STR_PAD_RIGHT) .date("H:i:s").PHP_EOL;
	$e .= str_pad('Error Type', 20, ' ',STR_PAD_RIGHT) .$c.PHP_EOL;
	$e .= str_pad('Error Message', 20, ' ',STR_PAD_RIGHT) .$m.PHP_EOL;
	$e .= str_pad('Error Ligne', 20, ' ',STR_PAD_RIGHT) .$l.PHP_EOL;
	$e .= str_pad('Error File', 20, ' ',STR_PAD_RIGHT) .$f.PHP_EOL;
	$e .= str_pad('PHP version', 20, ' ',STR_PAD_RIGHT) .PHP_OS.PHP_EOL;
	$e .= str_pad('', 100, '-',STR_PAD_RIGHT).PHP_EOL;
	$e .= '</pre>'.PHP_EOL;
	if (ob_get_length() != 0) {
		ob_end_clean();
	}
	echo $e;
	if ($c == "Fatal Error") {
		var_dump(debug_backtrace_string());
		echo str_pad('', 100, '-',STR_PAD_RIGHT).PHP_EOL;
	}
}
function debug_backtrace_string() {
	foreach(debug_backtrace() as $node) {
		var_dump($node);
	}
} 
function error_exceptions($e)
{
	var_dump(debug_backtrace_string());
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