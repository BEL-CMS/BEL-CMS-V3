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
$count = BelCMSConfig::getGroups();
$i = 0;
foreach ($count as $key => $value) {
	$i++;
}
?>
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Groupes</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
		  		<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table col-md-6 class="table">
			<thead>
				<thead>
					<td><strong>Icône</strong></td>
					<td><strong>Non du groupe</strong></td>
					<td><strong>Couleur</strong></td>
					<td><strong>Options</strong></td>
				</thead>
			</thead>
			<tbody>
			<?php
			foreach (BelCMSConfig::getGroups() as $k => $v):
				if ($v['id'] == 1 or  $v['id'] == 2) {
					$ico = "fa-arrow-down-up-lock";
				} else {
					$ico = "fa-arrow-down-up-across-line";
				}
			?>
				<tr>
					<td>
						<i style="vertical-align: middle;" class="fa-solid <?=$ico;?>"></i>
					</td>
					<td><?=$k?></td>
					<td><div style="width: 40px; height: 40px; background-color: <?=$v['color'];?>"></div></td>
					<td>
						<a href="/groups/edit/<?=$v['id']?>?management&users" class="btn btn btn-primary btn-sm mb-1">Edit</a>
						<?php
						if ($v['id'] != 1 and $v['id'] != 2):
						?>
						<a href="#" data-toggle="modal" data-target="#modal_<?=$v['id']?>" class="btn btn btn-danger btn-sm mb-1">Supprimer</a>
						<div class="modal fade" id="modal_<?=$v['id']?>" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title"><?=$k?></h4>
									</div>
									<div class="modal-body">Confirmer du groupe : <?=$k?></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
										<button onclick="window.location.href='/groups/detele/<?=$v['id']?>?management&users'" type="button" class="btn btn-primary">Supprimer</button>
									</div>
								</div>
							</div>
						</div>
						<?php
						endif
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

