<?php
debug($data, false);
?>
<section id="section_pricing">
	<div class="pricing_purchase_row">
		<div class="pricing_purchase_row_line_full">
			<table>
				<thead>
					<tr><th colspan="2"><h3>ghjghjghj</h3></th></tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="2"><p><ghjgjhg</p></td>
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
						<td><?=$data->price;?></td>
						<td>€</td>
					</tr>
					<tr>
						<td colspan="2">
							<form action="pricing/Preorder" method="post">
								<input type="hidden" value="<?=$data->price;?>" name="price">
								<input type="hidden" value="<?=$data->id;?>" name="id">
								<input type="submit" value="Précommander">
							</form>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>