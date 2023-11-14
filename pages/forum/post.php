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
<div id="belcms_forum_post">
	<?php
	foreach ($post as $k => $value):
		if ($k == 0):
			if ($post[0]->lockpost == 1):
			?>
				<div id="forum_new">
					<h4><i class="fa fa-comments"></i> <?=$value->title?></h4>
					<a data-tooltip="<?=constant('UNLOCK_THREAD');?>" data-position="bottom" href="forum/unlockPost/?id=<?=$post[0]->id?>" class="belcms_btn belcms_bg_green"><i class="fa fa-unlock"></i></a>
					<a data-tooltip="<?=constant('DEL_THRAD');?>" data-position="bottom" href="Forum/DelPost/?id=<?=$post[0]->id?>" class="belcms_btn belcms_bg_black"><i class="fa fa-trash"></i></a>
				</div>
				<div class="clear"></div>
			<?php
			else:
			?>
				<div id="forum_new">
					<h4><i class="fa fa-comments"></i> <?=$value->title?></h4>
					<a data-tooltip="<?=constant('LOCK_THREAD');?>" data-position="bottom" href="forum/lockPost?id=<?=$post[0]->id?>" class="belcms_btn belcms_bg_red btn-icon-left"><i class="fa fa-lock"></i></a>
					<a data-tooltip="<?=constant('DEL_THRAD');?>" data-position="bottom" href="Forum/DelPost?id=<?=$post[0]->id?>" class="belcms_btn belcms_bg_black"><i class="fa fa-trash"></i></a>
				</div>
				<div class="clear"></div>
			<?php
			endif;
		endif;
	?>
	<div class="belcms_forum_post_div">
		<div class="belcms_forum_post_div_infos">
			<h3 style="margin: 0"><?=$value->author;?></h3>
			<ul>
				<li><strong>Join Date</strong><?=$value->registration;?></li>
				<li><strong>Posts</strong><?=$value->countPost;?></li>
			</ul>
		</div>
		<div class="belcms_forum_post_div_content">
			<div style="margin-bottom: 10px; overflow: hidden;">
				<div style="float: left;"><?=Common::TransformDate($value->date_post, 'MEDIUM', 'SHORT')?></div>
				<?php
				if ($_SESSION['USER']->user->hash_key == 1):
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
			if (!empty($v->attachment)):
			?>
				<div class="attachment">
					<a href="<?=$v->attachment?>" target="_blank"><i class="fa fa-unlink"></i> <?=constant('FILE');?></a>
					<span>(<?=Common::SizeFile(ROOT.$v->attachment)?>) Size</span>
				</div>
			<?php
			endif;
			?>
		</div>
	</div>
	<?php
	endforeach;
	?>
	<?php
	if ($post[0]->lockpost == 0 and $_SESSION['USER'] !== false):
	?>
	<form action="Forum/Send" method="post" enctype="multipart/form-data">
		<div class="card">
			<div class="card-body">
				<textarea class="bel_cms_textarea_simple" name="info_text"></textarea>
				<div class="form-group">
					<label for="file_attachment"><?=constant('FILE_ATTACHMENT');?></label>
					<input type="file" name="file" class="form-control-file" id="file_attachment">
				</div>
			</div>
			<div class="card-footer">
				<input type="hidden" name="id" value="<?=$post[0]->id?>">
				<input type="hidden" name="send" value="SubmitReply">
				<input type="submit" value="<?=constant('SUBMIT_POST');?>" class="belcms_btn belcms_bg_black">
			</div>
		</div>
	</form>
	<?php
	endif;
	?>
</div>