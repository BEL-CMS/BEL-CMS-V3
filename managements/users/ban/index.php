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
		<h3 class="card-title"><?=DATE_OF_BAN;?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
		  		<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<table class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
			<thead>
				<tr>
					<th><?=EMAIL;?></th>
					<th><?=USER_BAN;?></th>
					<th><?=IP_USER;?></th>
					<th><?=BEGINNING_OF_BAN;?></th>
					<th><?=DATE_OF_FNISH;?></th>
					<th><?=DATE_OF_BAN;?></th>
					<th><?=OPTIONS;?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($ban as $k => $v):
				$textTime = defined(strtoupper($v->timeban)) ? constant(strtoupper($v->timeban)) : null;
				?>
				<tr>
					<td><?=Secure::isMail($v->email);?></td>
					<td><?=Users::hashkeyToUsernameAvatar($v->author);?></td>
					<td><?=$v->ip?></td>
					<td><?=Common::TransformDate($v->date, 'MEDIUM', 'SHORT')?></td>
					<td><?=Common::TransformDate($v->endban, 'MEDIUM', 'SHORT')?></td>
					<td><?=$textTime;?></td>
					<td>
						<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn btn-danger btn-sm mb-1"><?=DELETE;?></a>
						<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									</div>
									<div class="modal-body">Confirmer la suppression du ban de "<?=Users::hashkeyToUsernameAvatar($v->author)?></div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal"><?=CLOSE;?></button>
										<button onclick="window.location.href='/ban/del/<?=$v->id?>?management&option=users'" type="button" class="btn btn-primary"><?=DELETE;?></button>
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
			<tfoot>
				<tr>
					<th><?=EMAIL;?></th>
					<th><?=USER_BAN;?></th>
					<th><?=IP_USER;?></th>
					<th><?=BEGINNING_OF_BAN;?></th>
					<th><?=DATE_OF_FNISH;?></th>
					<th><?=DATE_OF_BAN;?></th>
					<th><?=OPTIONS;?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>