<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
<form action="Articles/sendnew?management&option=pages" enctype="multipart/form-data" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('PAGES');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
				<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
						<input name="name" type="text" class="form-input" id="input-Default">
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4><?=constant('ACCESS_TO_GROUPS');?></h4>
			</div>
			<div class="p-6">
				<?php
				$visitor = constant('VISITORS');
				$groups->$visitor['id'] = 0;
				foreach ($groups as $k => $v):
					$checked = $v['id'] == 1 ? "checked" : "";
					?>
					<div class="mt-2 mb-2">
						<div class="flex items-center">
							<input name="groups[]" value="<?=$v['id']?>" type="checkbox" <?=$checked?>>
							<label for="<?=$v['id']?>" class="ms-2"><?=$k?></label>
						</div>
					</div>
					<?php
				endforeach;
				?>
			</div>
		</div>
		<button type="submit" class="btn bg-primary text-white"><?=constant('SEND');?></button>
	</div>
</form>