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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):

$dirPages   = Common::ScanDirectory(constant('DIR_PAGES'));
$dirWidgets = Common::ScanDirectory(constant('DIR_WIDGETS'));
?>
<div class="grid lg:grid-cols-2 gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LISTE_OF_PAGES');?></h4>
			</div>
		</div>
		<div class="p-6">
			<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
				<thead>
					<tr>
						<th><?=constant('NAME');?></th>
						<th><?=constant('OPTIONS');?></th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($dirPages as $key => $value):
					if ($value == 'managements') {
						unset($dirPages[$key]);
						$name = null;
					} else {
						$name = Common::translate($value);
						?>
					<tr>
						<td><strong><?=$name;?></strong></td>
						<td>
							<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-dark/80 text-white">
								<a href="styles/edit/<?=$value?>?management&option=templates">Edition du style</a>
							</div>
						</td>
					</tr>
					<?php
				}
				endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LISTE_OF_WIDGETS');?></h4>
			</div>
		</div>
		<div class="p-6">
			<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($dirWidgets as $key => $value):
					$name = Common::translate($value);
					if ($value != 'tpl'):
					?>
					<tr>
						<td><strong><?=$name;?></strong></td>
						<td>
							<div class="inline-flex items-center gap-1.5 py-1 px-3 rounded text-xs font-medium bg-dark/80 text-white">
								<a href="styles/editWidgets/<?=$value?>?management&option=templates">Edition du style</a>
							</div>
						</td>
					</tr>
				<?php
					endif;
				endforeach;
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
endif;