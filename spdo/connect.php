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

class PDOConnection
{
	#########################################
	# Variable declaration
	#########################################
	protected static  $instance;
	public			  $cnx,
					  $isConnected = false;
	#########################################
	# Start Class
	#########################################
	public function __construct ()
	{
		$_SESSION['REQUEST_SQL'] = null;

		$pdo_options = array();
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';

		try {
			$this->cnx = new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, $pdo_options);
			$this->isConnected = true;
		}
		catch (PDOException $e) {
			$r  = '<pre>'.PHP_EOL;
			$r .= str_pad('', 100, '-',STR_PAD_RIGHT).PHP_EOL;
			$r .= str_pad('Date Time', 20, ' ',STR_PAD_RIGHT) .date("H:i:s").PHP_EOL;
			$r .= str_pad('Error Type', 20, ' ',STR_PAD_RIGHT) .$e->getCode().PHP_EOL;
			$r .= str_pad('Error Message', 20, ' ',STR_PAD_RIGHT) .$e->getMessage().PHP_EOL;
			$r .= str_pad('Error Ligne', 20, ' ',STR_PAD_RIGHT) .$e->getLine().PHP_EOL;
			$r .= str_pad('Error File', 20, ' ',STR_PAD_RIGHT) .$e->getFile().PHP_EOL;
			$r .= str_pad('Error Previous', 20, ' ',STR_PAD_RIGHT) .$e->getPrevious().PHP_EOL;
			$r .= str_pad('Error Trace', 20, ' ',STR_PAD_RIGHT) .PHP_EOL.$e->getTraceAsString().PHP_EOL;
			$r .= str_pad('', 100, '-',STR_PAD_RIGHT).PHP_EOL;
			$r .= '</pre>'.PHP_EOL;
			die($r);
		}
	}
	#########################################
	# Get instance
	#########################################
	public static function getInstance ()
	{
		if (!self::$instance)
		{
			self::$instance = new PDOConnection();
		}
		return self::$instance;
	}
}