<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LISTE_OF_TEMPLATE');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead>
							<tr>
								<th><?=constant('DESIGN');?></th>
								<th colspan="2"><?=constant('INFO');?></th>
								<th><?=constant('ACTIVATION');?></th>
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
									<strong><?=constant('NAME_TPL');?></strong><br>
									<strong><?=constant('CREATOR');?></strong><br>
									<strong><?=constant('DESCRIPTION');?></strong><br>
									<strong><?=constant('VERSION');?></strong><br>
									<strong><?=constant('DATE');?></strong>
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
									<a href="themes/send/<?=$tpl['name'];?>?management&option=templates">
										<button type="button" class="btn bg-success text-white">
											<?=constant('ENABLE');?>
										</button>
									</a>
									<?php
									else:
									?>
										<a href="#">
										<button type="button" class="btn bg-info text-white">
											<?=constant('ALREADY_ACTIVE');?>
										</button>
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
	</div>
</div>
<?php
endif;