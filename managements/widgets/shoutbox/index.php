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

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div class="flex flex-col gap-6">
	<div class="card">
		<div class="card-header">
			<div class="flex justify-between items-center">
				<h4 class="card-title"><?=constant('LIST_EMOTICONS');?></h4>
			</div>
		</div>
		<div class="p-6">
			<div class="overflow-x-auto">
				<div class="border rounded-lg overflow-hidden dark:border-gray-700 p-2">
					<table class="DataTableBelCMS min-w-full divide-y divide-gray-200 dark:divide-gray-700 p-2 hover cell-border stripe">
						<thead class="bg-gray-50 dark:bg-gray-700">
				<tr>
					<th># ID</th>
					<th>Auteur</th>
					<th>Date du message</th>
					<th>Message</th>
					<th>Options</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th># ID</th>
					<th>Auteur</th>
					<th>Date du message</th>
					<th>Message</th>
					<th>Options</th>
				</tr>
			</tfoot>
			<tbody>
				<?php
				foreach ($data as $k => $v):
					$user = User::getInfosUserAll($v->hash_key);
					?>
					<tr>
						<td><?=$v->id?></td>
						<td><?=$user->user->username;?></td>
						<td><?=$v->date_msg?></td>
						<td><?=Common::truncate($v->msg, 25)?></td>
						<td>
							<a href="Shoutbox/edit/<?=$v->id?>?management&widgets=true>" class="btn btn btn-primary btn-sm mb-1">Edit</a>
							<a href="#" data-toggle="modal" data-target="#modal_<?=$v->id?>"class="btn btn btn-danger btn-sm mb-1">Supprimer</a>
							<div class="modal fade" id="modal_<?=$v->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="exampleModalLabel">ID : <?=$v->id?></h4>
										</div>
										<div class="modal-body">Confirmer la suppression du message :<br><?=$v->msg?></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
											<button onclick="window.location.href='/Shoutbox/delete/<?=$v->id?>?management&widgets=true'" type="button" class="btn btn-primary">Supprimer</button>
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