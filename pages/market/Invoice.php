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
$genered = new DateTime('NOW');
$genered = date_format($genered,'d-m-Y , H:i:s'); 
debug($billing, false);
debug($adress, false);
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
				<h1>Bel-CMS</h1><span>Facture</span>
			</header>
			<div id="belcms_market_invoice_date_number">
				<span><b>Date</b>: <?=Common::TransformDate($billing->date_purchase, 'MEDIUM', 'LONG');?></span>
				<span><b>Facture N°</b>: <?=$billing->id_purchase;?></span>
			</div>
			<div id="belcms_market_invoice_infos_users">
				<div id="belcms_market_invoiced_to">
					<h2>Facture De :</h2>
					<p><?=$billing->given_name;?> <?=$billing->surname;?> 
					<p>Rue du Wairchat, 94</p>
					<p>6240, Farciennes</p>
					<p>Belgique</p>
				</div>
				<div id="belcms_market_pay_to">
					<h2>Payer à :</h2>
					<p>Bel-CMS</p>
					<p>https://bel-cms.dev</p>
					<p>Belgique</p>
				</div>
			</div>
			<div id="belcms_market_invoice_table">
				<table>
					<thead>
						<tr>
							<th><?=constant('PRODUCT');?></th>
							<th><?=constant('DESCRIPTION');?></th>
							<th class="center"><?=constant('PRICE');?></th>
							<th class="center"><?=constant('QUANTITY');?></th>
							<th class="right"><?=constant('AMOUNT');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$item = explode(',',$billing->item);
						foreach ($item as $key => $value):
							$getExplode = explode('=', $value);
							$getItem[$key][$getExplode[0]] = $getExplode[1];
						endforeach;
						?>
						<?php
						debug($getItem, false);
						?>
					</tbody>
					<tfoot>
						<tr>
							<th class="right" colspan="4">Sous-total</th>
							<th class="right">75.00 €</th>
						</tr>
						<tr>
							<th class="right" colspan="4">Taxe</th>
							<th class="right">1.25 €</th>
						</tr>
						<tr>
							<th class="right" colspan="4">Livraison</th>
							<th class="right">1.00 €</th>
						</tr>
						<tr>
							<th class="right" colspan="4">Réduction</th>
							<th class="right">- 1.00 €</th>
						</tr>
						<tr>
							<th class="right" colspan="4">Total</th>
							<th class="right">80.00 €</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div id="genered">Facture générer le : <?=$genered;?> </div>
		</section>
	</body>
</html>