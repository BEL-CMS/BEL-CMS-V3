<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Secures;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="gallery/sendeditsubcat?management&option=pages" method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('SUB_CAT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
                    <div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" required="required" value="<?=$data->name;?>">
					</div>
					<div class="mt-2 mb-2" style="position: relative;">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('COLOR_TEXT')?></label>
						<input type="color" name="textcolor" class="form-input" value="<?=$data->color;?>">
					</div>
					<div class="mt-2 mb-2" style="position: relative;">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('BACK_COLOR')?></label>
						<input type="color" name="bgcolor" class="form-input" value="<?=$data->bg_color;?>">
					</div>
                </div>
            </div>
        </div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('SUB_CAT');?> - <?=constant('GROUPS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Nom</th>
								<th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Activation</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
						<?php
						$groupsAccess = explode('|', $data->groups_access);
						$groups = Secures::getGroups();
						$groups[0] = constant('VISITOR');
						foreach ($groups as $k => $v):
							$name = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
							if ($v == 'ADMINISTRATORS') {
								$checked = 'checked readonly';
							} else {
								$checked = '';
							}
							if (in_array($k, $groupsAccess)) {
								$checked = 'checked';
							} else {
								$checked = '';
							}
							?>
							<tr>
								<td class="px-6 py-2 text-sm font-medium text-gray-800 dark:text-gray-200">
									<?=$name;?>
								</td>
								<td class="px-6 py-2 text-gray-800 dark:text-gray-200">
									<div class="flex items-center">
										<input type="checkbox" name="groups[]" class="form-switch square text-success" <?=$checked?> value="<?=$k;?>">
									</div>
								</td>
							</tr>
						<?php	
						endforeach;
						?>
						</tbody>
					</table>
					<p><i style="color:red;">*</i> <?=constant('ALERT_ADMIN');?></p>
				</div>
			</div>
		</div>
    <div><input type="hidden" value="<?=$data->id;?>" name="id_gallery">
	<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('EDIT')?></button>
	</div>
</form>