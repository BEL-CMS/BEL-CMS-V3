<?php
/**
 * Bel-CMS [Content management system]
 * @version 3.0.0 [PHP8.3]
 * @link https://bel-cms.dev
 * @link https://determe.be
 * @license http://opensource.org/licenses/GPL-3.-copyleft
 * @copyright 2015-2024 Bel-CMS
 * @author as Stive - stive@determe.be
 */

use BelCMS\Core\Popup;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_forum_main">
	<h1>Forum communautaire</h1>
	<?php
	if (User::isLogged() === false):
	?>
	<div class="belcms_forum_main_block_container">
		<div class="belcms_forum_main_block_header">
			<h3>Connexion</h3>
		</div>
		<div class="belcms_forum_main_block_content">
			<span class="belcms_forum_main_block_content_ico">
				<i class="fa-solid fa-user-pen"></i>
			</span>
			<span class="belcms_forum_main_block_content_title">
				<span><a href="User/Login&echo" class="belcms_tooltip_bottom" data="Connexion">Connexion</a></span>
				<span>Connexion requise pour accéder au forum.</span>
			</span>
		</div>
	</div>
	<?php
	endif;
	foreach ($forum as $val):
		if (!empty($val->category)):
	?>
	<div class="belcms_forum_main_block_container">
		<div class="belcms_forum_main_block_header">
			<h3><?=$val->title;?></h3>
		</div>
		<?php
		if (!empty($val->category)):
			foreach ($val->category as $cat):
				$title = empty($cat->last->title) ? '' : Common::truncate($cat->last->title, 20);
				$a     = empty($title) ? '' : '<a href="Forum/Post/'.$title.'?id='.$cat->last->id.'">'.$title.'</a>';
				$user  = User::getInfosUserAll($cat->last->author);
				if ($user != false) {
					$name = '<a href="Members/profil/'.$user->user->username.'">'.$user->user->username.'</a>';
				} else {
					$name = constant('MEMBER_DELETE');
				}
				$date = !empty($cat->last->date_post) ? Common::TransformDate($cat->last->date_post, 'MEDIUM', 'SHORT') : '';
			?>
			<div class="belcms_forum_main_block_content">
				<span class="belcms_forum_main_block_content_ico">
					<i class="<?=$cat->icon;?>"></i>
				</span>
				<span class="belcms_forum_main_block_content_title">
					<span><a href="Forum/Threads/<?=Common::MakeConstant($cat->title)?>?id=<?=$cat->id?>"><?=$cat->title;?></a></span>
					<span><?=$cat->subtitle;?></span>
				</span>
				<?php
				if ($cat->countPosts != 0 and $cat->count != 0):
				?>
				<span class="belcms_forum_main_block_content_stats">
					<span>Discussions</span>
					<span><?=$cat->countPosts;?></span>
				</span>
				<span class="belcms_forum_main_block_content_stats">
					<span>Messages</span>
					<span><?=$cat->count;?></span>
				</span>
				<?php
				endif;
				if (!empty($user) and !empty($cat->last->date_post)):
				?>
				<span class="belcms_forum_main_block_content_last">
					<span><?=$a;?></span>
					<span><?=$date;?> . <?=$name;?></span>
				</span>
				<?php
				endif;
				?>
			</div>
			<?php
			endforeach;
		endif;
		?>
	</div> 
	<?php
		endif;
	endforeach;
	?>
</section>