<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.8 [PHP8.3]
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
$cat_1 = '';
$cat_2 = '';
$cat_3 = '';
$cat_4 = '';
$cat_5 = '';
if (isset($data->listing->cat_1) and !empty($data->listing->cat_1)) {
	if ($data->listing->actif_1 == true) {
		$cat_1 = ' <tr class="choise_table_middle"><td>:</td><td>'.$data->listing->cat_1.'</td></tr>'; 
	}
}
if (isset($data->listing->cat_2) and !empty($data->listing->cat_2)) {
	if ($data->listing->actif_2 == true) {
		$cat_2 = ' <tr class="choise_table_middle"><td>:</td><td>'.$data->listing->cat_2.'</td></tr>'; 
	}
}
if (isset($data->listing->cat_3) and !empty($data->listing->cat_3)) {
	if ($data->listing->actif_3 == true) {
		$cat_3 = ' <tr class="choise_table_middle"><td>:</td><td>'.$data->listing->cat_3.'</td></tr>'; 
	}
}
if (isset($data->listing->cat_4) and !empty($data->listing->cat_4)) {
	if ($data->listing->actif_4 == true) {
		$cat_4 = ' <tr class="choise_table_middle"><td>:</td><td>'.$data->listing->cat_4.'</td></tr>'; 
	}
}
if (isset($data->listing->cat_5) and !empty($data->listing->cat_5)) {
	if ($data->listing->actif_5 == true) {
		$cat_5 = ' <tr class="choise_table_middle"><td>:</td><td>'.$data->listing->cat_5.'</td></tr>'; 
	}
}
$data->per = defined(strtoupper($data->per)) ? constant(strtoupper($data->per)) : $data->per;
?>
<section id="belcms_pricing_choise">
	<table id="belcms_pricing_choise_table">
			<thead>
				<tr><th colspan="2">Plan : <?=$data->name;?></th></tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" id="choise_table_full"><?=$data->description;?></td>
				</tr>
				<tr class="choise_table_middle">
					<td>Prix</td>
					<td><?=$data->price;?> €</td>
				</tr>
				<tr class="choise_table_middle">
					<td>Par</td>
					<td><?=$data->per;?></td>
				</tr>
				<tr>
					<td colspan="2" class="align_center" id="choise_table_full"><b>Option du Plan</b></td>
				</tr>
				<?php echo $cat_1.$cat_2.$cat_3.$cat_4.$cat_5; ?>
			</tbody>
			<tfoot>
				<tr>
					<th>
						<form action="pricing/sale" method="post">
							<input type="hidden" name="id" value="<?=$data->id;?>">
							<input type="submit" value="Payer par virement bancaire">
						</form>
					</th>
				</tr>
			</tfoot>
		</table>
	</section>

</section>