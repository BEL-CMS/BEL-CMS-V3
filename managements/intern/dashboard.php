<?php

use BelCMS\Core\GetHost;
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;

$microTime = microtime(true);
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
/* Usage disk */
$df = disk_free_space(ROOT);
$ds = disk_total_space(ROOT);
$resultat_space = (100 - ($df *100/$ds));
$pourcent_space = round($resultat_space);
$pourcent_space = $pourcent_space >= 80 ? '<span style="color:red">'.$pourcent_space.'%</span>' : '<span style="color:green">'.$pourcent_space.'%</span>';
$false = true;
function lastConnected ()
{
	$return = null;
	$sql = New BDD();
	$sql->table('TABLE_USERS');
	$sql->orderby(array(array('name' => 'last_visit', 'type' => 'DESC')));
	$sql->fields(array('username', 'avatar', 'last_visit'));
	$sql->limit(10);
	$sql->queryAll();
	if (!empty($sql->data)) {
		$return = $sql->data;
		foreach ($return as $k => $v) {
			$return[$k]->avatar = is_file($v->avatar) ? $v->avatar : 'assets/images/default_avatar.jpg';
		}
	}
	return $return;
}
function nbCountUsers ()
{
	$sql = New BDD();
	$sql->table('TABLE_USERS');
	$sql->count();
	return $sql->data;
}
function nbCountArticles ()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_PAGES_ARTICLES');
	$sql->count();
	return $sql->data;
}
function nbCountForum ()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_FORUM_POST');
	$sql->count();
	return $sql->data;
}
function lastInteraction ()
{
		$return = null;
		$sql = New BDD();
		$sql->table('TABLE_INTERACTION');
		$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
		$sql->limit(10);
		$sql->queryAll();
		return $sql->data;
}
function getNbVisitors()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_USERS');
	$sql->count();
	return $sql->data;
}
function getNbNews()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_PAGES_ARTICLES');
	$sql->count();
	return $sql->data;
}
function getNbComments()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_COMMENTS');
	$sql->count();
	return $sql->data;
}
function getNbDl()
{
	$result = 0;
	$sql = New BDD();
	$sql->table('TABLE_DOWNLOADS');
	$sql->count();
	return $sql->data;
}
function getNbPages()
{
	$sql = New BDD();
	$sql->table('TABLE_PAGE_STATS');
	$sql->fields(array('nb_view', 'page'));
	$sql->queryAll();
	return $sql->data;
}
function get_server_load() {
	if (stristr(PHP_OS, 'win')) {
		$wmi = new COM("Winmgmts://");
		$server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
		$cpu_num = 0;
		$load_total = 0;
		foreach($server as $cpu) {
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
$get_server_load = get_server_load();
$get_server_load = $get_server_load >= 75 ? '<span style="color:red">'.$get_server_load.'%</span>' : '<span style="color:green">'.$get_server_load.'%</span>';
$http   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'sécurisé (HTTPS) SSL' : 'Non sécurisé (HTTP)';
$df     = Common::ConvertSize(disk_free_space(ROOT), ['maxThreshold' => 6]);
$ram    = Common::size(memory_get_usage());
$belcms = "https://bel-cms.dev/version.php"; 
$data   = file_get_contents($belcms); 
$obj    = json_decode($data);
$update = VERSION_CMS <= $obj->UPDATE ? '<span style="color:green;">'.VERSION_CMS.'</span>' : '<span style="color:red;">'.$obj->UPDATE.'</span>';
$php    = PHP_VERSION;
?>
<div class="grid lg:grid-cols-3 gap-6">

	<div class="lg:col-span-3">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Statistiques</h6>
			</div>
			<div class="p-6">
				<div class="grid lg:grid-cols-4 gap-6">
					<div class="flex items-center gap-5">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
							<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
							<circle cx="9" cy="7" r="4"></circle>
							<path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
							<path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
						</svg>
						<div>
							<h4 class="text-lg text-gray-700 dark:text-gray-300 font-medium"><?=nbCountUsers();?></h4>
							<span class="text-sm">Totale de Membres</span>
						</div>
					</div>
					<div class="flex items-center gap-5">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
						<div>
							<h4 class="text-lg text-gray-700 dark:text-gray-300 font-medium"><?=getNbDl();?></h4>
							<span class="text-sm">Totale de Téléchargements</span>
						</div>
					</div>
					<div class="flex items-center gap-5">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
						<div class="">
							<h4 class="text-lg text-gray-700 dark:text-gray-300 font-medium"><?=nbCountArticles();?></h4>
							<span class="text-sm">Totale d'articles</span>
						</div>
					</div>
					<div class="flex items-center gap-5">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
						<div class="">
							<h4 class="text-lg text-gray-700 dark:text-gray-300 font-medium"><?=nbCountForum();?></h4>
							<span class="text-sm">Totale de Post sur le Forum</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="lg:col-span-2">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Calendrier</h4>
			</div>

			<div class="p-6">

			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Statistiques</h4>
		</div>
		<div>
			<div id="stats" class="apex-charts" dir="ltr"></div>
		</div>
	</div>
</div>
<?php
function removeAccent ($data)
{
	$search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', "'", ' ');
	$replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', '_', '_');
	$return = str_replace($search, $replace, $data);
	return $return;
}
$Stats      = getNbPages();
$data       = '';
$categories = '';
foreach ($Stats as $k => $name) {
	$name = strtoupper($name->page);
	$name = defined($name) ? removeAccent(constant($name)) : removeAccent($name);
	$categories .= "'".ucfirst(strtolower($name))."',";
}
foreach ($Stats as $k => $view) {
	$data .= "'".$view->nb_view."',";
}
$categories = substr($categories, 0, -1);
$data       = substr($data, 0, -1);
?>
<script src="/managements/assets/libs/apexcharts/apexcharts.min.js"></script>
<script type="text/javascript">
	var Stats = {
		chart: {
			height: 350,
			type: 'bar',
			toolbar: {
				show: false,
			}
		},
		plotOptions: {
			bar: {
				horizontal: true,
			}
		},
		dataLabels: {
			enabled: false
		},
		series: [{
			data: [<?=$data;?>]
		}],
		colors: ['#34c38f'],
		grid: {
			borderColor: '#9ca3af20',
		},
		xaxis: {
			categories: [<?=$categories;?>],
		}
	}
	var chart = new ApexCharts(
    document.querySelector("#stats"),
    Stats
);
chart.render();
</script>
<div style="display: none;" id="timelast">
<?php
$time = (microtime(true) - $microTime);
echo round($time, 3);?> <?=constant('SECONDS');?>
</div>