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
<section id="belcms_forum">
	<?php
	foreach ($forum as $value):
		if (isset($value->last->date_post)) {
			$value->last->date_post = Common::TransformDate($value->last->date_post, 'MEDIUM', 'NONE');
		}
	?>
	<div class="belcms_forum_main_cat">
		<div class="belcms_forum_main_cat_title">
			<h2><i class="fa-solid fa-comment-dots"></i> <?=$value->title;?></h2>
		</div>
		<?php
		foreach ($value->category as $cat):
			if (isset($cat->last->date_post)) {
				$cat->last->date_post = Common::TransformDate($cat->last->date_post, 'MEDIUM', 'NONE');
			}
			if (isset($cat->last->author)) {
				$avatar = User::getInfosUserAll($cat->last->author)->profils->avatar;
				if (!is_file($avatar)) {
					$avatar = constant('DEFAULT_AVATAR');
				}
			} else {
				$avatar = constant('DEFAULT_AVATAR');
			}
			$cat->last->title     = empty($cat->last->title)     ? '' : Common::truncate($cat->last->title, 15);
			$cat->last->date_post = empty($cat->last->date_post) ? '' : Common::truncate($cat->last->date_post, 15);
		?>
		<div class="belcms_forum_main_cat_block">
			<div class="belcms_forum_main_cat_ico"><i class="<?=$cat->icon;?>"></i></div>
			<div class="belcms_forum_main_cat_subtitle">
				<h3><a href="Forum/Threads/<?=Common::MakeConstant($cat->title)?>?id=<?=$cat->id?>"><?=$cat->title?></a></h3>
				<div><?=$cat->subtitle;?></div>
			</div>
			<div class="belcms_forum_main_cat_subject">
				<div>Sujets</div>
				<div><?=$cat->countPosts;?></div>
			</div>
			<div class="belcms_forum_main_cat_message">
				<div>Messages</div>
				<div><?=$cat->count;?></div>
			</div>
			<div class="belcms_forum_main_cat_avatar">
				<img src="<?=$avatar;?>" alt="avatar">
			</div>
			<div class="belcms_forum_main_cat_last">
				<div><?=Common::truncate($cat->last->title, 15);?></div>
				<div><?=Common::truncate($cat->last->date_post, 15);?></div>
			</div>
		</div>
		<?php
		endforeach;
		?>
	</div>
	<?php
	endforeach;
	?>
</section>