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
<form action="downloads/sendeditcat?management&option=pages" method="post" class="form-horizontal">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DOWNLOADS')?> - Catégories Edition</h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<div class="col-sm-12">
							<input name="name" type="text" class="form-input" value="<?=$data->name?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-12 control-label" for="checkbox"><?=constant('TEXT');?></label>
						<div class="col-sm-12">
							<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
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
					$groups->$visitor = array('id' => 0, 'color' => '', 'image' => '');
					$data->id_groups = explode("|", $data->id_groups);
					foreach ($groups as $key => $value):
					$checked = in_array($value['id'], $data->id_groups) ? 'checked' : '';
					$checked = $value['id'] == 1 ? 'checked readonly class="form-checkbox rounded text-danger col-sm-4"' : $checked;	
					?>
					<div class="form-group">
						<div class="icheck-primary d-inline">
							<input data-bootstrap-switch name="id_groups[]" value="<?=$value['id']?>" type="checkbox" <?=$checked?>>
							<label class="col-sm-8 control-label" for="<?=$value['id']?>"><?=$key?></label>
						</div>
					</div>			
					<?php
					endforeach;
					?>
				</div>
			</div>
		</div>
	</div>
	<div>
		<input type="hidden" name="id" value="<?=$data->id?>">
		<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
			<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT')?></button>
		</div>
	</div>
</form>