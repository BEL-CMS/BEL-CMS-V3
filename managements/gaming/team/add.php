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
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<form action="Team/sendAdd?management&option=gaming" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title">Ajouter la team</h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
				<div class="mb-3">
					<label for="input-Default" class="col-sm-2 control-label"><?=NAME?></label>
					<input required name="name" type="text" class="form-input" id="input-Default" value="">
				</div>
				<div class="mb-3">
					<label for="input-img" class="col-sm-2 control-label">Images</label>
					<input id="input-img" name="img" accept="image/*" class="form-input" type="file" value="">
				</div>
				<div class="mb-3">
					<label for="input-img" class="col-sm-2 control-label">Images</label>
						<input id="input-img" name="img_pre" class="form-input" type="text" value="">
				</div>
				<div class="mb-3">
					<label class="col-sm-2 control-label">Jeux</label>
					<select name="game" tabindex="-1" class="form-input">
						<option></option>
						<?php
						foreach ($game as $k => $v):
						?>
							<option value="<?=$v->id?>"><?=$v->name?></option>
						<?php
						endforeach;
						?>
					</select>
				</div>
				<div class="mb-3">
					<label class="col-sm-2 control-label">Description</label>
					<textarea class="bel_cms_textarea_full" name="description"></textarea>
				</div>
				<div class="mb-3">
					<label for="input-order" class="col-sm-2 control-label">Ordre</label>
					<input id="input-order" name="orderby" type="number" class="form-input" value="" min="1" max="24">
				</div>
				<div class="mb-3">
					<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
						<i class="fa fa-dot-circle-o"></i><?=constant('EDIT');?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
endif;