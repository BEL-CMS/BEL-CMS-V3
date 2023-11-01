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
<form action="/groups/sendnew?management&users" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Ajouter un groupe</h3>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label><?=NAME?></label>
				<div class="col-sm-12">
					<input name="name" type="text" class="form-control form-control-border" value="" required="required">
				</div>
			</div>
			<div class="form-group">
				<label>Couleur du groupe :</label>
				<div class="input-group">
					<input type="text" name="color" class="form-control form-control form-control-border colorpicker" value="">
				</div>
			</div>
			<div class="form-group">
				<div class="custom-file">
					<input type="file" name="image" class="custom-file-input" id="upload" accept="image/*">
					<label class="custom-file-label" for="upload">Upload</label>
				</div>
	        </div>
		</div>
	</div>
	<div class="card-footer" style="margin-top: -15px;">
		<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SAVE?></button>
	</div>
</form>
<?php
endif;