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
<form action="/market/sendCategorie?management&pages" enctype="multipart/form-data" method="post" class="form-horizontal">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Ajout une câtégorie</h3>
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
				<label class="col-sm-2 control-label">Accès aux groupes</label>
				<div class="col-sm-10">
					<?php
					$visitor = constant('VISITORS');
					$groups->$visitor = 0;
					foreach ($groups as $k => $v):
						$checked = null;
						$checked = $v['id'] == '1' ? 'checked readonly' : $checked;
						?>
						<div class="form-group">
							<div class="icheck-primary d-inline">
								<input class="col-8" data-bootstrap-switch name="admin[]" value="<?=$v['id']?>" type="checkbox" <?=$checked?>>
								<label class="col-4 control-label" for="<?=$v['id']?>"><?=$k?></label>
							</div>
						</div>
						<?php
					endforeach;
					?>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn-primary"><?=SUBMIT?></button>
			</div>
		</div>
	</div>
</form>
