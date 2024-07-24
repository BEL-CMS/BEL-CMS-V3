<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.7 [PHP8.3]
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
<form action="Search/sendadd?management&option=pages"  method="post">
	<div class="flex flex-col gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('SEARCH');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
				<div class="mt-2 mb-2">
					<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NAME');?></label>
					<input name="title" type="text" class="form-input" id="input-name" required="required">
				</div>
					<div class="mt-2 mb-2">
						<select name="letter" class="form-input" required>
                            <option value="">--<?=constant('CHOSSES_AN_OPT');?>--</option>
							<?php
							foreach (array_merge(range('A', 'Z')) as $element):
							?>
							<option value="<?=$element;?>"><?=$element;?></option>
							<?php
							endforeach;
							?>
						</select>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DESC');?></label>
						<textarea style="width:95%;margin:auto;" class="bel_cms_textarea_simple" name="content"></textarea>
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