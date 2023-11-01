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

if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
	if (function_exists('mysqli_connect')) {
		$mysqli_connect = true;
	}
	$php       = PHP_VERSION;
	$phpError  = ini_get('display_errors') == 1 ? YES : NO;
	$maxMemory = ini_get('memory_limit');
	$mysqli    = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
	$http      = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'sécurisé (HTTPS) SSL' : 'Non sécurisé (HTTP)';
	function getMaximumFileUploadSize()  
	{  
		return min(Common::convertPHPSizeToBytes(ini_get('post_max_size')), Common::convertPHPSizeToBytes(ini_get('upload_max_filesize')));  
	}  
	$uploadMax = Common::ConvertSize(getMaximumFileUploadSize());
	$hostnameIP = $_SERVER['SERVER_ADDR'];
	class System
	{
		const OS_UNKNOWN = UNKNOWN;
		const OS_WIN = "Windows";
		const OS_LINUX = "Linux";
		const OS_OSX = "MacOS";
		static public function getOS()
		{
			switch (true) {
				case stristr(PHP_OS, 'DAR'): return self::OS_OSX;
				case stristr(PHP_OS, 'WIN'): return self::OS_WIN;
				case stristr(PHP_OS, 'LINUX'): return self::OS_LINUX;
				default : return self::OS_UNKNOWN;
			}
		}
	}
	class iniGetAll
	{
		static public function return($key)
		{
			foreach (ini_get_all(null, false) as $key => $value) {
				return $value;
			}
		}
	}
	$smtp = iniGetAll::return('SMTP') == 1 ? 'Activer' : 'Désactiver';
	$timezone = date_default_timezone_get();
	$df   = Common::ConvertSize(disk_free_space(ROOT), ['maxThreshold' => 6]);
	$ram  = Common::ConvertSize(memory_get_usage());
	function get_server_load() {
		if (stristr(PHP_OS, 'win')) {
			$wmi = new COM("Winmgmts://");
			$server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
			$cpu_num = 0;
			$load_total = 0;
			foreach($server as $cpu){
				$cpu_num++;
				$load_total += $cpu->loadpercentage;
			}
			$load = round($load_total/$cpu_num);
		} else {
			$sys_load = sys_getloadavg();
			$load = $sys_load[0];
		}
		return (int) $load;
	}
	$current = new DateTime('now');
	$date    = $current->format('d-m-Y H:i:s');
	$date    = Common::TransformDate($date, 'FULL', 'SHORT');
	$belcms = "https://bel-cms.dev/version.php"; 
	$data = file_get_contents($belcms); 
	$obj = json_decode($data);
	$update = VERSION_CMS <= $obj->UPDATE ? '<span style="color:green;">Vous êtes à jour.</span>' : '<span style="color:red;">Veuillez mettre à jour le C.M.S</span>';
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Information du serveur</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table id="DataTableBelCMSADMIN" class="table table-vcenter table-condensed table-bordered">
			<thead>
				<th>Nom</td>
				<th>Version</td>
			</thead>
			<tbody>
				<tr>
					<td>Version du C.M.S</td>
					<td><?=VERSION_CMS;?> <?=$update;?></td>
				</tr>
				<tr>
					<td>Lien du C.M.S</td>
					<td><a href="<?=$obj->BELCMS;?>" title="BEL-CMS"><?=$obj->BELCMS;?></a></td>
				</tr>
				<tr>
					<td>Version du C.M.S Github</td>
					<td><?=$obj->UPDATE;?></td>
				</tr>
				<tr>
					<td>Nom de la machine</td>
					<td><?=gethostname();?></td>
				</tr>
				<tr>
					<td>Nom du serveur</td>
					<td><?=$_SERVER['SERVER_NAME'];?></td>
				</tr>
				<tr>
					<td>Capacité du HDD/SSD restant</td>
					<td><?=$df;?></td>
				</tr>
				<tr>
					<td>RAM Total aloué</td>
					<td><?=$ram;?></td>
				</tr>
				<tr>
					<td>Utilisation du CPU</td>
					<td><?=get_server_load();?>%</td>
				</tr>
				<tr>
					<td>Maximum de memoire aloué</td>
					<td><?=$maxMemory;?> Ram</td>
				</tr>
				<tr>
					<td>IP du serveur</td>
					<td><?=$hostnameIP;?></td>
				</tr>
				<tr>
					<td>SMTP</td>
					<td><?=$smtp;?></td>
				</tr>
				<tr>
					<td>SiteWeb Securise</td>
					<td><?=$http;?></td>
				</tr>
				<tr>
					<td>Version de PHP</td>
					<td><?=$php;?></td>
				</tr>
				<tr>
					<td>Liste des erreurs PHP</td>
					<td><?=$phpError;?></td>
				</tr>
				<tr>
					<td>mySQLI</td>
					<td><?=$mysqli->server_version;?></td>
				</tr>
				<tr>
					<td>Le serveur tourne sous</td>
					<td><?=System::getOS()?></td>
				</tr>
				<tr>
					<td>Maximum en Upload</td>
					<td><?=$uploadMax;?> max</td>
				</tr>
				<tr>
					<td>Heure local</td>
					<td><?=$date;?></td>
				</tr>
				<tr>
					<td>TimeZone</td>
					<td><?=$timezone;?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
endif;