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
<form action="market/sendeditcat?management&pages" method="post" class="form-horizontal">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><?=constant('MARKET');?> - <?=constant('EDIT_CATEGORY');?></h3>
			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
					<i class="fas fa-minus"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=NAME?></label>
				<div class="col-sm-12">
					<input name="name" type="text" class="form-control" required="required" value="<?=$data->name?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=TEXT?></label>
				<div class="col-sm-12">
					<textarea class="bel_cms_textarea_full" name="description"><?=$data->description?></textarea>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="card-header">
				<h3 class="card-title">Accès aux groupes</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
		</div>
		<div class="card-body">
			<?php
			$visitor = constant('VISITORS');
			$groups->$visitor = array('id' => 0, 'color' => '', 'image' => '');
			$data->groups = explode("|", $data->groups);
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
		<div class="card-footer">
			<input type="hidden" name="id" value="<?=$data->id?>">
			<button type="submit" class="btn btn-primary"><?=EDIT?></button>
		</div>
	</div>
</form>



<form action="/market/sendEditCat?management&pages" enctype="multipart/form-data" method="post" class="form-horizontal">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Editer une câtégorie</h3>
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
					<input name="name" type="text" class="form-control" id="input-name" required="required" value="<?=$data->name?>">
				</div>
			</div>
			<div class="card-body">
				<?php
				$visitor = constant('VISITORS');
				$groups->$visitor = array('id' => 0, 'color' => '', 'image' => '');
				$data->groups = explode("|", $data->groups);
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
			<div class="card-footer">
				<input type="hidden" name="id" value="<?=$data->id?>">
				<button type="submit" class="btn btn-primary"><?=SUBMIT?></button>
			</div>
		</div>
	</div>
</form>
