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
		<h3 class="card-title">Forum</h3>
	</div>
	<div class="card-body">
		<table class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
			<thead>
				<tr>
					<th><?=ICON?></th>
					<th><?=NAME?></th>
					<th><?=CATEGORY?></th>
					<th class="td-actions"><?=OPTIONS?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th><?=ICON?></th>
					<th><?=NAME?></th>
					<th><?=CATEGORY?></th>
					<th class="td-actions"><?=OPTIONS?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				foreach ($data as $k => $v):
					?>
					<tr>
						<td><i class="<?=$v->icon?>"></i></td>
						<td><?=$v->title?></td>
						<?php
						if (isset($v->id_forum->title)) {
							?>
							<td><?=$v->id_forum->title?></td>
							<?php
						} else {
							?>
							<td><?=UNKNOWN?></td>
							<?php
						}
						?>
						<td class="td-actions">
							<a href="/Forum/EditForum/<?=$v->id?>?management&page=true">
								<i class="fas fa-pen"> </i>
							</a> - 
							<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>"><i class="fas fa-trash-alt"></i></a>
							<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel"><?=$v->title?></h4>
										</div>
										<div class="modal-body">Confirmer la suppression du sous forum : <?=$v->title?></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
											<button onclick="window.location.href='/Forum/delForum/<?=$v->id?>?management&page=true'" type="button" class="btn btn-primary">Supprimer</button>
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