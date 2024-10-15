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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="/downloads/sendadd?management&option=pages" enctype="multipart/form-data" method="post">
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
						<input name="name" type="text" class="form-input" id="input-name" required="required">
					</div>
					<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TEXT');?></label>
						<textarea class="bel_cms_textarea_full" name="description"></textarea>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY');?></label>
						<select name="idcat" class="form-select">
						<?php
						foreach ($cat as $a => $b):
						?>
							<option value="<?=$b->id?>"><?=$b->name?></option>
						<?php
							endforeach;
						?>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Fichier (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
						<input name="download" type="file" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<input name="url" type="text" class="form-input" placeholder="URL">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SCREEN');?></label>
						<input name="screen" type="file" class="form-input">
					</div>
				</div>
			</div>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?=Common::GetMaximumFileUploadSize();?>" />
			<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
				<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('ADD')?></button>
			</div>
		</div>
	</div>
</form>