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

use BelCMS\Core\Notification;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<table id="belcms_pricing_table">
    <tr>
        <td>Nom</td>
        <td><?=$_SESSION['CONFIG_CMS']['CMS_ACCOUNT_NAME'];?></td>
    </tr>
    <tr>
        <td>Compte bancaire</td>
        <td><?=$_SESSION['CONFIG_CMS']['CMS_ACCOUNT'];?></td>
    </tr>
    <tr>
        <td>BIC&nbsp;&nbsp;( IBAN )</td>
        <td><?=$_SESSION['CONFIG_CMS']['CMS_ACCOUNT_BIC'];?></td>
    </tr>
    <tr>
        <td>Montant</td>
        <td><?=str_replace('.', ' , ', number_format($plan->price, 2));?>&nbsp;€</td>
    </tr>
    <tr>
        <td>Comunication</td>
        <td><?=$plan->name;?> / <?=$_SESSION['USER']->user->username;?></td>
    </tr>
    <tr>
        <td colspan="2"><a class="belcms_btn belcms_bg_grey" href="pricing/Myorders">Mes commandes</a></td>
    </tr>
</table>
<?php
Notification::success('Le Service sera effectif une fois le paiement reçus et débutera à la date du jour.', 'Paiement');