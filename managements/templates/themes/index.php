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
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?=LISTE_OF_TEMPLATE;?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="DataTableBelCMS table table-vcenter table-bordered">
				<thead>
					<tr>
						<th><?=DESIGN;?></th>
						<th colspan="2"><?=INFO;?></th>
						<th><?=ACTIVATION;?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($themes as $tpl):
						if ($tpl['active']):
							$active = 'bg_1';
							$css    = 'color: green';
						else:
							$active = 'bg_2';
							$css    = 'color: red';
						endif;
					?>
					<tr class="<?=$active;?>">
						<td style="width: 280px; text-align: center;">
							<img style="width: 270px; height: 120px; border: 1px solid grey;" src="<?=$tpl['screen'];?>">
						</td>
						<td>
							<strong><?=NAME_TPL;?></strong><br>
							<strong><?=CREATOR;?></strong><br>
							<strong><?=DESCRIPTION;?></strong><br>
							<strong><?=VERSION;?></strong><br>
							<strong><?=DATE;?></strong>
						</td>
						<td>
							<?=$tpl['name'];?><br>
							<?=$tpl['creator'];?><br>
							<?=$tpl['description'];?><br>
							<?=$tpl['version'];?><br>
							<?=$tpl['date'];?>
						</td>
						<td style="vertical-align: middle; text-align: center;">
							<?php
							if (!$tpl['active']):
							?>
							<a href="/themes/send/<?=$tpl['name'];?>?management&option=templates">
								<button type="button" class="btn btn-block btn-success">Activer</button>
							</a>
							<?php
							endif;
							?>
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