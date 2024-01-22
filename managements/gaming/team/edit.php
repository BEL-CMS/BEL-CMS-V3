<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<form action="Team/sendEdit?management&option=gaming" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title">Ajouter la team</h4>
				</div>
			</div>
			<div class="p-6">
				<div class="mb-3">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
					<input required name="name" value="<?=$data->name?>" type="text" class="form-input" id="input-Default" value="">
				</div>
				<div class="mb-3">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Images</label>
					<input id="input-img" name="img" class="form-input" type="file" value="">
				</div>
				<div class="mb-3">
				<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Images</label>
					<input id="input-img" name="img_pre" value="<?=$data->img?>" class="form-input" type="text" value="">
				</div>
				<div class="mb-3">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Jeux</label>
					<select name="game" class="form-input" tabindex="-1">
						<option></option>
						<?php
						foreach ($game as $k => $v):
							if ($v->id == $data->game) {
								$checked = 'selected="selected"';
							} else {
								$checked = '';
							}
							?>
							<option <?=$checked?> value="<?=$v->id?>"><?=$v->name?></option>
							<?php
						endforeach;
						?>
					</select>
				</div>
				<div class="mb-3">
				<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DESC');?></label>
					<div class="col-sm-10">
						<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
					</div>
				</div>
				<div class="mb-3">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ORDER');?></label>
					<input id="input-order" name="orderby" type="number" class="form-input" value="<?=$data->orderby?>" min="1" max="99">
				</div>
				<div class="mb-3">
					<input type="hidden" name="id" value="<?=$data->id?>">
					<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
						<i class="fa fa-dot-circle-o"></i><?=constant('SEND');?>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<?php
endif;
?>