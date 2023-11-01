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
		<h3 class="card-title">Liste des blog</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="card-body">
			<div class="table-responsive col-lg-12 col-md-12 col-sm-12">
				<table  class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
					<thead>
						<tr>
							<th>Emoticônes</th>
							<th>Noms</th>
							<th>Codes</th>
							<th>Emplacements</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Emoticônes</th>
							<th>Noms</th>
							<th>Codes</th>
							<th>Emplacements</th>
						</tr>
					</tfoot>
					<tbody>
					<?php
					foreach ($imo as $k => $v):
						?>
						<tr>
							<td><img src="<?=$v->dir?>"></td>
							<td><?=$v->name?></td>
							<td><?=$v->code?></td>
							<td><?=$v->dir?></td>
							<td>
								<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn-danger btn-small"><i class="fa fas fa-trash"></i></a>
								<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="exampleModalLabel"><?=$v->name?></h4>
											</div>
											<div class="modal-body">Confirmer la suppression de l'emoticône : <?=$v->name?></div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
												<button onclick="window.location.href='/shoutbox/delimo/<?=$v->id?>?management&gaming=true'" type="button" class="btn btn-primary">Supprimer</button>
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
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Ajouter une Emoticône</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="row">
		<div class="card-body">
			<form action="/shoutbox/sendemo?management&widgets=true" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
				<div class="form-group">
					<label class="col-sm-12 control-label">Nom de l'emoticône</label>
					<div class="col-sm-12">
						<div class="checkbox">
							<input class="form-control" name="name" type="text" value="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label">Upload</label>
					<div class="col-sm-12">
						<input type="file" id="last-name" name="dir" class="form-control col-md-7 col-xs-12">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-12 control-label">Code</label>
					<div class="col-sm-12">
						<div class="checkbox">
							<input class="form-control" name="code" type="text" value="" placeholder="format court sans espace">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
