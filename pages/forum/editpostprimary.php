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
<form action="Forum/SendEditPostPrimary" method="post" enctype="multipart/form-data">
	<div class="card">
		<div class="card-header"><h3><i class="fa fa-comment"></i> <?=EDIT_REPLY?></h3></div>
		<div class="card-body">
			<textarea class="bel_cms_textarea_simple" name="content"><?=$d->content?></textarea>
		</div>
		<div class="card-footer">
			<input type="hidden" name="id_threads" value="<?=$d->id_threads;?>">
			<input type="hidden" name="author" value="<?=$d->author;?>">
			<input type="submit" value="<?=EDIT_POST?>" class="btn btn-primary btn-rounded btn-lg btn-shadow pull-right">
		</div>
	</div>
</form>