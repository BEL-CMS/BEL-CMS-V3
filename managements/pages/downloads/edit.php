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
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title"><?=DOWNLOADS?> - Catégories - Edition</div>
			</div>
			<div class="card_body">
				<form action="/downloads/sendadd?management&pages" enctype="multipart/form-data" method="post" class="form-horizontal">
					<div style="margin-bottom: 0 !important;" class="card-alert alert alert-primary mb-0"><?=NAME?></div>
					<div class="card-body">
						<input name="name" type="text" class="form-control" id="input-Default" required="required" value="<?=$data->name?>">
					</div>
					<div style="margin-bottom: 0 !important;" class="card-alert alert alert-primary mb-0"><?=TEXT?></div>
					<div class="card-body">
						<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
					</div>
					<div style="margin-bottom: 0 !important;" class="card-alert alert alert-primary mb-0"><?=CATEGORY?></div>
					<div class="card-body">
						<select name="idcat" class="select2_single form-control">
						<?php
						foreach ($cat as $a => $b):
							$checked = $b->id == $data->idcat ? 'checked="checked"' : '';
							?>
							<option value="<?=$b->id?>" <?=$checked?>><?=$b->name?></option>
							<?php
						endforeach;
						?>
						</select>
					</div>
					<div style="margin-bottom: 0 !important;" class="card-alert alert alert-primary mb-0">Fichier (<?=Common::ConvertSize(Common::GetMaximumFileUploadSize())?> max)</div>
					<div class="card-body">
						<p><a href="/<?=$data->download?>"><?=$data->download?></a></p>
					</div>
					<div style="margin-bottom: 0 !important;" class="card-alert alert alert-primary mb-0">Image</div>
					<div class="card-body">
						<p><img src="/<?=$data->screen?>" alt='no_screen' style="max-width: 100px;max-height: 100px;"></p>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary"><?=EDIT?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>