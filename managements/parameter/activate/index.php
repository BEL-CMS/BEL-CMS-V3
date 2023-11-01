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
?>
<div class="grid lg:grid-cols-2 gap-6">
	<div class="card">
		<div class="card-header"><h4>Activation Pages</h4></div>
		<div class="p-6">
			<form action="activate/sendAddPages?management&option=parameter" method="post">
				<div class="overflow-x-auto">
					<div class="min-w-full inline-block align-middle">
						<div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
							<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
								<thead class="bg-gray-50 dark:bg-gray-700">
									<tr>
										<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nom</th>
										<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Activation</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
								<?php
								foreach ($pages as $key => $value):
									$name = defined(strtoupper($value->name)) ? constant(strtoupper($value->name)) : $value->name;
									$name = $value->name == 'managements' ? 'Managements' : $name;
									if ($value->name == 'managements') {
										$checked = 'checked readonly';
									} else {
										if ($value->active == 0) {
											$checked  = (int) 0;
										} else { 
											$checked  = 'checked';
										}
									}
									?>
									<tr>
										<td class="px-6 py-2 text-sm font-medium text-gray-800 dark:text-gray-200">
											<?=$name;?>
										</td>
										<td class="px-6 py-2 text-gray-800 dark:text-gray-200">
											<div class="flex items-center">
												<input type="checkbox" name="<?=$value->name;?>" id="name="<?=$value->name;?>"" class="form-switch square text-success"<?=$checked?>>
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
					<div class="p-3">
                        <button class="btn bg-primary text-white" type="submit"><?=constant('SAVE');?></button>
                    </div>
				</div>
			</form>
		</div>
	</div>
	<div class="card">
		<div class="card-header"><h4>Activation Widgets</h4></div>
		<div class="p-6">
			<form action="activate/sendAddWidgets?management&option=parameter" method="post">
				<div class="overflow-x-auto">
					<div class="min-w-full inline-block align-middle">
						<div class="border rounded-lg shadow overflow-hidden dark:border-gray-700 dark:shadow-gray-900">
							<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
								<thead class="bg-gray-50 dark:bg-gray-700">
									<tr>
										<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nom</th>
										<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Activation</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
								<?php
								$values = null;
								foreach ($widgets as $key => $value):
									$name = defined(strtoupper($value->name)) ? constant(strtoupper($value->name)) : $value->name;
									if ($value->active == 0) {
										$checked  = (int) 0;
									} else { 
										$checked  = 'checked';
									}
								?>
									<tr>
										<td class="px-6 py-2 text-sm font-medium text-gray-800 dark:text-gray-200"><?=$name;?></td>
										<td class="px-6 py-2 text-gray-800 dark:text-gray-200">
											<div class="flex items-center">
												<input type="checkbox" name="<?=$value->name;?>" id="name="<?=$value->name;?>"" class="form-switch square text-success"<?=$checked?>>
											</div>
										</td>
									</tr>
								<?php	
							endforeach;
							?>
								</tbody>
							</table>
						</div>
						<div class="p-3">
							<button class="btn bg-primary text-white" type="submit"><?=constant('SAVE');?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>