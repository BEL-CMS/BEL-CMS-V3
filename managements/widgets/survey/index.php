<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('SURVEY');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('QUESTION');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('DATE_OF_PUBLICATION');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('END_VOTE');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('NUMBER_OF_RESPONSES');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('OPTIONS');?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($data as $v):
								if ($v->dateclose == 'P99Y') {
									$endtime = constant('UNLIMITED');
								} else {
									$date = new DateTimeImmutable($v->timestop);
									$newDate = $date->add(new DateInterval($v->dateclose));
									$endtime = $newDate->format('d-m-Y H:i:s');	
									$endtime = Common::TransformDate($endtime, 'MEDIUM', 'SHORT');		
								}
								?>
								<tr>
									<td><?=$v->question;?></td>
									<td><?=Common::TransformDate($v->timestop, 'MEDIUM', 'SHORT');?></td>
									<td><?=$endtime;?></td>
									<td><?=$v->vote;?></td>
									<td></td>
								</tr>
								<?php
							endforeach;
							?>
						</tbody>
						<tfoot class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('QUESTION');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('DATE_OF_PUBLICATION');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('END_VOTE');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('NUMBER_OF_RESPONSES');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('OPTIONS');?></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
