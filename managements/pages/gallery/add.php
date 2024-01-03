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
<form action="gallery/sendadd?management&option=pages" enctype="multipart/form-data" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('GALLERY');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" required="required">
					</div>
					<div class="mt-2 mb-2">
						<textarea class="bel_cms_textarea_full" name="description"></textarea>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SCREEN');?> (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
						<input name="image" type="file" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY');?></label>
						<select name="cat" class="form-select">
							<option value=""><?=constant('NO_CATEGORY');?></option>
						<?php
						foreach ($cat as $a => $b):
						?>
							<option value="<?=$b->id?>"><?=$b->name?></option>
						<?php
							endforeach;
						?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('ADD')?></button>
	</div>
</form>