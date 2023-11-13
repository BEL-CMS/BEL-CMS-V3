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
<form action="Forum/send?management&option=pages" method="post">
	<div class="grid lg:grid-cols-3 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('ADD');?> - <?=constant('CAT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TITLE')?></label>
						<input name="title" placeholder="Titre de la catégorie" type="text" class="form-input" required="required">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SUBTITLE')?></label>
						<input name="subtitle" placeholder="Sous-titre de la catégorie" type="text" class="form-input">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ORDER')?></label>
						<input name="orderby" placeholder="1" min="1" type="number" class="form-input">
					</div>
					<div class="flex items-center mt-2 mb-2">
                        <input type="checkbox" value="1" name="activate" id="subcat" class="form-switch text-secondary" checked="checked">
                        <label for="subcat" class="ms-1.5"><?=constant('FORUM_SUB_CAT_ACTIVE');?></label>
                    </div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4><?=constant('ACCESS_TO_ADMIN');?></h4>
			</div>
			<div class="p-6">
				<?php
				foreach ($groups as $k => $v):
					$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
				?>
				<div class="mt-2 mb-2">
					<div class="flex items-center">
						<input id="<?=$v['id']?>" value="<?=$v['id']?>" type="checkbox" name="admin[]" class="form-switch square text-success" <?=$checked?>>
						<label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
					</div>
				</div>
				<?php
				endforeach;
				?>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4><?=constant('ACCESS_TO_GROUPS');?></h4>
			</div>
			<div class="p-6">
				<?php
				$visitor = constant('VISITORS');
				$groups->$visitor['id'] = 0;
				foreach ($groups as $k => $v):
					$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input id="<?=$v['id']?>" value="<?=$v['id']?>" type="checkbox" name="groups[]" class="form-switch square text-success" <?=$checked?>>
							<label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>
		<input type="hidden" name="send" value="addcat">
		<button type="submit" class="btn bg-primary text-white"><?=constant('SAVE');?></button>
	</div>
</form>