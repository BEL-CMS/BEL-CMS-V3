<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_forum_main">
	<form action="Forum/Send" method="post" enctype="multipart/form-data">
		<div class="card">
			<div class="card-body">
				<div class="form-group row">
					<label for="thread" class="col-2 col-form-label"><?=constant('TITLE_POST');?></label>
					<div class="col-10">
						<input type="text" required="required" name="title" class="form-control" id="thread" placeholder="<?=constant('ADD_A_TITLE');?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="messagepost" class="col-2 col-form-label"><?=constant('MESSAGE');?></label>
					<div class="col-10">
						<textarea class="bel_cms_textarea_simple" name="content" id="messagepost"></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<input type="hidden" name="send" value="NewThread">
				<input type="hidden" name="id" value="<?=$_GET['id'];?>">
				<input type="submit" class="belcms_btn belcms_bg_black" value="<?=constant('SUBMIT_THREAD');?>">
			</div>
		</div>
	</form>
</section>
