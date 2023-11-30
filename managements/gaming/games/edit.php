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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<form action="games/editGame?management&option=gaming" enctype="multipart/form-data" method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('EDIT_GAMES');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('TITLE_GAME');?></label>
						<input type="text" value="<?=$data->name?>" name="name" required="required" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('BANNER');?> 728*400px</label>
						<input type="file" name="banner" class="form-input" accept="image/*">
						<?php
						if (is_file($data->banner)):
							$banner = '<br><img src="'.$data->banner.'" style="width:300px;height:50px;"';
						else:
							$banner = '';
						endif;
						?>
						<?=$banner;?>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('ICON');?> 50*50px</label>
						<input class="form-input" type="file" name="ico" accept="image/*">
						<?php
						if (is_file($data->banner)):
							$ico = '<br><img src="'.$data->ico.'" style="width:50px;height:50px;"';
						else:
							$ico = '';
						endif;
						?>
						<?=$ico;?>
					</div>
				</div>
			</div>
			<div class="text-gray-800 text-sm font-medium inline-block mt-2 p-2">
				<input type="hidden" name="id" value="<?=$data->id?>">
				<button type="submit" class="btn bg-violet-500 border-violet-500 text-white"><i class="fa fa-dot-circle-o"></i><?=constant('EDIT')?></button>
			</div>
		</div>
	</div>
</div>