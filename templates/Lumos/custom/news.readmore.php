<?php
use BelCMS\Core\Comment;
use BelCMS\Requires\Common;
use BelCMS\User\User;

if (!defined('CHECK_INDEX')):
    header($_SERVER['SERVER_PROTOCOL'] . ' 403 Direct access forbidden');
    exit('<!doctype html><html><head><meta charset="utf-8"><title>BEL-CMS : Error 403 Forbidden</title><style>h1{margin: 20px auto;text-align:center;color: red;}p{text-align:center;font-weight:bold;</style></head><body><h1>HTTP Error 403 : Forbidden</h1><p>You don\'t permission to access / on this server.</p></body></html>');
endif;
$countComment = Comment::countComments('news', $news->id);
$author = User::ifUserExist($news->author) ? User::getInfosUserAll($news->author)->user->username : constant('MEMBER_DELETE');
$img = !empty($news->img) ? '<figure class="frame"><img src="'.$news->img.'" alt=""></figure>' : '';
?>
<div class="blog-posts">
    <div class="post box">
    <div class="meta"><a href="Members/View/<?=$author?>" title="<?=constant('POST_BY');?> <?=$author?>"><?=$author?></a><span class="date"><?=Common::transformDate($news->date_create, 'FULL', 'NONE')?></span></div>
    <h2 class="post-title"><?=$news->name?></h2>
    <?=$news->content?>
    <?=$img;?>
    <div class="divide20"></div>
    <?=$news->additionalcontent?>
    <div class="share"> <a href="#" class="btn share-facebook">Like</a> <a href="#" class="btn share-twitter">Tweet</a> <a href="#" class="btn share-googleplus">+1</a> <a href="#" class="btn share-pinterest">Pin It</a> </div>
    </div>
</div>
<?php
$comments = new Comment;
$comments->html();