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

if ($data['status'] == 'open') {
	$ckd = 'checked="checked"';
} else {
	$ckd = '';
}
?>

<form action="/unavailable/sendpostOpen?management&option=parameter"  method="post" class="form-horizontal form-label-left">
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Maintenance : Statut du site</h3>
		</div>
		<div class="card-body">
			<label class="custom-switch">
				<input value="open" type="checkbox" name="close" class="custom-switch-input" <?=$ckd?>>
				<span class="custom-switch-indicator"></span>
				<span class="custom-switch-description">Ouvert</span>
			</label>
		</div>
		<div class="card-footer" style="margin-top: -15px;">
			<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=SEND?></button>
		</div>
	</div>
</form>

<form action="/unavailable/sendpost?management&parameter=true" enctype="multipart/form-data" method="post" class="form-horizontal form-label-left">
	<div class="card card-secondary">
		<div class="card-header">
			<h3 class="card-title">Message de fermeture</h3>
		</div>
		<div class="form-group">
			<label class="control-label col-md-12">Titre</label>
			<div class="col-md-12">
				<input type="text" name="title" class="form-control" value="<?=$data['title']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-12">Description</label>
			<div class="col-md-12">
				<textarea name="description" class="form-control" rows="3" placeholder=''><?=$data['description']?></textarea>
			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary mb-5"><?=SEND?></button>
		</div>
	</div>
</form>