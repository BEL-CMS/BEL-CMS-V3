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

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('MARKET');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead>
							<tr>
								<th><?=constant('NAME');?></th>
								<th><?=constant('DATE_OF_RELEASE');?></th>
								<th><?=constant('COST');?></th>
								<th><?=constant('REMAINING');?></th>
								<th><?=constant('CATEGORIES');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?=constant('NAME');?></th>
								<th><?=constant('DATE_OF_RELEASE');?></th>
								<th><?=constant('COST');?></th>
								<th><?=constant('REMAINING');?></th>
								<th><?=constant('CATEGORIES');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							foreach ($data as $k => $v):
								$v->remaining = empty($v->remaining) ? constant('UNLIMITED') : $v->remaining;
								$cat          = empty($v->cat) ? constant('NO_CATEGORY') : $v->cat;
								$user         = User::getInfosUserAll($v->author);
								if ($user === false) {
									$username = constant('MEMBER_DELETE');
								} else {
									$username = $user->user->username;
								}
								$nbRemaining  = (int) $v->remaining - (int) $v->buy;
								?>
								<tr>
									<td><?=$v->name;?></td>
									<td><?=$v->date_add;?></td>
									<td><?=$v->amount;?> €</td>
									<td><?=$nbRemaining;?></td>
									<td><?=$cat;?></td>
									<td>
										<button class="btn btn-sm bg-success text-white" onclick="window.location.href='market/addImgBuy/<?=$v->id;?>?management&option=pages'"><i class="mgc_edit_2_fill text-base me-4"></i><?=constant('ADD_IMG');?></button>
										<button class="btn btn-sm bg-primary text-white" onclick="window.location.href='market/editbuy/<?=$v->id;?>?management&option=pages'"><i class="mgc_edit_2_fill text-base me-4"></i><?=constant('EDIT');?></button>
										<button type="button" data-fc-target="delete-modal_<?=$v->id?>" data-fc-type="modal" class="btn bg-danger btn-sm text-white"><i class="mgc_close_line text-base me-4"></i><?=constant('DELETE');?></button>
										<div id="delete-modal_<?=$v->id?>" class="w-full h-full mt-5 fixed top-0 left-0 z-50 transition-all duration-500 fc-modal hidden"> 
											<div class="fc-modal-open:opacity-100 duration-500 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto flex flex-col bg-white border shadow-sm rounded-md dark:bg-slate-800 dark:border-gray-700">
												<div class="flex justify-between items-center py-2.5 px-4 border-b dark:border-gray-700">
													<h3 class="font-medium text-gray-800 dark:text-white text-lg"><?=$v->name?></h3>
													<button class="inline-flex flex-shrink-0 justify-center items-center h-8 w-8 dark:text-gray-200"
															data-fc-dismiss type="button">
														<span class="material-symbols-rounded">close</span>
													</button>
												</div>
												<div class="px-4 py-8 overflow-y-auto">
													<p class="text-gray-800 dark:text-gray-200">
													Confirmer la suppression de : <?=$v->name;?>
													</p>
												</div>
												<div class="flex justify-end items-center gap-4 p-4 border-t dark:border-slate-700">
													<button class="btn dark:text-gray-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 hover:dark:bg-slate-700 transition-all" data-fc-dismiss type="button"><?=constant('CLOSE');?></button>
													<a class="btn bg-primary text-white" onclick="window.location.href='/market/delBuy/<?=$v->id;?>?management&option=pages'"><?=constant('DELETE');?></a>
												</div>
											</div>
										</div>
									</td>
								</tr>
								<?php
							endforeach;
							?>
						</tbody>
					</table>
	</div>
</div>