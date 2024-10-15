<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
<form action="Team/playerEdit?management&option=gaming" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title">Selectionner le ou les joueurs qui feront partie de la team :</strong> <?=$team->name?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead class="bg-gray-50 dark:bg-gray-700">
							<tr>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('GAME');?></th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400"><?=constant('PLAYER');?></th>
							</tr>
						</thead>
						<tbody>
						<?php
						foreach ($user as $k => $v):
							$checked = in_array($v->hash_key, $userTeam) ? 'checked="checked"' : '';
							?>
							<tr>
								<td><label for="formSwitch2" class="ms-1.5"><?=$v->username?></label></td>
								<td><input type="checkbox" <?=$checked?> id="formSwitch2" class="form-switch text-warning" name="team[]" value="<?=$v->hash_key?>"></td>
							</tr>
							<?php
						endforeach;
						?>
						</tbody>
					</table>
				</div>
	        </div>
	        <div class="p-6">
	            <div class="col-xs-12">
	            	<input type="hidden" name="id" value="<?=$team->id?>">
					<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
						<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT')?></button>
					</div>
				</div>
	        </div>
		</div>
	</div>
</form>