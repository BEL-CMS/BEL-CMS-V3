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
<form action="/faq/editadd?management&option=pages" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('FAQ');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('QUESTION');?></label>
						<input name="name" type="text" class="form-input" id="input-name" required="required" value="<?=$faq->name;?>">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('THE_CONTENT_QUESTION')?></label>
						<div class="col-sm-12">
							<textarea required class="bel_cms_textarea_full" name="content"><?=$faq->content;?></textarea>
						</div>
					<div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY');?></label>
						<select name="idcat" class="form-select" required>
						<?php
						foreach ($cat as $a => $b):
							$selected = $faq->id_cat == $b->id ? 'selected' : '';
						?>
							<option <?=$selected;?> value="<?=$b->id?>"><?=$b->name?></option>
						<?php
						endforeach;
						?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-2 mb-2 p-6">
		<input type="hidden" name="id" value="<?=$faq->id;?>">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT');?>
		</button>
	</div>
</form>