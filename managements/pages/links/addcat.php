<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
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
<form action="links/sendaddcat?management&option=pages"  method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('LINKS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
                    <div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY_NAME');?></label>
						<input name="name" type="text" class="form-input" id="input-name" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CATEGORY_COLOR');?></label>
						<input data-jscolor="{reset:'small dark',value:'#3673B1'}" name="color" type="text" class="form-input">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DESC');?></label>
						<textarea style="width:95%;margin:auto;" class="bel_cms_textarea_simple" name="description"></textarea>
					</div>
                </div>
            </div>
        </div>
        <div class="mt-2 mb-2 p-6">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('SUBMIT');?>
		</button>
	    </div>
    </div>
</form>