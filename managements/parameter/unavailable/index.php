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

if ($data['status'] == 'open') {
	$ckd = 'checked="checked"';
} else {
	$ckd = '';
}
?>
<div class="grid lg:grid-cols-2 gap-6">
	<div class="card">
		<div class="card-header"><h4>Maintenance : Statut du site</h4></div>
		<div class="p-6">
			<form action="unavailable/send?management&option=parameter" method="post">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<div class="flex items-center">
                            <input type="checkbox" name="close" id="switch" class="form-switch square text-warning" <?=$ckd?>>
							<label for="switch" class="ms-2"><?=constant('OPEN');?></label>
                        </div>
					</div>
					<div class="mt-2 mb-2">
						<label class="col-md-12 control-label" for="ban_author"><?=constant('NAME')?></label>
						<input type="text" name="title" class="form-input" value="<?=$data['title']?>">
					</div>
					<div class="mt-2 mb-2">
						<div class="flex">
                            <div class="inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 	dark:text-gray-400">
								<?=constant('DESCRIPTION');?>
                            </div>
                            <textarea name="description" rows="4" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none"><?=$data['description']?></textarea>
                        </div>
					</div>
					<div class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2">
						<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
							<i class="fa fa-dot-circle-o"></i><?=constant('SAVE');?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>