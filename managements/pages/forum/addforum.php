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
<form action="/Forum/send?management&pages" method="post" class="form-horizontal">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Forum</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label for="label_title" control-label"><?=TITLE?></label>
						<input name="title" class="form-control" id="label_title" type="text" required="required" placeholder="Titre du forum">
					</div>

					<div class="form-group">
						<label for="label_subtitle" control-label"><?=SUBTITLE?></label>
						<input name="subtitle" class="form-control" id="label_subtitle" type="text" required="required" placeholder="Sous-titre du forum">
					</div>

					<div class="form-group">
						<label for="label_orderby" class="col-sm-2 control-label"><?=ORDER?></label>
						<input name="orderby" class="form-control" id="label_orderby" type="number" required="required" placeholder="1" min="1">
					</div>

					<div class="form-group">
						<label for="label_icon" class="col-sm-2 control-label"><?=VIEW?> <a target="_blank" href="https://fontawesome.com/icons?d=gallery&m=free"><?=ICON?></a></label>
						<input name="icon" class="form-control" id="label_icon" type="text" placeholder="fa fa-code">
					</div>

					<div class="form-group">
						<label for="label_orderby" class="col-sm-2 control-label"><?=CATEGORY?></label>
						<select required="required" name="id_forum" class="form-control">
							<?php
							foreach ($data as $v):
								echo '<option value="'.$v->id.'">'.$v->title.'</option>';
							endforeach;
							?>
						</select>
					</div>

					<div class="form-actions">
						<input type="hidden" name="send" value="addforum">
					</div>

					<div class="card-footer">
						<div class="col-sm-9 col-sm-offset-3">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>