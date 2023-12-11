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
debug($order, false);
$nbBuy     = (int) 0;
$nbPrice   = (int) 0;
$nbTotal   = (int) 0;
$nbDelivry = (int) 0;
foreach ($order as $k => $v) {
	$a = $v->infos->remaining - $v->infos->buy;
	if ($v->number > $a) {
		$nbBuy     = (int) $nbBuy + (int) $a;
		$nbPrice   = $a * $v->infos->amount;
		$nbDelivry = $nbBuy * $v->infos->delivery_price;
	} else if ($v->number <= $a) {
		$nbBuy     = (int) $v->number + $nbBuy;
		$nbPrice   = $v->number * $v->infos->amount;
		$nbDelivry = $nbBuy * $v->infos->delivery_price;
	}
	$nbTotal = $nbTotal + $nbPrice + $nbDelivry;
}
?>
<section id="belcms_market_buy_confirm">
	<div id="belcms_section_market_confirm_content">
		<div id="belcms_market_buy_confirm_infos">
			<table id="belcms_market_buy_confirm_table">
				<thead>
					<tr>
						<th colspan="2"><?=constant('PRODUCT');?></th>
						<th class="center"><?=constant('PRICE');?></th>
						<th><?=constant('QUANTITY');?></th>
						<th class="right"><?=constant('TOTAL');?></th>
				</thead>
				<tfoot>
					<tr>
						<th colspan="2"><?=constant('PRODUCT');?></th>
						<th class="center"><?=constant('PRICE');?></th>
						<th><?=constant('QUANTITY');?></th>
						<th class="right"><?=constant('TOTAL');?></th>
				</tfoot>
				<tbody>
				<?php
				foreach ($order as $value):
				?>
				<tr>
					<td class="belcms_market_buy_confirm_infos_img">
						<a class="image-popup" href="uploads/market/6/A_small_cup_of_coffee.JPG">
							<img src="uploads/market/6/A_small_cup_of_coffee.JPG" alt="img_cart_">
						</a>
					</td>
					<td class="justify"><h3>une tase de café</h3>
					<td class="center">5.00 €</td>
					<td><input pattern="[0-9]*" min="1" type="number" value="1" name="number"></td>
					<td class="right">15.00 €</td>
				</tr>
				<tr>
					<td class="belcms_market_buy_confirm_infos_img">
						<a class="image-popup" href="uploads/market/6/A_small_cup_of_coffee.JPG">
							<img src="uploads/market/6/A_small_cup_of_coffee.JPG" alt="img_cart_">
						</a>
					</td>
					<td class="justify"><h3>une tase de café</h3>
					<td class="center">5.00 €</td>
					<td><input pattern="[0-9]*" min="1" type="number" value="1" name="number"></td>
					<td class="right">15.00 €</td>
				</tr>
				<?php
				endforeach;
				?>
				</tbody>
			</table>
			<form id="belcms_market_buy_confirm_form_sold" action="market/sold">
				<input type="text" placeholder="<?=constant('DISCOUNT_COUPON');?>">
				<input type="submit" value="<?=constant('SAVE');?>">
			</form>
		</div>
		<div id="belcms_market_buy_confirm_detailed">
            <div id="belcms_cart_totals">
                <h3><?=constant('CART_TOTALS');?></h3>
                <table>
                    <tr><td><?=constant('NUMBER_OF_PURCHASES');?><td><td><?=$nbBuy;?></td></tr>
                    <tr><td><?=constant('CART_SUBTOTAL');?><td><td><?=$nbPrice;?> €</td></tr>
                    <tr><td><?=constant('SHIPPING_TOTAL');?><td><td><?=$nbDelivry;?> €</td></tr>
					<tr><td><?=constant('TAXE_TOTAL');?><td><td>0 €</td></tr>
                    <tr><td><?=constant('TOTAL');?><td><td><?=$nbTotal;?> €</td></tr>
                </table>
                <button class="belcms_bg_grey"><?=constant('PROCEED_TO_CHECKOUT');?></button>
            </div>
		</div>
	</div>
</section>
