<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
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
<form action="pricing/sendaddlisting?management&option=pages"  method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('LISTING');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" id="input-name" required="required">
					</div>
					<div class="relative mt-2 mb-2">
						<input type="text" name="cat_1" class="form-input ps-11" placeholder="Nom de la liste : 1">
						<div class="absolute inset-y-0 start-4 flex items-center z-20">
							<i class="mgc_cursor_text_line text-lg text-gray-400"></i>
						</div>
					</div>
					<div class="relative mt-2 mb-2">
						<input type="text" name="cat_2" class="form-input ps-11" placeholder="Nom de la liste : 2">
						<div class="absolute inset-y-0 start-4 flex items-center z-20">
							<i class="mgc_cursor_text_line text-lg text-gray-400"></i>
						</div>
					</div>
					<div class="relative mt-2 mb-2">
						<input type="text" name="cat_3" class="form-input ps-11" placeholder="Nom de la liste : 3">
						<div class="absolute inset-y-0 start-4 flex items-center z-20">
							<i class="mgc_cursor_text_line text-lg text-gray-400"></i>
						</div>
					</div>
					<div class="relative mt-2 mb-2">
						<input type="text" name="cat_4" class="form-input ps-11" placeholder="Nom de la liste : 4">
						<div class="absolute inset-y-0 start-4 flex items-center z-20">
							<i class="mgc_cursor_text_line text-lg text-gray-400"></i>
						</div>
					</div>
					<div class="relative mt-2 mb-2">
						<input type="text" name="cat_5" class="form-input ps-11" placeholder="Nom de la liste : 5">
						<div class="absolute inset-y-0 start-4 flex items-center z-20">
							<i class="mgc_cursor_text_line text-lg text-gray-400"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('LISTING');?> - <?=constant('ACTIFS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="actif_1" type="checkbox" id="formSwitch1" class="form-switch square text-secondary" >
							<label for="formSwitch1" class="ms-2">liste : 1</label>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="actif_2" type="checkbox" id="formSwitch2" class="form-switch square text-secondary" >
							<label for="formSwitch2" class="ms-2">liste : 2</label>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="actif_3" type="checkbox" id="formSwitch3" class="form-switch square text-secondary" >
							<label for="formSwitch3" class="ms-2">liste : 3</label>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="actif_4" type="checkbox" id="formSwitch4" class="form-switch square text-secondary" >
							<label for="formSwitch4" class="ms-2">liste : 4</label>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="actif_5" type="checkbox" id="formSwitch5" class="form-switch square text-secondary" >
							<label for="formSwitch5" class="ms-2">liste : 5</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-2 mb-2 p-6">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT');?>
		</button>
	</div>
</form>