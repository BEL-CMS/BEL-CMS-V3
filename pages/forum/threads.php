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
<div id="belcms_threads">
	<?php
	if (Users::getInfosUser($_SESSION['USER']['HASH_KEY']) !== false):
		?>
		<div class="headline">
			<div class="pull-right">
				<a data-toggle="tooltip" title="<?=NEW_THREAD?>" href="Forum/NewThread/<?=$id?>" class="btn btn-info btn-icon-left"><i class="fas fa-plus"></i> <?=NEW_THREAD?></a>
			</div>
		</div>
	<?php	
	endif;
	if (empty($threads)):
		Notification::infos('Aucun sujet disponible dans la base de données', 'Forum');
	else:
	?>
		<table  class="table">
			<tr>
				<th></th>
				<th>Thread</th>
				<th>Réponse</th>
				<th>Vu</th>
				<th>Dernier post</th>
			</tr>
			<?php
			foreach ($threads as $value) {
				?>
			<tr>
				<td></td>
				<td>
					<div>
						<a href="Forum/Post/<?=Common::MakeConstant($value->title)?>/<?=$value->id?>"><?=$value->title?></a>
					</div>
					<div><?=Users::hashkeyToUsernameAvatar($value->author)?></div>
				</td>
				<td>
					<?php
					echo $value->options['post'];
					?>
				</td>
				<td>
					<?php
					echo $value->options['view'];
					?>
				</td>
				<td>
					<div><span style="color: <?=Users::colorUsername($value->last->author)?>"><?=Users::hashkeyToUsernameAvatar($value->last->author)?></span></div>
					<div><?=Common::TransformDate($value->last->date_post, 'MEDIUM', 'SHORT')?></div>
				</td>
			</tr>
				<?php
			}
			?>
		</table>
<?php
	endif; ?>