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
	<div class="grid gap-6">
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
						<input name="title" class="form-input" id="label_title" type="text" required="required" placeholder="Titre du forum">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SUBTITLE')?></label>
						<input name="subtitle" class="form-input" type="text" placeholder="Sous-titre du forum">
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ORDER')?></label>
						<input value="1" name="orderby" class="form-input" id="label_orderby" type="number" required="required" placeholder="1" min="1">
					</div>

					<div>
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('VIEW')?> <a target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free">(<?=constant('ICON');?>)</a></label>
						<input name="icon" class="form-input" id="label_icon" type="text" placeholder="fa fa-code">
					</div>

					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY')?></label>
						<select required="required" name="id_forum" class="form-select">
							<?php
							foreach ($data as $v):
								echo '<option value="'.$v->id.'">'.$v->title.'</option>';
							endforeach;
							?>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<input type="hidden" name="send" value="addforum">
						<button type="submit" class="btn bg-primary text-white"><?=constant('SAVE');?></button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>