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
require ROOT.DS.'pages'.DS.'user'.DS.'country.php';

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

?>
<section id="belcms_section_market_adress">
    <form action="market/sendadress">
        <div class="belcms_grid_7">
            <h1><?=constant('YOUR_INFORMATON');?></h1>
            <div class="belcms_section_market_adress_row">
                <div class="belcms_grid_6">
                    <input class="belcms_mb_5" type="text" name="name" placeholder="<?=constant('YOUR_NAME');?>" value="">
                    <input class="belcms_mb_5" type="text" name="address" placeholder="<?=constant('YOUR_ADRESS');?>" value="">
                    <input class="belcms_mb_5" type="number" name="postal_code" placeholder="<?=constant('POSTAL_CODE');?>" value="">
                    <input class="belcms_mb_5" type="text" name="phone" placeholder="<?=constant('PHONE');?>" value="">
                </div>
                <div class="belcms_grid_6">
                    <input class="belcms_mb_5" type="text" name="first_name" placeholder="<?=constant('FIRST_NAME');?>" value="">
                    <input class="belcms_mb_5" type="number" name="number" placeholder="<?=constant('NUMBER');?>" value="">
                    <select name="country" class="belcms_mb_5">
                        <?php
                        foreach (contryList() as $k => $v):
                            echo '<option value="'.$v.'">'.$v.'</option>';
                        endforeach;
                        ?>
					</select>
                    <input class="belcms_mb_5" type="text" name="city" placeholder="<?=constant('CITY');?>" value="">
                    <div id="belcms_section_market_buy">
			            <a href="market/sendAdress" class="belcms_btn belcms_bg_grey"><?=constant('UPDATE_ADDRESS');?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="belcms_grid_5">
            <div id="belcms_cart_totals">
                <h3><?=constant('CART_TOTALS');?></h3>
                <table>
                    <tr><td><?=constant('NUMBER_OF_PURCHASES');?><td><td>0</td></tr>
                    <tr><td><?=constant('CART_SUBTOTAL');?><td><td>0 €</td></tr>
                    <tr><td><?=constant('SHIPPING_TOTAL');?><td><td>0 €</td></tr>
                    <tr><td><?=constant('TOTAL');?><td><td>0 €</td></tr>
                </table>
                <button class="belcms_bg_grey"><?=constant('PROCEED_TO_CHECKOUT');?></button>
            </div>
        </div>
    </form>
    <i class="align_left"><?=constant('ADRESS_CODE');?></i>
</section>