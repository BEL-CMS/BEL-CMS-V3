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
<div id="belcms_main">
	<?php
	foreach ($forum as $value) {
		echo '<h4>'.$value->title.'</h4>';
		?>
		<table class="table">
			<tr><th></th>
				<th>forum</th>
				<th>Threads</th>
				<th>Posts</th>
				<th>Last Post</th>
			</tr>
			<?php
			foreach ($value->category as $cat) {
				if (empty($cat->last->title)):
					$last = '<td style="padding="6"">Aucun sujet</td>';
				else:
					$last = '<td><table style="border: none !important; background-color: transparent !important;"><tr><td style="border: none !important;">'.$cat->last->title.'</td></tr><tr><td style="border: none !important;">Par : <span style="color: '.Users::colorUsername($cat->last->author).'">'.Users::hashkeyToUsernameAvatar($cat->last->author).'</span></td></tr><tr><td style="border: none !important;">'.$cat->last->date_post.'</td></tr></table>';
				endif;
				?>
				<tr>
					<td class="forum_table_ico" style="padding: 0 !important; text-align: center !important;"><i class="<?=$cat->icon;?>"></td>
					<td><div><a href="Forum/Threads/<?=Common::MakeConstant($cat->title)?>/<?=$cat->id?>"><?=$cat->title?></a></div>
						<div><?=$value->subtitle;?></div>
					</td>
					<td class="center"><?=$cat->countPosts;?></td>
					<td class="center"><?=$cat->count;?></td>
					<?=$last;?>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	}
?>
</div>