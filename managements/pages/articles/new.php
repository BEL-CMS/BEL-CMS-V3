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
<div class="flex flex-col gap-6">
	<div class="grid lg:grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<h4><?=constant('NEW');?> <?=constant('ARTICLE');?></h4>
			</div>
			<div class="p-6">
				<form action="articles/sendnew?management&option=pages" method="post">
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<div class="col-sm-12">
							<input name="name" type="text" class="form-input" value="">
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">Tags</label>
						<div class="col-sm-12">
							<input name="tags" placeholder="( séparer par des => , )" type="text" class="form-input">
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TEXT');?></label>
						<div class="col-sm-12">
							<textarea class="bel_cms_textarea_full" name="content"></textarea>
						</div>
					</div>
					<div>
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2" for="checkbox"><?=constant('COMPLEMENT');?></label>
						<div class="col-sm-12">
							<textarea class="bel_cms_textarea_full" name="additionalcontent"></textarea>
						</div>
					</div>
					<div>
						<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
							<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> <?=constant('SAVE');?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
endif;