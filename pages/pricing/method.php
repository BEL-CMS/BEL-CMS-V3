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
<table id="belcms_sepa">
    <tr>
        <td colspan="2"><h1>Méthode de paiement</h1></td>
    </tr>
    <tr>
        <td><a href="pricing/payment/<?=$id;?>"><img src="pages/pricing/virement_logo.png" alt="Virement"></a></td>
        <td><a href="pricing/paymentPaypal/<?=$id;?>"><img src="pages/pricing/paypal.png" alt="PayPal"></a></td>
    </tr>
</table>