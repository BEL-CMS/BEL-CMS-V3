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
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title">Paramètres Shoutbox</h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<form action="/shoutbox/sendparameter?management&option=widgets" method="post">
						<div class="mt-2 mb-2">
							<label class="col-md-12 control-label" for="name">Activer le widget</label>
							<input value="1" name="active" <?=$config->active == 1 ? 'checked' : ''?> required class="form-input" id="name" name="name" type="text">
						</div>
						<div class="mt-2 mb-2">
							<label class="col-md-12 control-label">Nom personnalisé du widgets</label>
							<input class="form-input" name="title" type="text" value="<?=$config->title?>">
						</div>
						<div class="mt-2 mb-2">
							<label class="col-md-12 control-label"><?=constant('NB_MSG');?></label>
							<input id="input-NB_MSG" name="MAX_MSG" type="number" class="form-input" type="number" value="<?=$config->config['MAX_MSG']?>" min="5" max="25">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Pages à afficher</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="col-sm-12">
							<?php
							foreach ($pages as $key => $value) {
								if ($value == 'managements') {
									unset($pages[$key]);
								}
							}
							foreach ($pages as $k => $v):
								$checked = in_array($v, $config->pages) ? 'checked' : '';
								$checked = $v == 1 ? 'checked' : $checked;
								$name    = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
								?>
								<div class="input-group mb-3">
									<label class="col-8 control-label"><?=$name?></label>
									<span class="input-group-addon">
										<input data-bootstrap-switch name="current[]" value="<?=$v?>" type="checkbox" <?=$checked?>>
									</span>
								</div>
								<?php
							endforeach;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Accès aux Administrateurs</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="col-sm-12">
					<?php
					foreach ($groups as $k => $v):
						$checked = in_array($v, $config->groups_admin) ? 'checked' : '';
						$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="form-group">
						<div class="icheck-primary d-inline">
							<input class="col-sm-4" data-bootstrap-switch id="<?=$v['id']?>" name="admin[]" value="<?=$v['id']?>" type="checkbox" style="vertical-align: -moz-middle-with-baseline;" <?=$checked?>>
							<label class="col-sm-8 control-label" for="<?=$v['id']?>"><?=$k?></label>
						</div>
					</div>
					<?php
					endforeach;
					?>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Accès aux groupes</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="col-sm-12">
				<?php
				$visitor = constant('VISITORS');
				$groups->$visitor = 0;
				foreach ($groups as $k => $v):
					$checked = in_array($v['id'], $config->access_groups) ? 'checked' : '';
					$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="form-group">
						<div class="icheck-primary d-inline">
							<input class="col-sm-4" data-bootstrap-switch name="groups[]" value="<?=$v['id']?>" type="checkbox" <?=$checked?>>
							<label class="col-sm-8 control-label" for="<?=$v['id']?>"><?=$k?></label>
						</div>
					</div>
					<?php
				endforeach;
				?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Disposition</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<?php
				$top = null; $right = null; $bottom = null; $left = null;
				if ($config->pos == 'top') {
					$top = 'checked="checked"';
				} else if ($config->pos == 'bottom') {
					$bottom = 'checked="checked"';
				} else if ($config->pos == 'left') {
					$left = 'checked="checked"';
				} else if ($config->pos == 'right') {
					$right = 'checked="checked"';
				}
				?>
				<div class="form-group">
					<div class="col-sm-12">
						<div class="input-group mb-3 mt-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="radio" name="pos" <?=$top?> value="top">
								</div>
							</div>
							<input type="text" class="form-control" disabled="disabled" value="Haut">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="radio" name="pos" <?=$right?> value="right">
								</div>
							</div>
							<input type="text" class="form-control" disabled="disabled" value="Droite">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="radio" name="pos" <?=$bottom?> value="bottom">
								</div>
							</div>
							<input type="text" class="form-control" disabled="disabled" value="Bas">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="radio" name="pos" <?=$left?> value="left">
								</div>
							</div>
							<input type="text" class="form-control" disabled="disabled" value="Gauche">
						</div>
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group form-actions">
	</div>
</form>
