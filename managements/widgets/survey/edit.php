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
		<div class="block full">
		    <div class="block-title">
		        <h2><strong>Editer Sondage</strong></h2>
		    </div>
			<div class="table-responsive">
				<form action="/survey/sendedit?management&widgets=true" method="post" class="form-horizontal form-bordered">
					<div class="form-group">
						<label class="col-sm-2 control-label">Question</label>
						<div class="col-sm-10">
							<input name="name" type="text" class="form-control" value="<?=$name->name;?>">
						</div>
					</div>
					<?php
					$i = 0;
					foreach ($data as $key => $value):
						$i++;
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Réponse <?=$i;?></label>
							<div class="col-sm-10">
								<input name="quest[]" type="text" class="form-control" value="<?=$value->content;?>">
							</div>
						</div>
					<?php
					endforeach;
					$i++;
					while ($i <= 10):
						?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Réponse <?=$i;?></label>
							<div class="col-sm-10">
								<input name="quest[]" type="text" class="form-control">
							</div>
						</div>
					<?php
					$i++;
					endwhile;
					?>
					<div class="form-group form-actions">
						<div class="col-sm-10 col-sm-offset-2">
							<input type="hidden" name="id" value="<?=$id;?>">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>