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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('BADGES');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th># ID</th>
								<th><?=constant('NAME');?></th>
								<th><?=constant('ICON');?>
								<th><?=constant('ICON_FULL');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</thead>
						<tfoot class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th># ID</th>
								<th><?=constant('NAME');?></th>
								<th><?=constant('ICON');?>
								<th><?=constant('ICON_FULL');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</tfoot>
						<tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>