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

use BelCMS\User\User as User;
use BelCMS\Requires\Common as Common;
use BelCMS\Core\Comment as Comment;
?>
<div>
	<section class="section_bg" id="bel_cms_blog_main">
		<?php
		foreach ($news as $k => $v):
			$countComment = Comment::countComments('news', $v->id);
			$user = User::getInfosUserAll($v->author);
			if (!$user){
				$username = constant('MEMBER_DELETE');
				$avatar   = constant('DEFAULT_AVATAR');
			} else {
				$username = $user->user->username;
				$avatar   = is_file($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
			}
		?>
			<article class="bel_cms_blog">
				<div class="card">
					<div class="card-header"><h1><a href="<?=$v->link; ?>"><?=$v->name?></a></h1></div>
					<div class="card-body">
						<ul class="bel_cms_blog_userdate">
							<li><?=constant('BY');?> : <a href="Members/View/<?=$v->author?>" title="<?=constant('POST_BY')?> <?=$v->author?>"><?=$v->author?></a></li>
							<li><?=constant('DATE')?> : <?=Common::transformDate($v->date_create, 'FULL', 'NONE')?></li>
						</ul>
						<div class="bel_cms_blog_content">
							<?=$v->content?>
						</div>
					</div>
					<div class="card-footer">
						<ul class="bel_cms_blog_infos">
							<li><i class="ion-chatbox-working"></i> <?=constant('COMMENTS')?></li>
							<li><i class="ion-ios-eye"></i> <?=$v->view?> <?=constant('SEEN')?></li>
							<li class="bel_cms_blog_infos_last">
								<a class="btn btn-primary" href="<?=$v->link?>"><i class="ion-link"></i> <?=constant('READ_MORE')?></a>
							</li>
						</ul>
					</div>
				</div>
			</article>
		<?php
		endforeach;
		echo $pagination;
		?>
	</section>
</div>
