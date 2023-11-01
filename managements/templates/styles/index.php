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
$dirPages   = Common::ScanDirectory(DIR_PAGES);
$dirWidgets = Common::ScanDirectory(DIR_WIDGETS);
?>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Paramètres Styles : Pages </h3>
		</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<th>Nom</th>
					<th>Options</th>
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
							<td><?=$name;?></td>
							<td>
								<a href="/styles/edit/<?=$value?>?management&option=templates" class="btn btn btn-primary btn-sm mb-1">Edition du style</a>
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
</div>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Paramètres Styles : Widgets </h3>
		</div>
		<div class="card-body">
			<table class="table">
				<thead>
					<th>Nom</th>
					<th>Options</th>
				</thead>
				<tbody>
					<?php
					foreach ($dirWidgets as $key => $value):
						$name = Common::translate($value);
						?>
						<tr>
							<td><?=$name;?></td>
							<td>
								<a href="/styles/editWidgets/<?=$value?>?management&option=templates" class="btn btn btn-primary btn-sm mb-1">Edition du style</a>
							</td>
						</tr>
						<?php
					endforeach;
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
endif;