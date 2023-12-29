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

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (User::isLogged()) {
    $user = $_SESSION['USER']->user->username;
    $mail = $_SESSION['USER']->user->mail;
} else {
    $user = '';
    $mail = '';
}
?>
<section id="section_donation">
    <form action="Donations/send" method="post">
        <div id="section_donation_form_number">
            <span><i class="fa-solid fa-euro-sign"></i></span><input name="donate" min="5" id="number_donate" type="number" value="5">
        </div>
        <ul id="donation_ul">
            <li><button class="active" data-value="5">5.00 <?=constant('PAYPAL_CURRENCY');?></button></li>
            <li><button data-value="10">10.00 <?=constant('PAYPAL_CURRENCY');?></button></li>
            <li><button data-value="15">15.00 <?=constant('PAYPAL_CURRENCY');?></button></li>
            <li><button data-value="20">20.00 <?=constant('PAYPAL_CURRENCY');?></button></li>
            <li><button data-value="50">50.00 <?=constant('PAYPAL_CURRENCY');?></button></li>
            <li><button data-value="10"><?=constant('CUSTOM_AMOUNT');?></button></li>
        </ul>
        <div id="donation_method">
            <fieldset>
                <legend><?=constant('SELECT_PAYMENT_METHOD');?></legend>
                <ul>
                    <li>
                        <input id="redeembypaypal" name="type" type="radio" checked="checked" value="paypal">
                        <label for="redeembypaypal"><?=constant('REDEEM_BY_PAYPAL');?></label>
                    </li>
                    <li>
                        <input id="payment" name="type" type="radio" value="payment">
                        <label for="payment"><?=constant('PAYMENT');?></label> 
                    </li>
            </fieldset>
        </div>
        <div id="donation_purchase">
            <div class="donation_purchase_row">
                <div class="donation_purchase_row_line">
                    <label><?=constant('FIRST_NAME_PSEUDO');?><i>*</i></label>
                    <input name="user" type="text" value="<?=$user;?>">
                </div>
                <div class="donation_purchase_row_line">
                    <label><?=constant('LAST_NAME');?></label>
                    <input name="last_name" type="text" value="">
                </div>
            </div>
            <div class="donation_purchase_row">
                <div class="donation_purchase_row_line_full">
                    <label><?=constant('EMAIL_ADRESS');?><i>*</i></label>
                    <input name="mail" type="text" value="<?=$mail;?>">
                </div>
            </div>
            <div class="donation_purchase_row">
                <div class="donation_purchase_row_line_full">
                    <input id="terms" type="checkbox" value="terms" required="required">
                    <label for="terms" data="<?=constant('TERMS');?>" class="belcms_tooltip_top"><?=constant('AGREE_TO_TERMS');?></label>
                </div>
            </div>
            <div class="donation_purchase_row">
                <div class="donation_purchase_row_line_full">
                    <textarea name="msg"></textarea>
                </div>
            </div>
            <div class="donation_purchase_row">
                <input id="btn_submit" type="submit" value="<?=constant('DONATE_NOW');?>">
            </div>
        </div>
    </form>
</section>