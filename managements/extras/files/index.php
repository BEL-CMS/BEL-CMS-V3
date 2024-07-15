<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.6 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
	exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;

if (isset($_SESSION['LOGIN_MANAGEMENT']) && $_SESSION['LOGIN_MANAGEMENT'] === true):
?>
<div class="mt-6">
	<div class="card">
		<div class="flex flex-wrap justify-between items-center gap-2 p-6">
			<a href="files/add?management&amp;option=extras" class="btn bg-success/25 text-sm font-medium text-success hover:text-white hover:bg-success">
				<i class="mgc_add_circle_line me-3"></i>Ajouter
			</a>
		</div>
		<div class="relative overflow-x-auto">
			<table class="w-full divide-y divide-gray-300 dark:divide-gray-700">
				<thead class="bg-slate-300 bg-opacity-20 border-t dark:bg-slate-800 divide-gray-300 dark:border-gray-700">
					<tr>
						<th scope="col" class="py-3.5 ps-4 pe-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">ID</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Nom</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Description</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Utilisateur</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Date</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Liens <span class="text-red-500">*</span> cliquer pour copier le lien</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-200">Suppression</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700 ">
					<?php
					foreach ($data as $v):
						$user = User::ifUserExist($v->uplaods);
						if ($user == true) {
							$user = User::getInfosUserAll($v->uplaods);
						}
						$date = Common::TransformDate($v->datetime_upload, 'MEDIUM', 'NONE');
						$text = empty($v->sub) ? '' : Common::truncate($v->sub, 60);
					?>
					<tr>
						<td class="whitespace-nowrap py-4 ps-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"><b># <?=$v->id;?></b></td>
						<td><?=$v->name;?></td>
						<td class="whitespace-nowrap py-4 pe-3 text-sm font-medium text-gray-900 dark:text-gray-200"> <?=$text;?></td>
						<td class="whitespace-nowrap py-4 pe-3 text-sm">
							<div class="flex items-center">
								<div class="h-10 w-10 flex-shrink-0">
									<img class="h-10 w-10 rounded-full" src="<?=$user->profils->avatar;?>" alt="">
								</div>
								<div class="font-medium text-gray-900 dark:text-gray-200 ms-4"><?=$user->user->username;?></div>
							</div>
						</td>
						<td class="whitespace-nowrap py-4 px-3 text-sm">
							<?=$date;?>
						</td>
						<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
						<p id="<?=$v->id;?>" style="display:none;"><?=$v->file;?></p>
							<button onclick="copyToClipboard('#<?=$v->id;?>')"><?=$v->file;?></button>
						</td>
						<td class="whitespace-nowrap py-4 px-3 text-center text-sm font-medium">
							<a href="files/del/<?=$v->id;?>?management&option=extras" class="ms-0.5"> <i class="mgc_delete_line text-xl"></i> </a>
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
<script>
function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).text()).select();
	document.execCommand("copy");
	alert('Copier');
}
</script>
<?php
endif;