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
<div class="about_row">
    <div class="block_text">
        <h2><?=$v->name;?></h2>
        <?=$v->content?>
        <a href="<?=$v->link;?>" class="btn fl-btn color-bg"><span>Details +</span></a>							
    </div>
</div>
<?php
endforeach;
?>