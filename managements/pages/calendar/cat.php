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
<form action="/calendar/sendnewcat?management&option=pages" method="post" class="form-horizontal">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><?=GALLERY?> - <?=CATEGORIES;?></h3>
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
					<input type="text" name="name" class="form-control" required minlength="3" maxlength="64">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label"><?=COLOR;?></label>
				<div class="col-sm-12">
					<input type="text" placeholder="#FFFFFF" pattern="#[0-9A-Fa-f]{6}]" minlength="7" maxlength="7" name="color" class="form-control colorpicker" required>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary"><?=SUBMIT?></button>
			<a class="btn btn-default" href="/calendar?management&option=pages"><i class="fa fa-times"></i><?=CANCELED;?></a>
		</div>
	</div>
</form>