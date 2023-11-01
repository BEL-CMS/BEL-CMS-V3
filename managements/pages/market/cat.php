<?php
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
<div class="card">
	<div class="card-header">
		<h3 class="card-title"><?=MARKET;?></h3>
	</div>
	<div class="card-body">
		<table class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
			<thead>
				<tr>
					<th><?=ID?></th>
					<th><?=NAME?></th>
					<th><?=GROUPS?></th>
					<th><?=OPTIONS?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($cat as $v):
					?>
					<tr>
						<td><?=$v->id?></td>
						<td><?=$v->name?></td>
						<td><?=$v->groups?></td>
						<td>
							<a href="/market/editcat/<?=$v->id;?>?management&pages" class="btn btn btn-primary btn-sm mb-1">Edit</a>
							<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id;?>" class="btn btn btn-danger btn-sm mb-1">Supprimer</a>
							<div class="modal fade" id="modal_<?=$v->id;?>" tabindex="-1" role="dialog" aria-labelledby="MarketModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="MarketModalLabel"><?=$v->name;?></h4>
										</div>
										<div class="modal-body">Confirmer la suppression de la catégorie : <?=$v->name;?></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal"><?CLOSE?></button>
											<button onclick="window.location.href='/market/delcat/<?=$v->id?>?management&pages'" type="button" class="btn btn-primary"><?=DELETE?></button>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					<?php
				endforeach;
				?>
			</tbody>
		</table>
	</div>
</div>