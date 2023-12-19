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
$genered    = new DateTime('NOW');
$genered    = date_format($genered,'d-m-Y , H:i:s'); 
$itemsArray = array();
$items      = array();
$item = explode('|',$billing->item);
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
		$items[$v[0]][] = $v[1];
	}
}
$logo = !empty(constant('PAYPAL_LOGO')) ? '<img src="'.constant('PAYPAL_LOGO').'">': '';
$adressV = explode('|', constant('PAYPAL_ADRESS'));
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Facture : ID</title>
		<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>
		<link rel='stylesheet' href='/pages/market/css/invoice.css' type='text/css'>
	</head>
	<body>
		<section id="belcms_market_invoice">
			<header>
				<?=$logo;?><h1><?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];?> </h1><span>Facture</span>
			</header>
			<div id="belcms_market_invoice_date_number">
				<span><b><?=constant('DATE');?></b>: <?=Common::TransformDate($billing->date_purchase, 'MEDIUM', 'LONG');?></span>
				<span><b><?=constant('INVOICE_NO');?></b>: <?=$billing->id_purchase;?></span>
			</div>
			<div id="belcms_market_invoice_infos_users">
				<div id="belcms_market_invoiced_to">
					<h2><?=constant('INVOICE_FROM');?></h2>
					<p><?=$adress->name;?> <?=$adress->first_name;?> 
					<p><?=$adress->address;?></p>
					<p><?=$adress->postal_code;?>, <?=$adress->city;?></p>
					<p><?=$adress->country;?></p>
				</div>
				<div id="belcms_market_pay_to">
					<h2><?=constant('PAY_TO');?></h2>
					<p><?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];?></p>
					<p><?=$adressV[0];?></p>
					<p><?=$adressV[1];?></p>
					<p><?=$_SESSION['CONFIG_CMS']['HOST'];?></p>
					<p><?=constant('PAYPAL_COUNTRY');?></p>
				</div>
			</div>
			<div id="belcms_market_invoice_table">
				<table>
					<thead>
						<tr>
							<th style="width: 55%;"><?=constant('PRODUCT');?></th>
							<th style="width: 15%;" class="center"><?=constant('PRICE');?></th>
							<th style="width: 15%;" class="center"><?=constant('QUANTITY');?></th>
							<th style="width: 15%;" class="right"><?=constant('AMOUNT');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($items['name'] as $key => $name):
						?>
						<tr>
							<td><?=$name;?></td>
							<td class="center"><?=$items['value'][$key];?> <?=$items['currency_code'][$key];?></td>
							<td class="center"><?=$items['quantity'][$key];?></td>
							<td class="right"><?=$items['value'][$key] * $items['quantity'][$key];?> <?=$items['currency_code'][$key];?></td>
						<tr>
						<?php
						endforeach;
						?>
					</tbody>
					<tfoot>
						<tr>
							<th class="right" colspan="3"><?=constant('CART_SUBTOTAL');?></th>
							<th class="right"><?=$billing->sub_total;?> <?=$items['currency_code'][0];?></th>
						</tr>
						<tr>
							<th class="right" colspan="3"><?=constant('TAXE_TOTAL');?></th>
							<th class="right"><?=$billing->taxe;?></th>
						</tr>
						<tr>
							<th class="right" colspan="3"><?=constant('SHIPPING_TOTAL');?></th>
							<th class="right"><?=$billing->shipping;?></th>
						</tr>
						<tr>
							<th class="right" colspan="3"><?=constant('DISCOUNT_COUPON');?></th>
							<th class="right">- <?=$billing->discount;?></th>
						</tr>
						<tr>
							<th class="right" colspan="3">Total</th>
							<th class="right"><?=$billing->total_pay;?> <?=$items['currency_code'][0];?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div id="genered">Facture générer le : <?=$genered;?> </div>
		</section>
	</body>
</html>