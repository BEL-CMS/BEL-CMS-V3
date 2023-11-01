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
		<h3 class="card-title">Sondage</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<form action="/survey/send?management&widgets" method="post" class="form-horizontal form-bordered">
			<div class="form-group">
				<label class="col-sm-2 control-label">Titre</label>
				<div class="col-sm-10">
					<input name="name" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group mb-2">
				<label class="col-sm-2 control-label">Question 1</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 2</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 3</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 4</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 5</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 6</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 7</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 8</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 9</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Question 10</label>
				<div class="col-sm-10">
					<input name="quest[]" type="text" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary"><?=ADD?></button>
			</div>
		</div>
	</div>
</div>
</form>
<?php
endif;