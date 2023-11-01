<?php
/**
 * Bel-CMS [Content management system]
 * @version 2.1.0
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2022 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<div class="x_panel">
	<div class="x_title">
		<h2>Menu Page Team</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<a href="/team?management&gaming=true" class="btn btn-app">
			<i class="fa fas fa-home"></i> Accueil
		</a>
		<a href="/Team/addTeam?management&gaming=true" class="btn btn-app">
			<i class="fa fas fa-plus"></i> <?=ADD?>
		</a>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=BLOG?></h4>
		</div>
		<div class="panel-body basic-form-panel">
			<form action="/Team/sendEdit?management&gaming=true" enctype="multipart/form-data" method="post" class="form-horizontal">
				<div class="form-group">
					<label for="input-Default" class="col-sm-2 control-label"><?=NAME?></label>
					<div class="col-sm-10">
						<input name="name" type="text" class="form-control" id="input-Default" value="<?=$data->name?>">
					</div>
				</div>
				<div class="form-group">
					<label for="input-img" class="col-sm-2 control-label">Images</label>
					<div class="col-sm-10">
						<input id="input-img" name="img" class="form-control" type="file" value="">
					</div>
				</div>
				<div class="form-group">
					<label for="input-img" class="col-sm-2 control-label">Images</label>
					<div class="col-sm-10">
						<input id="input-img" name="img_pre" class="form-control" type="text" value="<?=$data->img?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Jeux</label>
					<div class="col-sm-10">
						<select name="game" class="form-control" tabindex="-1">
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
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description</label>
					<div class="col-sm-10">
						<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="input-order" class="col-sm-2 control-label">Ordre</label>
					<div class="col-sm-10">
						<input id="input-order" name="orderby" type="number" class="form-control" value="<?=$data->orderby?>" min="1" max="24">
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" value="<?=$data->id?>">
					<button type="submit" class="btn btn-primary"><?=EDIT?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
endif;