<?php
use BelCMS\Core\Comment;
use BelCMS\Requires\Common;
use BelCMS\User\User;

$news = current($news);
$countComment = Comment::countComments('news', $news->id);
$author = User::ifUserExist($news->author) ? User::getInfosUserAll($news->author)->user->username : constant('MEMBER_DELETE');
$img = is_file($news->img) ? '<div style="text-align:center;" class="blog-img"><a href="'.$news->img.'"><img style="max-width: 95%"; margin: auto; src="'.$news->img.'" alt="Blog Image"></a></div>' : '';
?>
<?=$img;?>
<div class="blog-content">
    <div class="blog-meta">
        <i class="fa-light fa-user"></i> <a href="Members/View/<?=$author?>" title="<?=constant('POST_BY');?>&ensp;<?=$author?>"><?=$author?></a>
        <a href="#"><i class="fa-regular fa-calendar"></i>&ensp;<?=Common::transformDate($news->date_create, 'FULL', 'NONE')?></a>
        <a href="blog-details.html"><i class="fa-regular fa-comments"></i>&ensp;Commentaire(s) (<?=$countComment;?>)</a>
    </div>
    <h2 class="blog-title"><a href="#"><?=$news->name?></a>
    </h2>
    <?=$news->content?>
    <br><hr>
    <?=$news->additionalcontent?>
    <div class="share-links clearfix ">
        <div class="row justify-content-between">
            <div class="col-sm-auto">
                <span class="share-links-title">Tags:</span>
                <div class="tagcloud">
                    <?php
                    foreach ($news->tags as $value):
                        ?>
                        <a><?=$value;?></a>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$comments = new Comment;
$comments->html();