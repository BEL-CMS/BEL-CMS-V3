<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
<div class="flex flex-col gap-6">
	<div class="grid gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4><?=constant('ADD');?> <?=constant('GROUPS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<form action="groups/sendnew/?management&option=users" enctype="multipart/form-data" method="post">
					<div class="mt-2 mb-2">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('NAME')?></label>
						<input name="name" type="text" class="form-input" value="" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('COLOR')?></label>
						<input type="color" name="color" class="form-input" value="">
					</div>
					<div class="mt-2 mb-2">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('UPLOADS_IMG')?> (728*90px)</label>
						<input type="file" name="image" class="form-input" id="upload" accept="image/*">
					</div>
					<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
						<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
							<i class="fa fa-dot-circle-o"></i><?=constant('SAVE');?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
endif;