<?php
use BelCMS\Core\Comment;
use BelCMS\Requires\Common;
use BelCMS\User\User;
foreach ($news as $k => $v):
    $countComment = Comment::countComments('news', $v->id);
    if ($countComment == 0) {
        $comment                = constant('NO_COMMENT');
        $c_comment              = constant('NO_COMMENT');
        } else if($countComment == 1) {
        $comment                = '1 '.constant('COMMENT');
        $c_comment              = constant('COMMENT');
        } else {
        $comment                = $countComment.' '.constant('COMMENTS');
        $c_comment              = constant('COMMENTS');
    }
    $user = User::getInfosUserAll($v->author);
    if (!$user){
        $username = constant('MEMBER_DELETE');
        $avatar   = constant('DEFAULT_AVATAR');
    } else {
        $username = $user->user->username;
        $avatar   = !empty($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
    }
?>
<div class="post">
    <div class="post-item fl-wrap">
        <h4><a href="<?=$v->link;?>"><?=$v->name;?></a></h4>
        <div class="post-opt single_post-opt">
            <ul class="no-list-style">
                <li><i class="fal fa-calendar"></i> <span><?=Common::transformDate($v->date_create, 'MEDIUM', 'NONE')?></span></li>
                <li><i class="fal fa-eye"></i> <span><?=$v->view;?> Vu</span></li>
                <li><i class="fal fa-comments"></i> <span><?=$comment;?></span></li>
            </ul>
        </div>
        <?=$v->content?>
        <a href="<?=$v->link;?>" class="btn hide-icon ajax"><i class="fas fa-caret-right"></i><span>Details +</span></a> 
    </div>
</div>
<?php
endforeach;
?>