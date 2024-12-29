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

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$genered    = new DateTime('NOW');
$genered    = date_format($genered,'d/m/Y');
$genered    = Common::TransformDate($genered, 'MEDIUM', 'NONE');
$infos = User::getInfosUserAll($invoice->author);
$author = $infos->user->username;
$mail   = $infos->user->mail;
$per = defined(strtoupper($pricing->per)) ? constant($pricing->per) : $pricing->per;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Facture : Server</title>
		<link rel='stylesheet' href='/pages/pricing/css/invoice.css' type='text/css'>
	</head>
	<body>
        <div id="invoice">
            <h1>Facture</h1>
            <hr>
            <div id="invoice_infos">
                <div>
                    <ul>
                        <li><span>De :</span></li>
                        <li>Bel-CMS</li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><span>Facturé à</span></li>
                        <li><?=$author;?></li>
                        <li><?=$mail;?></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><span>Facture générée le : </span><?=$genered;?></li>
                        <li><span>Facture d'achat :</span> <?=Common::TransformDate($invoice->date_insert, 'MEDIUM', 'NONE');?></li>
                        <li><span>N° d'achat :</span> <?=$invoice->id_order;?></li>
                    </ul>
                </div>
            </div>
            <hr>
            <table id="table_invoice">
                <thead>
                    <tr>
                        <td>Description</td>
                        <td>Durée</td>
                        <td>Montant</td>
                    </tr>
                    <tr>
                        <td><?=$pricing->name;?></td>
                        <td><?=$per;?></td>
                        <td><?=str_replace('.',' , ', number_format($pricing->price, 2));?> €</td>
                    <tr>
                    <tr>
                        <td colspan="3">
                            <ul id="table_invoice_ul">
                                <?php
                                foreach ($list as $value):
                                ?>
                                <li><?=$value;?></li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </td>
                    </tr>
                </thead>
            </table>
            <hr>
            <textarea>Le paiement a été effectué et, de ce fait, ne pourra pas être remboursé.</textarea>
        </div>
	</body>
</html>