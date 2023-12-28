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
if (!empty($last_name)) {
	$lastName  = '<tr>';
	$lastName .= '<td>'.constant('LAST_NAME').'</td>';
	$lastName .= '<td>'.$last_name.'</td>';
	$lastName .= '</tr>';
} else {
	$lastName = '';
}
if (!empty($_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'])) {
	$nameHost = $_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];
} else {
	$nameHost = $_SESSION['CONFIG_CMS']['HOST'];
}
$donDesc = constant('DONATION_DESC').$nameHost;
if ($type == 'paypal'):
	?>
	<section id="section_donation">
		<table class="belcms_grid_8">
			<thead>
				<tr><th colspan="2"><?=constant('DONATIONS');?></th></tr>
			</thead>
			<tbody>
				<tr>
					<td><?=constant('DONOR');?></td>
					<td><?=$user;?></td>
				</tr>
				<?=$lastName;?>
				<tr>
					<td><?=constant('EMAIL_ADRESS');?></td>
					<td><?=$mail;?></td>
				</tr>
				<tr>
					<td><?=constant('TOTAL_DONATION');?></td>
					<td><?=$donate;?> <?=constant('PAYPAL_CURRENCY');?></td>
				</tr>
				<tr>
					<td><?=constant('PAYMENT_METHOD');?></td>
					<td><?=constant('PAYPAL');?></td>
				</tr>
			</tbody>
		</table>
		<div id="paymentStyle" class="belcms_grid_4">
			<div id="paypal-button-container"></div>
		</div>
	</section>

	<script src="https://www.paypal.com/sdk/js?client-id=<?=constant('PAYPAL_PROD_CLIENT_ID');?>&currency=<?=constant('PAYPAL_CURRENCY');?>&intent=capture"></script>
		<script type="text/javascript">
		paypal.Buttons({
			createOrder: function(data, actions) {
				return actions.order.create({
					purchase_units: [
					{
						description: "<?=$donDesc;?>",
						custom_id: "<?=$_SESSION['DONS']['UNIQUE_ID'];?>",
						amount: {
							"currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
							"value": <?=$donate;?>,
							"breakdown": {
								"item_total": {
									"currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
									"value": <?=$donate;?>
								},
								
							}
						}
					}]
				});
			},onApprove: function(data, actions) {
				return actions.order.capture().then(function(orderData) {
					$.ajax({
						type: 'post',
						url: "/Donation/Validate",
						data: orderData,
						success: function(data) {
							$('#alrt_bel_cms').addClass("success").empty().append("<?=constant('THANK_YOU_FOR_DONATE');?>");
							setTimeout(function() {
								document.location.href="/Donation";
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
				window.location.href = "/Donation/PayPalError";
				console.log(err);
			}
		}).render('#paypal-button-container');
		</script>
	<?php
elseif ($type == 'payment'):
	?>
	<section id="section_donation">
		<div class="donation_purchase_row">
            <div class="donation_purchase_row_line_full">
				<table class="belcms_grid_12">
					<thead>
						<tr><th colspan="2"><h3><?=constant('DONATION_BY_TRANSFERT');?></h3></th></tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2"><p><?=constant('MSG_PAIE');?></p></td>
						</tr>
						<tr>
							<td><?=constant('NAME');?></td>
							<td><?=$BC->name;?></td>
						</tr>
						<?php
						if (!empty($BC->last_name)):
						?>
						<tr>
							<td><?=constant('LAST_NAME');?></td>
							<td><?=$BC->last_name;?></td>
						</tr>
						<?php
						endif;
						if (!empty($BC->adress)):
						?>
						<tr>
							<td><?=constant('ADRESS_POSTAL');?></td>
							<td><?=$BC->adress;?></td>
						</tr>
						<?php
						endif;
						?>
						<tr>
							<td><?=constant('ACCOUNT_NUMBER');?></td>
							<td><?=$BC->iban;?></td>
						</tr>
						<tr>
							<td><?=constant('BIC');?></td>
							<td><?=$BC->bic;?></td>
						</tr>
						<tr>
							<td><?=constant('COMMUNICATION');?></td>
							<td><?=constant('FIRST_NAME_PSEUDO');?>
						</tr>
						<tr>
							<td><?=constant('DONATION_PLEDGE');?></td>
							<td><?=$donate;?> <?=constant('PAYPAL_CURRENCY');?></td>
						</tr>
						<tr>
							<td colspan="2">
								<form action="Donation/Pledge" method="post">
									<input type="hidden" name="donate" value="<?=$donate;?>">
									<input type="hidden" name="mail" value="<?=$mail;?>">
									<input type="hidden" name="last_name" value="<?=$last_name;?>">
									<input type="hidden" name="msg" value="<?=$msg;?>">
									<input id="promise" type="submit" value="<?=constant('I_PROMISE');?>">
								</form>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<?php
endif;