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
<form action="gallery/accept?management&option=pages" method="post">
	<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('SCREEN');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<a href="<?=$data->image;?>" class="glightbox">
						<img src="<?=$data->image;?>">
					</a>
					<input type="hidden" value="<?=$data->image;?>" name="image">
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('INFOS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" required="required" value="<?=$data->name;?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DATE');?></label>
						<input name="date" readonly type="datetime" class="form-input"  value="<?=$data->date_insert;?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('AUTHOR');?></label>
						<input name="author" readonly type="datetime" class="form-input"  value="<?=$data->author;?>">
					</div>
					<div class="mt-2 mb-2">
						<label for="cat-select" class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('CHOIS_CAT');?></label>
						<select name="cat" required class="form-select" id="cat-select">
						<?php
						foreach ($cat as $key => $value):
						?>
						<option value="<?=$value->id;?>"><?=$value->name;?></option>
						<?php
						endforeach;
						?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DESCRIPTION');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<textarea name="description" class="bel_cms_textarea_simple"><?=$data->description;?></textarea>
				</div>
			</div>
		</div>
		<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
			<input type="hidden" value="<?=$data->id;?>" name="id">
			<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('ACCEPTE')?></button>
		</div>
	</div>
</form>