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
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?=_NEW;?> <?=NEWS;?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<form action="articles/sendnew?management&option=pages" method="post" class="form-horizontal form-bordered">
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=NAME?></label>
				<div class="col-sm-12">
					<input name="name" type="text" class="form-control" value="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox">Tags</label>
				<div class="col-sm-12">
					<input name="tags" placeholder="( séparer par des => , )" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=TEXT?></label>
				<div class="col-sm-12">
					<textarea class="bel_cms_textarea_full" name="content"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-12 control-label" for="checkbox"><?=COMPLEMENT?></label>
				<div class="col-sm-12">
					<textarea class="bel_cms_textarea_full" name="additionalcontent"></textarea>
				</div>
			</div>
			<div class="form-group form-actions">
				<div class="col-sm-12 col-sm-offset-3">
					<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
endif;