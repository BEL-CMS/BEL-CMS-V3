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

if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<form action="/gallery/sendparameter?management&pages" method="post" class="form-horizontal">
	<div class="row">
		<div class="col-md-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Blog Active</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<div class="icheck-primary d-inline"></div>
						<input data-bootstrap-switch value="1" type="checkbox" <?=$config->active == 1 ? 'checked' : ''?> name="active">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
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
					<?php
					foreach ($groups as $k => $v):
						$checked = in_array($v['id'], $config->access_admin) ? 'checked' : '';
						$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="form-group">
						<div class="icheck-primary d-inline">
							<input class="col-4" data-bootstrap-switch id="<?=$v['id']?>" name="admin[]" value="<?=$v['id']?>" type="checkbox" style="vertical-align: -moz-middle-with-baseline;" <?=$checked?>>
							<label class="col-8 control-label" for="<?=$v['id']?>"><?=$k?></label>
						</div>
					</div>
					<?php
					endforeach;
					?>
				</div>
			</div>
		</div>
		<div class="col-md-5">
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
				<?php
				$visitor = constant('VISITORS');
				$groups->$visitor = 0;
				foreach ($groups as $k => $v):
					$checked = in_array($v['id'], $config->access_groups) ? 'checked' : '';
					$checked = $v['id'] == 1 ? 'checked readonly' : $checked;
					?>
					<div class="form-group">
						<div class="icheck-primary d-inline">
							<input class="col-8" data-bootstrap-switch name="groups[]" value="<?=$v['id']?>" type="checkbox" <?=$checked?>>
							<label class="col-4 control-label" for="<?=$v['id']?>"><?=$k?></label>
						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group form-actions">
			<div class="col-sm-12 col-sm-offset-3">
				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
			</div>
		</div>	
	</div>
</form>
<?php
endif;
