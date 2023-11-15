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
<form action="Forum/sendeditMessagepost?management&option=pages" method="post">
	<div class="gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('EDIT');?> - <?=constant('MSG');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div>
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CONTENT')?></label>
					<textarea class="bel_cms_textarea_simple" name="info_text"><?=$data->content;?></textarea>
				</div>
			</div>
			<div class="p-6">
				<input type="hidden" name="id" value="<?=$data->id;?>">
				<input type="submit" value="Editer ce post" class="btn bg-violet-500 border-violet-500 text-white">
			</div>
		</div>
	<div>
</form>