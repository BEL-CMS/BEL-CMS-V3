<?php
use BelCMS\Requires\Common;
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.2]
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
?>
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

use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
debug($data, false);
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('PAYMENT');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead>
							<tr>
								<th><?=constant('NAME');?></th>
								<th><?=constant('DATE_OF_RELEASE');?></th>
								<th><?=constant('COST');?></th>
								<th><?=constant('ID_PAYPAL');?></th>
								<th><?=constant('STATUS');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?=constant('NAME');?></th>
								<th><?=constant('DATE_OF_RELEASE');?></th>
								<th><?=constant('COST');?></th>
								<th><?=constant('ID_PAYPAL');?></th>
								<th><?=constant('STATUS');?></th>
								<th><?=constant('OPTIONS');?></th>
							</tr>
						</tfoot>
						<tbody>
							<?php
							foreach ($data as $value):
								$author = User::getInfosUserAll($value->author)->user->username;
								$date   = Common::TransformDate($value->date_purchase, 'MEDIUM', 'SHORT');
								$idPaypal = Common::decrypt($value->id_paypal, $value->author);
								switch ($value->status):
									case '0':
										$status = '<i class="etat_0">'.constant('ETAT_0').'</i>';
									break;
				
									case '1':
										$status = '<i class="etat_1">'.constant('ETAT_1').'</i>';
									break;
				
									case '2':
										$status = '<i class="etat_2">'.constant('ETAT_2').'</i>';
									break;
				
									case '3':
										$status = '<i class="etat_3">'.constant('ETAT_3').'</i>';
									break;
				
									case '4':
										$status = '<i class="etat_4">'.constant('ETAT_4').'</i>';
									break;
								endswitch;
								$option  = '<a class="opt_sts belcms_tooltip_top" data="Contacté le client" href="/Mails/New?user='.$author.'"><i class="mgc_service_line"></i></a>';
								$option .= '<a class="opt_sts belcms_tooltip_top" data="Changer en attente de livraison" href="Market/attLivriason/'.$value->id.'?management&option=pages"><i class="mgc_shopping_cart_2_fill"></i></a>';
								$option .= '<a class="opt_sts belcms_tooltip_top" data="livraison effectuée" href="Market/livraisonOk/'.$value->id.'?management&option=pages"><i class="mgc_exit_fill"></i></a>';
								$option .= '<a class="opt_sts belcms_tooltip_top" data="Facture du client" target="_blank" href="market/Invoice/'.$value->id_purchase.'?echo"><i class="mgc_document_line"></i></a>';
								$option .= '<a class="opt_sts belcms_tooltip_top" data="Effacer l\'achat" href=""market/delInvoice/'.$value->id_purchase.'?echo""><i class="mgc_delete_2_fill"></i></a>';
							?>
							<tr>
								<td><?=$author;?></td>
								<td><?=$date;?></td>
								<td><?=$value->total_pay;?></td>
								<td><?=$idPaypal;?></td>
								<td><?=$status;?></td>
								<td>
									<?=$option;?>
								</td>
							</tr>
							<?php
							endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>