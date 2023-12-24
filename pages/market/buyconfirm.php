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
$activeTVA             = false;
$nbBuy                 = (int) 0;
$nbPriceBuyDelivry     = (int) 0;
$item_total            = (int) 0;
$tvaPriceTotal         = (int) 0;
$delivrytotal          = (int) 0;
$delivryMax            = (int) 0;
foreach ($order as $k => $v) {
	if ($v->infos->remaining == 0) {
		$v->infos->remaining = 999;
	}
	$a = $v->infos->remaining - $v->infos->buy;
	if ($v->number > $a) {
		$nbBuy     = (int) $nbBuy + (int) $a;
		$order[$k]->number = $a;
	} else if ($v->number <= $a) {
		$nbBuy     = (int) $v->number + $nbBuy;
		$order[$k]->number = $v->number;
	}
	if ($v->infos->tva == 1) {
		if (isset($_SESSION['MARKET']['SOLD'])) {
			if ($_SESSION['MARKET']['SOLD']['predefined'] == 'NO_TAXE' or $_SESSION['MARKET']['SOLD']['predefined'] == 'NO_TAXE_NO_DELIVRY')
			{
				$order[$k]->tvaUniquePrice = 0;
				$tvaPriceTotal = $tvaPriceTotal + 0;
				if ($activeTVA !== true) {
					$activeTVA = false;
				}
			} else {
				$order[$k]->tvaUniquePrice = ($v->infos->amount /100) * $v->tva;
				$tvaPriceTotal  = $tvaPriceTotal + ($order[$k]->tvaUniquePrice * $order[$k]->number);
				$tvaPriceTotal  = round($tvaPriceTotal,2);
				$activeTVA = true;
			}
		} else {
			$order[$k]->tvaUniquePrice = 0;
			$tvaPriceTotal = $tvaPriceTotal + 0;
			if ($activeTVA !== true) {
				$activeTVA = false;
			}	
		}
	} else {
		$order[$k]->tvaUniquePrice = 0;
		$tvaPriceTotal = $tvaPriceTotal + 0;
		if ($activeTVA !== true) {
			$activeTVA = false;
		}
	}
	if ($v->infos->delivery_price != 0) {
		$delivryMax = $delivryMax + $v->infos->delivery_price;
		if ($delivryMax > $v->infos->delivery_price) {
			$delivryMax = $v->infos->delivery_price;
		}
		if (isset($_SESSION['MARKET']['SOLD'])) {
			if ($_SESSION['MARKET']['SOLD']['predefined'] == 'ONE_LIVRAISON') {
				$delivrytotal = $delivryMax;
			} else {
				if (isset($_SESSION['MARKET']['SOLD'])) {
					if ($_SESSION['MARKET']['SOLD']['predefined'] == 'NO_DELIVRY' or $_SESSION['MARKET']['SOLD']['predefined'] == 'NO_TAXE_NO_DELIVRY') {
						$delivrytotal = $delivrytotal + 0;
					} else {
						$delivry = $order[$k]->number * $v->infos->delivery_price;
						$delivrytotal = $delivrytotal + $delivry;
					}
				} else {
					$delivrytotal = $delivrytotal + 0;
				}
			}
		}
	} else {
		$delivrytotal = $delivrytotal + 0;
	}
	$item_total   = $item_total + ($order[$k]->number * $v->infos->amount);
	$nbPriceTotal = $item_total + $tvaPriceTotal + $delivrytotal;
}
if (isset($_SESSION['MARKET']['SOLD'])) {
	$nbPriceTotal = $nbPriceTotal - $_SESSION['MARKET']['SOLD']['value'];
}
if (constant('PAYPAL_SANDBOX') == 'true') {
	$clientIDPaypal = constant('PAYPAL_SANDBOX_CLIENT_ID');
} else {
	$clientIDPaypal = constant('PAYPAL_PROD_CLIENT_ID');
}
if (!empty($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'])) {
	$name = $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
} else {
	$name = $_SESSION['CONFIG_CMS']['HOST'];
}
$dateTime = new \DateTime('NOW');
$dateTime = date_format($dateTime,'Y-d-m H:i:s'); 
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$clientIDPaypal;?>&currency=<?=constant('PAYPAL_CURRENCY');?>&intent=capture"></script>
<script type="text/javascript">
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [
            {
                description: "<?=$name;?>",
                custom_id: "<?=$_SESSION['PAYPAL']['UNIQUE_ID'];?>",
                amount: {
                    "currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
                    "value": <?=$nbPriceTotal;?>,
                    "breakdown": {
                        "item_total": {
                            "currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
                            "value": <?=$item_total;?>
						},
						<?php
						if (isset($_SESSION['MARKET']['SOLD'])) {
						?>
							"discount": {
								"currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
								"value": "<?=$_SESSION['MARKET']['SOLD']['value'];?>"
							},
						<?php
						}
						if ($delivrytotal != 0) {
						?>
							"shipping": {
								"currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
								"value": <?=$delivrytotal;?>
							},
						<?php
						}
						if ($tvaPriceTotal != 0) {
						?>
							"tax_total": {
								"value": "<?=$tvaPriceTotal;?>",
								"currency_code": "<?=constant('PAYPAL_CURRENCY');?>"
							}
						<?php
						}
						?>
					}
                },
				<?=cartItem($order);?>
            }]
        });
    },onApprove: function(data, actions) {
		return actions.order.capture().then(function(orderData) {
			//console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
			$.ajax({
				type: 'post',
				url: "/Market/PayPalValidate",
				data: orderData,
				success: function(data) {
					$('#alrt_bel_cms').addClass("success").empty().append("<?=constant('THANK_YOU_FOR_PAYMENT');?>");
					setTimeout(function() {
						document.location.href="/market/billing/";
					}, 3500);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(chr.responseText);
				},
				beforeSend:function() {
					$('body').append('<div id="alrt_bel_cms"><?=constant('PAYMENT_IN_PROGRESS');?></div>');
					$('#alrt_bel_cms').animate({ top: 0 }, 500);
				}
			});
		});
	},
	onError(err) {
		window.location.href = "/Market/PayPalError";
		console.log(err);
	}
}).render('#paypal-button-container');
</script>
<section id="belcms_market_buy_confirm">
	<div id="belcms_section_market_confirm_content">
		<div id="belcms_market_buy_confirm_infos">
			<form id="belcms_market_buy_confirm_form_sold" action="market/update" method="post">
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
						$nbBuyCart = $value->number * $value->infos->amount;
					?>
					<tr>
						<td class="belcms_market_buy_confirm_infos_img">
							<a class="image-popup" href="<?=$value->img;?>">
								<img src="<?=$value->img;?>" alt="img_cart_<?=$value->id;?>">
							</a>
						</td>
						<td class="justify"><h3><?=$value->infos->name;?></h3>
						<td class="center"><?=$value->infos->amount;?> €</td>
						<td>
							<input pattern="[0-9]*" min="0" max="<?=$value->infos->remaining;?>" type="number" value="<?=$value->number;?>" name="number[<?=$value->id_command;?>]">
						</td>
						<td class="right"><?=$nbBuyCart;?> €</td>
					</tr>
					<?php
					endforeach;
					?>
					</tbody>
				</table>
				<input class="input_right" type="submit" value="<?=constant('UPDATE_CART');?>">
			</form>
			<form id="belcms_market_buy_confirm_form_sold" action="market/sold" method="post">
				<input type="text" name="sold" placeholder="<?=constant('DISCOUNT_COUPON');?>">
				<input type="submit" value="<?=constant('APPLY');?>">
			</form>
		</div>
		<div id="belcms_market_buy_confirm_detailed">
			<div id="belcms_cart_totals">
				<h3><?=constant('CART_TOTALS');?></h3>
				<table>
					<tr><td><?=constant('NUMBER_OF_PURCHASES');?><td><td><?=$nbBuy;?></td></tr>
					<tr><td><?=constant('CART_SUBTOTAL');?><td><td><?=$item_total;?> €</td></tr>
					<tr><td><?=constant('SHIPPING_TOTAL');?><td><td><?=$delivrytotal;?> €</td></tr>
					<?php
					if ($activeTVA === true):
					?>
					<tr><td><?=constant('TAXE_TOTAL');?><td><td><?=$tvaPriceTotal;?> €</td></tr>
					<?php
					endif;
					?>
					<?php
					if (isset($_SESSION['MARKET']['SOLD'])):
					?>
					<tr><td><?=constant('COUPON');?><td><td>- <?=$_SESSION['MARKET']['SOLD']['value'];?> €</td></tr>
					<?php
					endif;
					?>
					<tr><td><?=constant('TOTAL');?><td><td><?=$nbPriceTotal;?> €</td></tr>
				</table>
				<div id="paypal-button-container"></div>
			</div>
		</div>
	</div>
</section>
<?php
function cartItem ($order)
{
	$i = 0;
	$return = 'items: ['.PHP_EOL;
	foreach ($order as $k => $v):
		$return .= '{'.PHP_EOL;
		$return .= 'name: "'.$v->infos->name.'",'.PHP_EOL;
		$return .= 'unit_amount: {'.PHP_EOL;
		$return .= '	currency_code: "'.constant('PAYPAL_CURRENCY').'",'.PHP_EOL;
		$return .= '	value: "'.$v->infos->amount.'"'.PHP_EOL;
		$return .= '},'.PHP_EOL;
		$return .= 'sku: "'.$v->infos->hash_dls.'",'.PHP_EOL;
		$return .= 'tax: {'.PHP_EOL;
		$return .= '	currency_code: "'.constant('PAYPAL_CURRENCY').'",'.PHP_EOL;
		$return .= '	value: "'.$v->tvaUniquePrice.'"'.PHP_EOL;
		$return .= '},'.PHP_EOL;
		$return .= 'quantity: "'.$v->number.'",'.PHP_EOL;
		$return .= '},'.PHP_EOL;
	endforeach;
	$return .= '],'.PHP_EOL;
	return $return;
}
