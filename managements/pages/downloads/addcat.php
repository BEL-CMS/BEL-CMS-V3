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
<form action="downloads/sendnewcat?management&option=pages" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DOWNLOADS');?> - <?=constant('CAT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<div class="col-sm-12">
							<input name="name" type="text" class="form-input" value="">
						</div>
					</div>
					<div>
						<label class="col-sm-12 control-label"><?=constant('TEXT');?></label>
						<div class="col-sm-12">
							<textarea class="bel_cms_textarea_full" name="description"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="flex flex-col gap-6 mt-3">
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
					$groups->{$visitor} = array('id'=>0);
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
	<div>
		<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
			<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT')?></button>
		</div>
	</div>
</form>