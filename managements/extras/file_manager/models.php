<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

final class ModelsFiles
{
	#####################################
	# Infos tables
	#####################################
	# TABLE_UPLOADS
	#####################################
	public function getUploads ()
	{
		$sql = new BDD;
		$sql->table('TABLE_UPLOADS');
		$sql->queryAll();
		$return = $sql->data;
		return $return;
	}

	public function sendTpl () 
	{
		$dir = ROOT.DS.'uploads'.DS.'tmp';
		$upload = Common::Upload('file', $dir, array('.zip'));

		$send['name']      = Common::VarSecure($_FILES['file']['name'], null);
		$send['category']  = 'templates';
		$send['author']    = $_SESSION['USER']->user->hash_key;
		$send['size']      = filesize($_FILES['file']['tmp_name']);
		
		if ($upload == constant('UPLOAD_FILE_SUCCESS')) {
			$sql = New BDD();
			$sql->table('TABLE_UPLOADS');
			$sql->insert($send);
			$return = array(
				'type' => 'success',
				'text' => constant('UPLOAD_FILE_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'success',
				'text' => constant('ERROR_UPLOAD')
			);
		}

		debug($return);

		return $return;
	}

	public function sendPage () 
	{
		$dir = ROOT.DS.'uploads'.DS.'tmp';
		$upload = Common::Upload('file', $dir, array('.zip'));

		$send['name']      = Common::VarSecure($_FILES['file']['name'], null);
		$send['category']  = 'pages';
		$send['author']    = $_SESSION['USER']->user->hash_key;
		$send['size']      = filesize($_FILES['file']['tmp_name']);
		
		if ($upload == constant('UPLOAD_FILE_SUCCESS')) {
			$sql = New BDD();
			$sql->table('TABLE_UPLOADS');
			$sql->insert($send);
			$return = array(
				'type' => 'success',
				'text' => constant('UPLOAD_FILE_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'success',
				'text' => constant('ERROR_UPLOAD')
			);
		}

		return $return;
	}

	public function sendCMS () 
	{
		$dir = ROOT.DS.'uploads'.DS.'tmp';
		$upload = Common::Upload('file', $dir, array('.zip'));

		$send['name']      = Common::VarSecure($_FILES['file']['name'], null);
		$send['category']  = 'pages';
		$send['author']    = $_SESSION['USER']->user->hash_key;
		$send['size']      = filesize($_FILES['file']['tmp_name']);
		
		if ($upload == constant('UPLOAD_FILE_SUCCESS')) {
			$sql = New BDD();
			$sql->table('TABLE_UPLOADS');
			$sql->insert($send);
			$return = array(
				'type' => 'success',
				'text' => constant('UPLOAD_FILE_SUCCESS')
			);
		} else {
			$return = array(
				'type' => 'success',
				'text' => constant('ERROR_UPLOAD')
			);
		}

		return $return;
	}

	public function install ($id = null)
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_UPLOADS');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			if ($sql->rowCount == true) {
				$achive = ROOT.DS.'uploads'.DS.'tmp'.DS.$return->name;
				if ($return->category == 'templates' or $return->category == 'pages') {
					$path = ROOT.DS.$return->category.DS;
				} else if ($return->category == 'cms') {
					$path = ROOT.DS;
				} else {
					return false;
				}
				if (self::extract($achive, $path) === true) {
					$update['install'] = 1;
					$sqlUpdate = new BDD;
					$sqlUpdate->table('TABLE_UPLOADS');
					$sqlUpdate->where(array('name' => 'id', 'value' => $id));
					$sqlUpdate->update($update);
					return true;
				} else {
					return false;
				}
			}
		}
	}

	public function installPage ($id = null)
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_UPLOADS');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			if ($sql->rowCount == true) {
				$achive = ROOT.DS.'uploads'.DS.'tmp'.DS.$return->name;
				$path = ROOT.DS;
				if (self::extract($achive, $path) === true) {
					if (is_file(ROOT.DS.'install.php')) {
						require ROOT.DS.'install.php';
						sleep(3);
						unlink(ROOT.DS.'install.php');
					}
					$update['install'] = 1;
					$sqlUpdate = new BDD;
					$sqlUpdate->table('TABLE_UPLOADS');
					$sqlUpdate->where(array('name' => 'id', 'value' => $id));
					$sqlUpdate->update($update);
					return true;
				}
			}
		}
	}

	private function extract ($achive, $path): bool
	{
		$zip = new ZipArchive;
		if ($zip->open($achive) === true) {
			$zip->extractTo($path);
			$zip->close();
			return true;
		} else {
			return false;
		}
	}

	public function delete ($id = null)
	{
		if (is_numeric($id)) {
			$sql = new BDD;
			$sql->table('TABLE_UPLOADS');
			$sql->where(array('name' => 'id', 'value' => $id));
			$sql->queryOne();
			$return = $sql->data;
			if ($sql->rowCount == true) {
				$path = ROOT.DS.'uploads'.DS.'tmp'.DS.$return->name;
				if (file_exists($path)) {
					unlink($path);
					$del = new BDD;
					$del->table('TABLE_UPLOADS');
					$del->where(array('name' => 'id', 'value' => $id));
					$del->delete();
					return constant('ADMIN_DELETE_SUCCESS');
				} else {
					$del = new BDD;
					$del->table('TABLE_UPLOADS');
					$del->where(array('name' => 'id', 'value' => $id));
					$del->delete();
					return constant('FILE_NO_EXIST');
				}
			}
		} else {
			return constant('INVALID_ID');
		}
	}

	public function backup ()
	{
		$scanDir = Common::ScanFiles(ROOT.DS.'uploads'.DS.'backup', false, true);
		return $scanDir;
	}

	public function backupCMS ()
	{
		$scanDir = Common::ScanFiles(ROOT.DS.'backup', false, true);
		return $scanDir;
	}

	public function saveBDD ()
	{
		$database = constant('DB_NAME');
		$user     = constant('DB_USER');
		$pass     = constant('DB_PASSWORD');
		$host     = constant('DB_HOST');
		$charset  = "utf8mb4";
		
		$conn = new mysqli($host, $user, $pass, $database);
		$conn->set_charset($charset);
		
		$result = mysqli_query($conn, "SHOW TABLES");
		$tables = array();
		
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
		
		$sqlScript = "";
		foreach ($tables as $table) {
			$query = "SHOW CREATE TABLE $table";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_row($result);
			 
			$sqlScript .= "\n\n" . $row[1] . ";\n\n";
			 
			$query = "SELECT * FROM $table";
			$result = mysqli_query($conn, $query);
			 
			$columnCount = mysqli_num_fields($result);
			 
			for ($i = 0; $i < $columnCount; $i ++) {
				while ($row = mysqli_fetch_row($result)) {
					$sqlScript .= "INSERT INTO $table VALUES(";
					for ($j = 0; $j < $columnCount; $j ++) {
						$row[$j] = $row[$j];
						 
						$sqlScript .= (isset($row[$j])) ? '"' . $row[$j] . '"' : '""';
		
						if ($j < ($columnCount - 1)) {
							$sqlScript .= ',';
						}
		
					}
					$sqlScript .= ");\n";
				}
			}
			$sqlScript .= "\n"; 

			$date = new DateTime('now');		
			$date = $date->format('d_m_Y.H_i_s');
			$mysql_file = fopen(ROOT.DS.'backup'.DS.$database . '_backup_'.$date.'.sql', 'w+');
			fwrite($mysql_file ,$sqlScript );
			fclose($mysql_file );
		}
	}
}