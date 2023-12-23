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
?>
<section id="belcms_billing">
	<h2><?=constant('MY_ORDERS');?></h2>
	<i><?=constant('VIEW_YOUR_HISTORY');?></i>
	<table id="belcms_billing_table">
		<thead>
			<tr>
				<th><?=constant('DATE');?></th>
				<th><?=constant('ORDER_NUMBER');?></th>
				<th><?=constant('ETAT');?></th>
				<th colspan="2"><?=constant('CART_TOTALS');?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($billing as $value):
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
			?>
			<tr>
				<td><?=Common::TransformDate($value->date_purchase, 'MEDIUM', 'NONE');?></td>
				<td><?=$value->id_purchase;?></td>
				<td><?=$status;?></td>
				<td><?=$value->total_pay;?> €</td>
				<td>
					<a class="belcms_tooltip_top" data="<?=constant('INVOICE');?>" href="Market/Invoice/<?=$value->id_purchase;?>?echo"><i class="fa-solid fa-file-invoice-dollar"></i></a>
					<?php
					if (isset($value->link) and $value->link === true):
					?>
						&ensp;<a class="belcms_tooltip_top" data="<?=constant('DOWNLOADS_PAGE');?>" href="Market/dls/<?=$value->id_purchase;?>"><i class="fa-solid fa-download"></i></a>
					<?php
					endif;
					?>
				</td>
			</tr>
			<?php
			endforeach;
			?>
		</tbody>
	</table>
<?php
if (!empty($pagination)):
?>
	<div class="bel_cms_index_footer">
		<?=$pagination?>
	</div>
<?php
endif;
?>
</section>