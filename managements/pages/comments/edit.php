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
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('COMMENT')?> - <?=constant('EDIT')?></h4>
			</div>
		</div>
		<div class="p-6">
			<form action="/comments/sendedit?management&option=pages" method="post">
				<div>
					<div class="flex">
						<div class="mt-2 mb-2 inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">
							<?=constant('TEXT');?>
						</div>
						<textarea rows="8" name="comment" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none mt-2 mb-2"><?=$comments->comment;?></textarea>
					</div>
				</div>
				<div>
					<input type="hidden" name="id" value="<?=$comments->id?>">
					<button type="submit" class="btn bg-primary text-white"><?=constant('EDIT');?></button>
				</div>
			</form>
		</div>
	</div>
</div>