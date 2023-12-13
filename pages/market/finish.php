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
?>
 purchase_units: [{
    amount: {
        value: '7',
        currency_code: 'USD',
        breakdown: {
            item_total: {value: '7', currency_code: 'USD'}
        }
    },
    invoice_id: 'muesli_invoice_id',
    items: [{
        name: 'Hafer',
        unit_amount: {value: '3', currency_code: 'USD'},
        quantity: '1',
        sku: 'haf001'
    }, {
        name: 'Discount',
        unit_amount: {value: '4', currency_code: 'USD'},
        quantity: '1',
        sku: 'dsc002'
    }]
}]