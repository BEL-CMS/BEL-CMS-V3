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
<form action="styles/send?management&option=templates" method="post">
	<div class="grid gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('STYLES');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="mt-2 mb-2">
					<textarea rows="15" cols="35" name="content" style="width: 100%;">
						<?php
						echo $data;
						?>
					</textarea>
				</div>
			</div>
			<div class="p-6">
				<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
					<input type="hidden" name="page" value="<?=$page;?>">
					<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
						<i class="fa fa-dot-circle-o"></i><?=constant('SAVE');?>
					</button>
				</div>
			</div>
		</div>
	</div>
</form>