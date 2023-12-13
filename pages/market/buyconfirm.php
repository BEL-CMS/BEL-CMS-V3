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
$nbBuy     = (int) 0;
$nbPrice   = (int) 0;
$nbTotal   = (int) 0;
$nbDelivry = (int) 0;
foreach ($order as $k => $v) {
	$a = $v->infos->remaining - $v->infos->buy;
	if ($v->number > $a) {
		$nbBuy     = (int) $nbBuy + (int) $a;
		$order[$k]->number = $a;
		$nbPrice   = $a * $v->infos->amount;
		$nbDelivry = $nbBuy * $v->infos->delivery_price;
	} else if ($v->number <= $a) {
		$nbBuy     = (int) $v->number + $nbBuy;
		$order[$k]->number = $v->number;
		$nbPrice   = $v->number * $v->infos->amount;
		$nbDelivry = $nbBuy * $v->infos->delivery_price;
	}
	$nbTotal = $nbTotal + $nbPrice + $nbDelivry;
	if ($v->infos->tva == 1) {
		$order[$k]->tva = $nbPrice /100 * $tva;
		$nbTotal = $nbTotal + $order[$k]->tva;
	} else {
		$order[$k]->tva = 0;
	}
}

if (constant('PAYPAL_SANDBOX') == true) {
	$clientIDPaypal = constant('PAYPAL_SANDBOX_CLIENT_ID');
} else {
	$clientIDPaypal = constant('PAYPAL_PROD_CLIENT_ID');
}
if (!empty($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'])) {
	$name = $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
} else {
	$name = $_SESSION['CONFIG_CMS']['HOST'];
}
$currency = "EUR"; 
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=$clientIDPaypal;?>&currency=<?=$currency;?>"></script>
<script type="text/javascript">
paypal.Buttons({
    createOrder: (data, actions) => {
        return actions.order.create({
            "purchase_units": [{
                "custom_id": "<?=$purchase;?>",
                "description": "<?=$name;?>",
                "amount": {
                    "currency_code": "<?=$currency; ?>",
                    "value": <?=$nbTotal;?>,
                    "breakdown": {
                        "item_total": {
                            "currency_code": "<?=$currency;?>",
                            "value": <?=$nbTotal;?>
                        }
                    }
                }
            }]
        });
    },
    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
            setProcessing(true);
            var postData = {paypal_order_check: 1, order_id: orderData.id};
            fetch('/Market/validate', {
                method: 'POST',
                headers: {'Accept': 'application/json'},
                body: encodeFormData(postData)
            })
            .then((response) => response.json())
            .then((result) => {
                if(result.status == 1){
                    window.location.href = "/Market/status?checkout_ref_id="+result.ref_id;
					alert(result.ref_id);
                }
                setProcessing(false);
            })
            .catch(error => console.log(error));
        });
    }
}).render('#paypal-button-container');

const encodeFormData = (data) => {
  var form_data = new FormData();
  for ( var key in data ) {
    form_data.append(key, data[key]);
  }
  return form_data;   
}
const setProcessing = (isProcessing) => {
    if (isProcessing) {
        document.querySelector(".overlay").classList.remove("hidden");
    } else {
        document.querySelector(".overlay").classList.add("hidden");
    }
}
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
							<input pattern="[0-9]*" min="1" max="<?=$value->infos->remaining;?>" type="number" value="<?=$value->number;?>" name="id[<?=$value->id_command;?>][number]">
							<input type="hidden" name="id[<?=$value->id_command;?>]">
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
                    <tr><td><?=constant('CART_SUBTOTAL');?><td><td><?=$nbPrice;?> €</td></tr>
                    <tr><td><?=constant('SHIPPING_TOTAL');?><td><td><?=$nbDelivry;?> €</td></tr>
					<?php
					if ($v->infos->tva == 1):
					?>
					<tr><td><?=constant('TAXE_TOTAL');?><td><td><?=$value->tva;?> €</td></tr>
					<?php
					endif;
					?>
					<?php
					if (isset($_SESSION['MARKET']['SOLD'])):
					?>
					<tr><td><?=constant('COUPON');?><td><td>- <?=$_SESSION['MARKET']['SOLD']['value'];?> €</td></tr>
					<?php
					$nbTotal = $nbTotal - $_SESSION['MARKET']['SOLD']['value'];
					endif;
					?>
                    <tr><td><?=constant('TOTAL');?><td><td><?=$nbTotal;?> €</td></tr>
                </table>
				<div id="paypal-button-container"></div>
            </div>
		</div>
	</div>
</section>