<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
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
<form action="market/sendaddDiscount?management&option=pages" method="post">
	<div class="grid lg:grid-cols-2 gap-6">
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('PRE_ADD_DISCOUNT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('CODE');?></label>
						<input oninput="this.value = this.value.toUpperCase()" name="code" type="text" class="form-input">
					</div>
                    <div class="mt-2 mb-2">
                        <input class="form-radio text-info" type="radio" id="formRadio1" name="auto_code" value="NO_TAXE">
                        <label class="ms-1.5" for="formRadio1"><?=constant('NO_TAXE');?></label>
                    </div>
                    <div class="mt-2 mb-2">
                        <input class="form-radio text-info" type="radio" id="formRadio2" name="auto_code" value="NO_DELIVRY">
                        <label class="ms-1.5" for="formRadio2"><?=constant('NO_DELIVRY');?></label>
                    </div>
                    <div class="mt-2 mb-2">
                        <input class="form-radio text-info" type="radio" id="formRadio3" name="auto_code" value="ONE_LIVRAISON">
                        <label class="ms-1.5" for="formRadio3"><?=constant('ONE_LIVRAISON');?></label>
                    </div>
                    <div class="mt-2 mb-2">
                        <input class="form-radio text-info" type="radio" id="formRadio4" name="auto_code" value="NO_TAXE_NO_DELIVRY">
                        <label class="ms-1.5" for="formRadio4"><?=constant('NO_TAXE_NO_DELIVRY');?></label>
                    </div>
					<div class="mt-2 mb-2">
						<div class="flex">
							<div class="inline-flex items-center whitespace-nowrap px-3 rounded-s border border-e-0 border-gray-200 bg-gray-50 text-gray-500 dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400"><?=constant('DESCRIPTION');?></div>
							<textarea name="comments" rows="4" class="form-textarea ltr:rounded-s-none rtl:rounded-e-none"></textarea>
						</div>
					</div>
                    <div class="mt-2 mb-2">
                        <input type="reset" class="form-input">
                    </div>
                </div>
            </div>
        </div>
		<div class="card">
			<div class="card-header">
				<div class="flex justify-between items-center">
					<h4 class="card-title"><?=constant('ADD_DISCOUNT');?></h4>
				</div>
			</div>
			<div class="p-6">
				<div class="overflow-x-auto">
                    <div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('NUMBER_USE');?></label>
						<input name="number" type="number" min="1" value="1" class="form-input" id="input-name" required="required">
					</div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('DATE_OF_FINISH');?></label>
						<input name="date_of_finish" type="datetime-local" class="form-input" id="input-name">
					</div>
                    <div class="mt-2 mb-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="illimite" value="1" class="form-switch square text-primary" name="infinite_date">
                            <label for="illimite" class="ms-2"><?=constant('INFINITE');?> <?=constant('DATE');?></label>
                        </div>
                    </div>
					<div class="mt-2 mb-2">
						<label class="text-gray-800 text-sm font-medium inline-block mt-2 mb-2"><?=constant('PRICE');?></label>
						<input name="price" type="number" min="0" value="0" class="form-input" id="input-name" required="required">
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 mb-2 col-span-3">
        <button class="btn bg-violet-500 border-violet-500 text-white" type="submit"><?=constant('ADD_COUPON');?></button>
    </div>
</form>
