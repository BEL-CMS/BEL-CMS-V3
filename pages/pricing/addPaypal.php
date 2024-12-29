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

$per = defined(strtoupper($plan->per)) ? constant($plan->per) : $plan->per;
?>
<form method="post" action="pricing/valid_paypal/<?=$plan->id;?>">
    <table id="belcms_pricing_table">
        <tbody>
            <tr>
                <td>Nom</td>
                <td><?=$plan->name;?></td>
            </tr>
            <tr>
                <td>Durée</td>
                <td><?=$per;?></td>
            </tr>
            <tr>
                <td>Prix</td>
                <td><?=str_replace('.', ' , ', number_format($plan->price, 2));?> €</td>
            </tr>
            <tr>
                <td colspan="2">Description</td>
            </tr>
            <tr>
                <td colspan="2"><?=$plan->description;?></td>
            </tr>
            <tr>
                <td><input type="text" name="mail" placeholder="Réservé un mail"></td>
                <td><input type="text" name="url" placeholder="Réservé un sous-domaine https://xyz.bel-cms.dev"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="hidden" value="<?=$plan->id;?>" name="plan_id">
                    <input type="submit" class="belcms_btn belcms_bg_grey" value="Payé">
                </td>
            </tr>
        </tfoot>
    </table>
</form>