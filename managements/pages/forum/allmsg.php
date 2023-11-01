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
		<h3 class="card-title">Forum Messages</h3>
	</div>
	<div class="card-body">
		<table  class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
		<thead>
			<tr>
				<th># ID</th>
				<th># ID POST</th>
				<th>Auteur</th>
				<th>Date du message</th>
				<th>Like / Report</th>
				<th>Options</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th># ID</th>
				<th># ID POST</th>
				<th>Auteur</th>
				<th>Date du message</th>
				<th>Like / Report</th>
				<th>Options</th>
			</tr>
		</tfoot>
		<tbody>
			<?php
			foreach ($data as $key => $v) {
				?>
				<tr>
					<td><?=$v->id;?></td>
					<td><?=$v->id_post;?></td>
					<td style="color:<?=Users::colorUsername($v->author)?>"><?=Users::hashkeyToUsernameAvatar($v->author)?></td>
					<td><?=$v->date_post;?></td>
					<td><?=$v->options['like']?> / <?=$v->options['report']?></td>
					<td class="td-actions">
						<a href="/Forum/EditMessage/<?=$v->id?>?management&pages" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
						<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn-danger"><i class="fa fa-times"></i></a>
						<div class="modal fade" id="modal_<?=$v->id?>" data-toggle="tooltip" title="Delete" tabindex="-1" role="dialog" aria-labelledby="modal">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="modal"><?=$v->id?></h4>
									</div>
									<div class="modal-body">Confirmer la suppression du message id : <?=$v->id;?><br>
										<?=$v->content?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
										<button onclick="window.location.href='/Forum/delMessage/<?=$v->id?>?management&pages'" type="button" class="btn btn-primary">Supprimer</button>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	   </table>  
		</div>
	</div>
</div>