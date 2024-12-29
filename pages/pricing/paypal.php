<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.1.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<script src="https://www.paypal.com/sdk/js?client-id=<?=constant('PAYPAL_PROD_CLIENT_ID');?>&currency=<?=constant('PAYPAL_CURRENCY');?>&intent=capture"></script>
<script type="text/javascript">
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [
            {
                custom_id: "<?=$id_order;?>",
                amount: {
                    "currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
                    "value": <?=$plan->price;?>,
                    "breakdown": {
                        "item_total": {
                            "currency_code": "<?=constant('PAYPAL_CURRENCY');?>",
                            "value": <?=$plan->price;?>
                        },
                        
                    }
                }
            }]
        });
    },onApprove: function(data, actions) {
        return actions.order.capture().then(function(orderData) {
            $.ajax({
                type: 'post',
                url: "/pricing/PayPalValidate",
                data: orderData,
                success: function(data) {
                    $('#alrt_bel_cms').addClass("success").empty().append("<?=constant('THANK_YOU_FOR_BUY');?>");
                    setTimeout(function() {
                        document.location.href="/pricing/Myorders";
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
        window.location.href = "/pricing/PayPalError";
        console.log(err);
    }
}).render('#paypal-button-container');
</script>
<div id="paymentStyle">
    <div id="paypal-button-container"></div>
</div>
