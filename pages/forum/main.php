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


if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<section id="belcms_forum">
	<?php
	foreach ($forum as $value):
	?>
	<div class="belcms_forum_main_cat">
		<div class="belcms_forum_main_cat_title">
			<h2><i class="fa-solid fa-comment-dots"></i> <?=$value->title;?></h2>
		</div>
		<?php
		foreach ($value->category as $cat):
		?>
		<div class="belcms_forum_main_cat_block">
			<div class="belcms_forum_main_cat_ico"><i class="<?=$cat->icon;?>"></i></div>
			<div class="belcms_forum_main_cat_subtitle">
				<h3><a href="Forum/Threads/<?=Common::MakeConstant($cat->title)?>/<?=$cat->id?>"><?=$cat->title?></a></h3>
				<div><?=$value->subtitle;?></div>
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
				<img src="assets/img/default_avatar.jpg" alt="avatar">
			</div>
			<div class="belcms_forum_main_cat_last">
				<div>Offre d'emploi Technicien-ne</div>
				<div>3 Novembre 2023 SARL</div>
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