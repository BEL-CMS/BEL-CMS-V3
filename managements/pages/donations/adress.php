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
if ($adress == false) {
	$adress  = (object) array();
	$adress->name  = '';
	$adress->last_name  = '';
	$adress->adress  = '';
	$adress->iban  =  '';
	$adress->bic  = '';
}
?>
<form action="Donations/sendeditadress?management&option=pages" method="post">
	<div class="grid lg:grid-cols-1 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('DONATIONS');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('FIRST_NAME');?></label>
						<input type="text" name="name" class="form-input" value="<?=$adress->name;?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('LAST_NAME');?></label>
						<input type="text" name="last_name" class="form-input" value="<?=$adress->last_name;?>">
					</div>
					<div class="mt-2 mb-2">
						<div class="flex">
							<div class="inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"><?=constant('ADRESS_POSTAL');?>
							</div>
							<textarea rows="4" name="adress" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none"><?=$adress->adress;?></textarea>
						</div>
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('ACCOUNT_NUMBER');?></label>
						<input type="text" max="32" name="iban" class="form-input" value="<?=$adress->iban;?>">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mb-2"><?=constant('BIC');?></label>
						<input type="text" min="3" max="10" name="bic" class="form-input" value="<?=$adress->bic;?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-2 mb-2">
		<button type="submit" class="btn bg-violet-500 border-violet-500 text-white">
			<i class="fa fa-dot-circle-o"></i><?=constant('EDIT');?>
		</button>
	</div>
</form>