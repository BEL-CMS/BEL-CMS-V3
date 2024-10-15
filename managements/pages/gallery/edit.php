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
<form action="gallery/sendEdit?management&option=pages" enctype="multipart/form-data" method="post">
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
						<input name="name" type="text" class="form-input" required="required" value="<?=$data->name;?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SCREEN');?> (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
						<input name="image" type="file" class="form-input" accept="image/*">
					</div>
                    <?php
                    if (!empty($data->image) and is_file(ROOT.DS.$data->image)):
                    ?>
                    <div class="mt-2 mb-2">
                        <a href="<?=$data->image;?>" class="image-popup">
							<img style="max-height: 150px;" src="<?=$data->image;?>" alt="screen_<?=$data->name;?>">
						</a>
                    </div>
                    <?php
                    endif;
                    ?>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY');?></label>
						<select name="cat" class="form-select">
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
		<input type="hidden" name="remove" value="<?=$data->image;?>">
        <input type="hidden" name="id" value="<?=$data->id;?>">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('EDIT')?></button>
	</div>
</form>