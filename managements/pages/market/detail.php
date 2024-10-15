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

use BelCMS\Requires\Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

$itemsArray = array();
$items      = array();
$item = explode('|',$detail->item);
foreach ($item as $v) {
	$a[] = explode(',', $v);
}
foreach ($a as $value) {
	foreach ($value as $key => $value) {
		$b[$key][] = explode('=', $value);
	}
}
foreach ($b as $key => $value) {
	foreach($value as $k => $v) {
        if (isset($v[1])) {
		    $items[$v[0]][] = $v[1];
        } else {
            $items[$v[0]][] = '';
        }
	}
}
?>
<div class="card p-6">
    <div class="mt-8 grid grid-cols-2 gap-3">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?=constant('BILL_TO');?></h3>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?=$detail->adress->name;?> <?=$detail->adress->first_name;?></h3>
            <address class="mt-2 not-italic text-gray-500">
                <?=$detail->adress->number;?> <?=$detail->adress->address;?><br>
                <?=$detail->adress->postal_code;?> <?=$detail->adress->city;?><br>
                <?=$detail->adress->country;?><br>
                <?=$detail->adress->phone;?>
            </address>
        </div>

        <div class="sm:text-end space-y-2">
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200"><?=constant('INVOICE_NO');?></dt>
                    <dd class="col-span-3 text-gray-500"><?=$detail->id_purchase;?></dd>
                </dl>
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-2 font-semibold text-gray-800 dark:text-gray-200"><?=constant('DATE_OF_RELEASE');?></dt>
                    <dd class="col-span-3 text-gray-500"><?=$detail->date_purchase;?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="mt-6">
        <div class="border border-gray-200 p-4 rounded-lg space-y-4 dark:border-gray-700">
            <div class="grid grid-cols-5">
                <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase"><?=constant('PRODUCT');?></div>
                <div class="text-left text-xs font-medium text-gray-500 uppercase"><?=constant('QUANTITY');?></div>
                <div class="text-left text-xs font-medium text-gray-500 uppercase"><?=constant('PRICE');?></div>
                <div class="text-end text-xs font-medium text-gray-500 uppercase"><?=constant('AMOUNT');?></div>
            </div>
            <div class="hidden sm:block border-b border-gray-200 dark:border-gray-700"></div>

            <?php
            foreach ($items['name'] as $key => $name):
            ?>
            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                <div class="col-span-full sm:col-span-2">
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase"><?=constant('PRODUCT');?></h5>
                    <p class="font-medium text-gray-800 dark:text-gray-200"><?=$name;?></p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase"><?=constant('QUANTITY');?></h5>
                    <p class="text-gray-800 dark:text-gray-200"><?=$items['quantity'][$key];?></p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase"><?=constant('PRICE');?></h5>
                    <p class="text-gray-800 dark:text-gray-200"><?=$items['value'][$key];?> <?=$items['currency_code'][$key];?></p>
                </div>
                <div>
                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase"><?=constant('AMOUNT');?></h5>
                    <p class="sm:text-end text-gray-800 dark:text-gray-200"><?=$items['value'][$key] * $items['quantity'][$key];?> <?=$items['currency_code'][$key];?></p>
                </div>
            </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <div class="mt-8 flex justify-end">
        <div class="w-full max-w-2xl sm:text-end space-y-2">
            <!-- Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200"><?=constant('CART_SUBTOTAL');?></dt>
                    <dd class="col-span-2 text-gray-500"><?=$detail->sub_total;?> <?=$items['currency_code'][0];?></dd>
                </dl>
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200"><?=constant('TAXE_TOTAL');?></dt>
                    <dd class="col-span-2 text-gray-500"><?=$detail->taxe;?></dd>
                </dl>
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200"><?=constant('DISCOUNT_COUPON');?></dt>
                    <dd class="col-span-2 text-gray-500">- <?=$detail->discount;?></dd>
                </dl>
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200"><?=constant('SHIPPING_TOTAL');?></dt>
                    <dd class="col-span-2 text-gray-500"><?=$detail->shipping;?></dd>
                </dl>
                <dl class="grid sm:grid-cols-5 gap-x-3">
                    <dt class="col-span-3 font-semibold text-gray-800 dark:text-gray-200"><?=constant('TOTAL');?></dt>
                    <dd class="col-span-2 text-gray-500"><?=$detail->total_pay;?> <?=$items['currency_code'][0];?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>