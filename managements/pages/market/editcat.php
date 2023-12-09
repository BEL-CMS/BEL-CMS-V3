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
<form action="market/sendeditcat?management&option=pages" method="post" enctype="multipart/form-data">
	<div class="grid 2xl:grid-cols-2 grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('MARKET');?> - <?=constant('EDIT_CATEGORY');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" required="required" value="<?=$data->name?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<?=constant('SCREEN');?> : <i><?=constant('SCREEN_OPT');?></i>
						</label>
						<input accept="image/*" name="img" type="file" class="form-input">
					</div>
					<?php
					if (!empty($data->img)):
						$img = is_file($data->img) ?? '';
					?>
						<div class="p-6">
							<div class="grid xl:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-5">
							<img alt="gallery" class="object-cover object-center rounded" src="<?=$data->img;?>">
							</div>
						</div>
					<?php
					endif;
					?>
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
				<div class="card-body">
				<?php
				$visitor = constant('VISITORS');
				$groups->{$visitor} = array('id' => 0, 'color' => '', 'image' => '');
				$data->groups = explode("|", $data->user_groups);
				foreach ($groups as $key => $value):
				$checked = in_array($value['id'], $data->groups) ? 'checked' : '';
				$checked = $value['id'] == 1 ? 'checked readonly' : $checked;	
				?>
				<div class="form-group">
					<div class="icheck-primary d-inline">
						<input class="col-sm-4" data-bootstrap-switch name="groups[]" value="<?=$value['id']?>" type="checkbox" <?=$checked?>>
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
	<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
		<input type="hidden" name="id" value="<?=$data->id?>">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT')?></button>
	</div>
</form>