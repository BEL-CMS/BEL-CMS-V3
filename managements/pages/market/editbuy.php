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
<form action="market/sendEditbuy?management&option=pages" enctype="multipart/form-data" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('EDIT_BUY');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" id="input-name" value="<?=$data->name?>" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DESCRIPITON');?></label>
						<textarea name="description" id="input-description" class="bel_cms_textarea_simple"><?=$data->description?></textarea>
					</div>
					<div class="mt-2 mb-2">
						<div class="relative">
							<input type="text" name="amount" value="<?=$data->amount?>" id="input-with-leading-and-trailing-icon" min="0" name="input-with-leading-and-trailing-icon" class="form-input ps-11 pe-14" placeholder="0.00">
							<div class="absolute inset-y-0 start-4 flex items-center pointer-events-none z-20">
								<span class="text-gray-500">€</span>
							</div>
							<div class="absolute inset-y-0 end-4 flex items-center pointer-events-none z-20">
								<span class="text-gray-500">EUR</span>
							</div>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('REMAINING');?></label>
						<input min="0" value="<?=$data->remaining;?>" placeholder="0" name="remaining" type="number" class="form-input" id="input-number">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORIES');?></label>
						<select name="idcat" class="form-select">
							<option><?=constant('NO_CATEGORY');?></option>
						<?php
						foreach ($cat as $b):
							if ($b == $data->cat):
								?>
								<option value="<?=$data->cat;?>"></option>
							<?php
							endif;
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
		<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
			<input type="hidden" name="id" value="<?=$data->id;?>">
			<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
				<i class="fa fa-dot-circle-o"></i><?=constant('EDIT')?>
			</button>
		</div>
	</div>
</form>
<?php
if (isset($img) and !empty($img)):
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('IMG');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="grid xl:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-5">
			<?php
			foreach ($img as $value):
			?>
				<img alt="gallery" class="object-cover object-center rounded" src="<?=$value->img;?>">
			<?php
			endforeach;
			?>
			</div>
		</div>
	</div>
</div>
<?php
endif;
?>