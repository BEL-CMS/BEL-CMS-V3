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
<form action="/market/sendadd?management&pages" enctype="multipart/form-data" method="post" class="form-horizontal">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Ajout d'une vente</h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="col-sm-12 control-label" for="input-name"><?=NAME?></label>
				<div class="col-sm-12">
					<input name="name" type="text" class="form-control" id="input-name" required="required">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="input-name"><?=DESCRIPITON?></label>
				<div class="col-sm-12">
					<textarea name="description" class="bel_cms_textarea_simple"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="input-screen">Image (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</label>
				<div class="col-sm-12">
					<input name="image" type="file" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="input-price"><?=PRICE?></label>
				<div class="col-sm-12">
					<input required="required" min="0" name="description" type="number" value="0" class="form-control" id="input-price">
				</div>
			</div>
			<div class="form-group">
				<label value="1" class="col-sm-12 control-label" for="input-number"><?=REMAINING?></label>
				<div class="col-sm-12">
					<input value="0" min="0" name="remaining" type="number" class="form-control" id="input-number">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="input-name"><?=CATEGORIES?></label>
				<div class="col-sm-12">
					<select name="idcat" class="select2_single form-control">
						<option></option>
					<?php
					foreach ($cat as $b):
					?>
						<option value="<?=$b->id?>"><?=$b->name?></option>
					<?php
					endforeach;
					?>
					</select>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary"><?=ADD?></button>
		</div>
	</div>
</div>