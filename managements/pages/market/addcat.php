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

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="market/sendCategorie?management&option=pages" method="post" enctype="multipart/form-data">
	<div class="grid 2xl:grid-cols-2 grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('ADD');?> - <?=constant('CAT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" value="" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('SCREEN');?></label>
						<input accept="image/*" name="img" type="file" class="form-input">
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title">Accès aux groupes</h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<?php
					$visitor = constant('VISITORS');
					$groups->{$visitor} = array('id'=> 0);
					foreach ($groups as $k => $v):
					$checked = $v['id'] == 1 ? 'checked readonly' : '';
					?>
					<div class="flex items-center mb-2">
						<input <?=$checked;?> name="groups[]" value="<?=$v['id']?>" type="checkbox" id="form_<?=$v['id']?>" class="form-switch square text-success">
						<label for="form_<?=$v['id']?>" class="ms-2"><?=$k?></label>
					</div>
					<?php
					endforeach;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT')?></button>
	</div>
</form>
