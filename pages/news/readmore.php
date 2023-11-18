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

use BelCMS\Core\Comment as Comment;
use BelCMS\Requires\Common as Common;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$countComment = Comment::countComments('news', $news->id);
?>
<article class="section_bg bel_cms_blog_readmore">
	<div class="card">
		<div class="card-header"><h1><?=$news->name?></h1></div>
		<div class="card-body">
			<ul class="bel_cms_blog_userdate">
				<li><?=constant('BY');?> : <a href="Members/View/<?=$news->username?>" title="<?=constant('POST_BY');?> <?=$news->username?>"><?=$news->username?></a></li>
				<li><?=constant('DATE');?> : <?=Common::transformDate($news->date_create, 'FULL', 'NONE')?></li>
			</ul>
			<div class="bel_cms_blog_content">
				<?=$news->content?>
				<br><hr>
				<?=$news->additionalcontent?>
			</div>
		</div>
		<div class="card-footer">
			<ul class="bel_cms_blog_infos">
				<li><i class="ion-chatbox-working"></i> <?=$countComment?> <?=constant('COMMENTS');?></li>
				<li><i class="ion-ios-eye"></i> <?=$news->view?> <?=constant('SEEN');?></li>
			</ul>
		</div>
	</div>
</article>
<?php
$comments = new Comment;
$comments->html();
