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
<div class="blog-posts">
	<div class="post box">
		<div class="row">
			<div class="col-sm-12 post-content">
				<div class="meta"><span class="category"><?=$username;?></span><span class="date"><?=Common::transformDate($v->date_create, 'MEDIUM', 'NONE')?></span><span class="comments"><a href="<?=$v->link;?>"><?=$comment;?> <i class="icon-chat-1"></i></a></span></div>
				<h2 class="post-title"><a href="<?=$v->link;?>"><?=$v->name;?></a></h2>
				<?=$v->content?>
			</div>
		</div>
	</div>
</div>
<?php
endforeach;
?>