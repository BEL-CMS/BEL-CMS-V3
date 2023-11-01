<?php
/**
 * Bel-CMS [Content management system]
 * @version 2.1.0
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2022 Bel-CMS
 * @author as Stive - stive@determe.be
 */

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Liste des équipes</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table class="DataTableBelCMS table">
			<thead>
				<tr>
					<th># ID</th>
					<th>Nom</th>
					<th>Déscription</th>
					<th>NB° utilisateur</th>
					<th>Options</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th># ID</th>
					<th>Nom</th>
					<th>Déscription</th>
					<th>NB° utilisateur</th>
					<th>Options</th>
				</tr>
			</tfoot>
			<tbody>
			<?php
			foreach ($data as $k => $v):
				?>
				<tr>
					<td><?=$v->id?></td>
					<td><?=$v->name?></td>
					<td><?=$v->description?></td>
					<td><?=$v->count?></td>
					<td>
						<a href="Team/player/<?=$v->id?>?management&gaming=true" class="btn btn-small btn-primary"> <i class="fa fa-plus-square"></i></a>
						<a href="team/edit/<?=$v->id?>?management&gaming=true" class="btn btn-small btn-success"><i class="fa fa-share-square-o"></i></a>
						<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn-danger btn-small"><i class="fa fa-minus-circle"></i></a>
						<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="exampleModalLabel"><?=$v->name?></h4>
									</div>
									<div class="modal-body">Confirmer la suppression de la team : <?=$v->name?></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
										<button onclick="window.location.href='/team/del/<?=$v->id?>?management&gaming=true'" type="button" class="btn btn-primary">Supprimer</button>
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