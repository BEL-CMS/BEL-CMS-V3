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
?>
<form action="survey/sendparameter?management&option=widgets" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title">Paramètres Sondage</h4>
				</div>
			</div>
			<div class="grid lg:grid-cols-3 gap-6">
				<div class="p-6">
					<div class="overflow-x-auto">
						<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
							<div class="flex items-center opacity-60">
								<input class="form-switch" <?=$config->active == 1 ? 'checked' : ''?> name="active" type="checkbox" value="1" role="switch" id="active">
								<label class="ms-1.5" for="active"><?=constant('ACTIVE_WIDGETS');?></label>
							</div>
							<div class="mt-2 mb-2">
								<label class="col-md-12 control-label">Nom personnalisé du widgets</label>
								<input class="form-input" name="title" type="text" value="<?=$config->title?>">
							</div>
						</div>
					</div>
					<br>
					<div class="overflow-x-auto">
						<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
							<div class="card-header">
								<div class="flex justify-between items-center">
									<h4 class="card-title">Pages à afficher</h4>
								</div>
							</div>
							<div class="p-6">
							<?php
							foreach ($pages as $key => $value) {
								if ($value == 'managements' or $value == 'styles') {
									unset($pages[$key]);
								}
							}
							foreach ($pages as $k => $v):
								$checked = in_array($v, $config->pages) ? 'checked' : '';
								$checked = $v == 1 ? 'checked' : $checked;
								$name    = defined(strtoupper($v)) ? constant(strtoupper($v)) : $v;
								?>
								<div class="flex items-center mt-2 mb-2">
									<input name="current[]" value="<?=$v?>" type="checkbox" id="<?=$name;?>" class="form-switch square text-secondary" <?=$checked?>>
									<label for="<?=$name;?>" class="ms-2"><?=$name;?></label>
								</div>
								<?php
							endforeach;
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="p-6">
					<div class="card">
						<div class="card-header">
							<div class="flex justify-between items-center">
								<h4 class="card-title">Accès aux Administrateurs</h4>
							</div>
						</div>
						<div class="p-6">
							<?php
							foreach ($groups as $k => $v):
								$checked = in_array($v['id'], $config->groups_admin) ? 'checked' : '';
								$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
							?>
							<div class="flex items-center mt-2 mb-2">
								<input type="checkbox" id="<?=$v['id']?>" name="admin[]" value="<?=$v['id']?>" class="form-switch square text-danger text-danger" <?=$checked?>>
								<label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
							</div>
							<?php
							endforeach;
							?>
						</div>
					</div>
					<br>
					<div class="card">
						<div class="card-header">
							<div class="flex justify-between items-center">
								<h4 class="card-title"><?=constant('ARRANGEMENT');?></h4>
							</div>
						</div>
						<div class="p-6">
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
							<div class="flex flex-col gap-2">
								<div class="form-check">
									<input class="form-radio text-success" type="radio" name="pos" <?=$top?> value="top">
									<label class="ms-1.5" for="formRadio01"><?=constant('TOP');?></label>
								</div>
								<div class="form-check">
									<input class="form-radio text-success" type="radio" name="pos" <?=$bottom?> value="bottom">
									<label class="ms-1.5" for="formRadio01"><?=constant('BOTTOM');?></label>
								</div>
								<div class="form-check">
									<input class="form-radio text-success" type="radio" name="pos" <?=$left?> value="left">
									<label class="ms-1.5" for="formRadio01"><?=constant('LEFT');?></label>
								</div>
								<div class="form-check">
									<input class="form-radio text-success" type="radio" name="pos" <?=$right?> value="right">
									<label class="ms-1.5" for="formRadio01"><?=constant('RIGHT');?></label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="p-6">
					<div class="card">
						<div class="card-header">
							<div class="flex justify-between items-center">
								<h4 class="card-title">Accès aux groupes</h4>
							</div>
						</div>
						<div class="p-6">
							<?php
							$visitor = constant('VISITORS');
							$groups->$visitor['id'] = 0;
							foreach ($groups as $k => $v):
								$checked = in_array($v['id'], $config->groups_access) ? 'checked' : '';
								$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
								?>
								<div class="flex items-center mt-2 mb-2">
									<input name="groups[]" value="<?=$v['id']?>" type="checkbox" id="<?=$v['id'];?>" class="form-switch square text-primary" <?=$checked?>>
									<label for="<?=$v['id'];?>" class="ms-2"><?=$k?></label>
								</div>
								<?php
							endforeach;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<button type="submit" class="btn bg-primary text-white"><?=constant('TO_REGISTER');?></button>
	</div>
</form>
