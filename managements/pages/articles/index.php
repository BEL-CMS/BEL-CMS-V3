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
		<h3 class="card-title"><?=LIST_OF_ARTICLES;?></h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
				<i class="fas fa-minus"></i>
			</button>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="DataTableBelCMS table table-vcenter table-condensed table-bordered">
			<thead>
				<tr>
					<th># <?=ID;?></th>
					<th><?=NAME;?></th>
					<th><?=CREATION_DATE;?></th>
					<th><?=AUTHOR;?></th>
					<th><?=OPTIONS;?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th># <?=ID;?></th>
					<th><?=NAME;?></th>
					<th><?=CREATION_DATE;?></th>
					<th><?=AUTHOR;?></th>
					<th><?=OPTIONS;?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				foreach ($data as $k => $v):
					?>
					<tr>
						<td><?=$v->id?></td>
						<td><?=$v->name?></td>
						<td><?=$v->date_create?></td>
						<td><?=Users::hashkeyToUsernameAvatar($v->author)?></td>
						<td>
							<a href="/articles/edit/<?=$v->id?>?management&option=pages" class="btn btn btn-primary btn-sm mb-1"><?=EDIT;?></a>
							<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>" class="btn btn btn-danger btn-sm mb-1"><?=DELETE;?></a>
							<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel"><?=$v->name?></h4>
										</div>
										<div class="modal-body"><?=DEL_CONFIRM;?> <?=OF2;?> <?=ARTICLE;?> : <?=$v->name?></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal"><?=CLOSE;?></button>
											<button onclick="window.location.href='/articles/del/<?=$v->id?>?management&option=pages'" type="button" class="btn btn-primary"><?=DELETE;?></button>
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