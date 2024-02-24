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

use BelCMS\Core\Config;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
?>
<div id="belcms_forum_post">
	<?php
	foreach ($post as $k => $value):
		$group = Config::getGroupsForID($value->group);
		if ($k == 0):
			if (User::isLogged()) {
				if ($post[0]->lockpost == 1):
				?>
					<div id="forum_new">
						<h4><i class="fa fa-comments"></i> <?=$value->title?></h4>
						<a data="<?=constant('UNLOCK_THREAD');?>" href="forum/unlockPost/?id=<?=$post[0]->id?>" class="belcms_tooltip_bottom belcms_btn belcms_bg_green"><i class="fa fa-unlock"></i></a>
						<a data="<?=constant('DEL_THRAD');?>" href="Forum/DelPost/?id=<?=$post[0]->id?>" class="belcms_tooltip_bottom belcms_btn belcms_bg_black"><i class="fa fa-trash"></i></a>
					</div>
					<div class="clear"></div>
				<?php
				else:
				?>
					<div id="forum_new">
						<h4><i class="fa fa-comments"></i> <?=$value->title?></h4>
						<a data="<?=constant('LOCK_THREAD');?>" href="forum/lockPost?id=<?=$post[0]->id?>" class="belcms_tooltip_bottom belcms_btn belcms_bg_red btn-icon-left"><i class="fa fa-lock"></i></a>
						<a data="<?=constant('DEL_THRAD');?>"  href="Forum/DelPost?id=<?=$post[0]->id?>" class="belcms_tooltip_bottom belcms_btn belcms_bg_black"><i class="fa fa-trash"></i></a>
					</div>
					<div class="clear"></div>
				<?php
				endif;
			}
		endif;
	?>
	<article class="belcms_forum_article">
		<div class="belcms_forum_post_div_infos">
			<img src="<?=$value->avatar;?>">
			<h3><?=$value->author;?></h3>
			<div class="belcms_forum_post_groups">
				<span style="background: <?=$group->color;?>;color: rgba(255, 255, 255, .75)">
				<?php
				echo defined($group->name) ? constant($group->name) : $group->name;
				?>
				</span>
			</div>
			<ul>
				<li><strong>Inscrit</strong><?=Common::TransformDate($value->registration, 'MEDIUM', 'NONE');?></li>
				<li><strong>Messages</strong><?=$value->countPost;?></li>
			</ul>
		</div>
		<div class="belcms_forum_post_div_content">
			<div class="belcms_forum_post_div_content_date" style="margin-bottom: 10px; overflow: hidden;">
				<div style="float: left;"><?=Common::TransformDate($value->date_post, 'MEDIUM', 'SHORT')?></div>
				<?php
				if (isset($_SESSION['USER']->user->hash_key) and $_SESSION['USER']->user->hash_key == 1) :
					if ($k == 0):
						?>
						<div style="float: right;"><a href="Forum/EditPostPrimary/<?=$value->id_threads;?>"><i class="fas fa-pencil-alt"></i></a></div>
					<?php
					else:
						?>
						<div style="float: right;"><a href="Forum/EditPost/<?=$value->id?>/<?=$value->id_post;?>"><i class="fas fa-pencil-alt"></i></a></div>
					<?php
					endif;
				endif
				?>
			</div>
			<div class="clear"></div>
			<div><?=$value->content;?></div>
			<?php
			if (!empty($value->attachment)):
			?>
				<div class="attachment">
					<a href="<?=$value->attachment?>" target="_blank"><i class="fa fa-unlink"></i> <?=constant('FILE');?></a>
					<span>(<?=Common::SizeFile(ROOT.DS.$value->attachment)?>) Size</span>
				</div>
			<?php
			endif;
			?>
		</div>
			
	</article>
	<?php
	endforeach;
	?>
	<?php
	if ($post[0]->lockpost == 0 and User::isLogged()):
	?>
	<form id="belcms_textaera" action="Forum/Send" method="post" enctype="multipart/form-data">
		<textarea class="bel_cms_textarea_simple" name="info_text"></textarea>
		<label for="file_attachment"><?=constant('FILE_ATTACHMENT');?></label>
		<input type="file" name="file" class="form-control-file" id="file_attachment">
		<input type="hidden" name="id" value="<?=$post[0]->id?>">
		<input type="hidden" name="send" value="SubmitReply">
		<input type="submit" value="<?=constant('SUBMIT_POST');?>" class="belcms_btn belcms_bg_black">
	</form>
	<?php
	endif;
	?>
</div>