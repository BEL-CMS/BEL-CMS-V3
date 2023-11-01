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
<div class="x_panel">
	<div class="x_title">
		<h2>Menu Page</h2>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		<a href="/newsletter?management&page=true" class="btn btn-app">
			<i class="fa fas fa-home"></i> Accueil
		</a>
		<a href="newsletter/parameter?management&page=true" class="btn btn-app">
			<i class="fa fas fa-cogs"></i> Configuration
		</a>
		<a href="/newsletter/tpl?management&page=true" class="btn btn-app">
			<i class="fa far fa-newspaper"></i> Templates
		</a>
		<a href="/newsletter/addtpl?management&page=true" class="btn btn-app">
			<i class="fa fas fa-plus"></i> Ajouter
		</a>
	</div>
</div>

<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-body">
			<div class="table-responsive">
				<table id="datatableDl" class="table table-striped jambo_table bulk_action">
					<thead>
						<tr>
							<th># ID</th>
							<th>Template</th>
							<th>Date de publication</th>
							<th>Auteur</th>
							<th>Options</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th># ID</th>
							<th>Template</th>
							<th>Date de publication</th>
							<th>Auteur</th>
							<th>Options</th>
						</tr>
					</tfoot>
					<tbody>
					<?php
					foreach ($data as $a => $b):
						?>
						<tr>
							<td><?=$b->id?></td>
							<td><?=$b->name?></td>
							<td><?=$b->date?></td>
							<td><?=Users::hashkeyToUsernameAvatar($b->author)?></td>
							<td>
								<a href="/newsletter/edittpl/<?=$b->id?>?management&page=true"><i class="fas fa-pen"></i></a> - 
								<a href="#" data-toggle="modal" data-target="#modal_<?=$b->id?>"><i class="fas fa-trash-alt"></i></a>
								<div class="modal fade" id="modal_<?=$b->id?>" tabindex="-1" role="dialog" aria-labelledby="DownloadsModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="DownloadsModalLabel"><?=$b->name?></h4>
											</div>
											<div class="modal-body">Confirmer la suppression du fichier : <?=$b->name?></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
												<button onclick="window.location.href='/newsletter/deltpl/<?=$b->id?>?management&page=true'" type="button" class="btn btn-primary">Supprimer</button>
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
	</div>
</div>