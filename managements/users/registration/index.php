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
<div class="mt-6">
	<div class="card">
		<div class="flex flex-wrap justify-between items-center gap-2 p-6">
			<a href="javascript:void(0);" class="btn bg-danger/20 text-sm font-medium text-danger hover:text-white hover:bg-danger"><i class="mgc_add_circle_line me-3"></i> Ajouté un utilisateur</a>
		</div>
		<div class="relative overflow-x-auto">
			<table class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
				<thead>
					<tr>
						<th class="">#ID</th>
						<th class="">Nom</th>
						<th class="">e-mail</th>
						<th class="">Dernière visite</th>
						<th class="">Date d'inscription</th>
						<th class="">Options</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($user as $k => $v):
						debug($v);
						?>
						<tr>
							<td><?=$v->id;?></td>
							<td><?=$v->username;?></td>
							<td><?=$v->email?></td>
							<td><?=$v->last_visit;?></td>
							<td><?=$v->date_registration;?></td>
							<td>
								<a href="/registration/edit/<?=$v->id?>?management&users" class="btn btn btn-primary btn-sm mb-1">Edit</a>
								<?php
								if ($v->id != 1):
								?>
								<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn btn-danger btn-sm mb-1">Supprimer</a>
								<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="exampleModalLabel"><?=$v->username?></h4>
											</div>
											<div class="modal-body">Confirmer la suppression de l'utilisateur : <?=$v->username?></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
												<button onclick="window.location.href='/registration/del/<?=$v->hash_key?>?management&pages'" type="button" class="btn btn-primary">Confirmer</button>
											</div>
										</div>
									</div>
								</div>
								<?php
								endif
								?>
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