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
<form action="themes/sendpages?management&option=templates" method="post">
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
									<th><?=constant('PAGE_FULL_WIDE');?></th>
									<th><?=constant('ACTIVATE');?></th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($scan as $k => $n):
								$chcked = in_array($n, $pages) ? 'checked="checked"': '';
								$name   = defined(strtoupper($n)) ? constant(strtoupper($n)) : $n;
							?>
								<tr>
									<td><?=$name?></td>
									<td>
										<input <?=$chcked?> type="checkbox" name="full[]" data-bootstrap-switch data-off-color="danger" data-on-color="success" value="<?=$n?>">
									</td>
								</tr>
							<?php
							endforeach;
							?>
							<tr>
								<td>News Readmore</td>
								<td>
									<input checked="checked" type="checkbox" name="full[]" data-bootstrap-switch data-off-color="danger" data-on-color="success" value="readmore">
								</td>
							</tr>
						</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="p-6">
				<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
					<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
						<i class="fa fa-dot-circle-o"></i><?=constant('SAVE');?>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<?php
endif;
?>




