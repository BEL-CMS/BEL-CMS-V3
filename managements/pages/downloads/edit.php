<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2023 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="/downloads/sendedit?management&option=pages" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DOWNLOADS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" value="<?=$data->name?>" required="required">
					</div>
					<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TEXT');?></label>
						<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY');?></label>
						<select name="idcat" class="form-select">
						<?php
						foreach ($cat as $a => $b):
							$checked = $b->id == $data->idcat ? 'checked="checked"' : '';
						?>
							<option value="<?=$b->id?>" <?=$checked?>><?=$b->name?></option>
						<?php
							endforeach;
						?>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DOWNLOAD');?></label>
						<input value="<?=$data->download?>" type="text" class="form-input" disabled>
					</div>
					<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SCREEN');?></label>
						<input value="<?=$data->screen?>" type="text" class="form-input" disabled>
					</div>
					<div class="mt-2 mb-2">
						<p><img src="/<?=$data->screen?>" alt='no_screen' style="max-width: 100px;max-height: 100px;"></p>
					</div>
				</div>
			</div>
			<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
				<input type="hidden" name="id" value="<?=$data->id;?>">
				<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('EDIT')?></button>
			</div>
		</div>
	</div>
</form>