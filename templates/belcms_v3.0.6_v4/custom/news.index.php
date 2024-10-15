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
	if (!empty($v->img)) {

		$img  = '<div class="single-slider-wrap">';
		$img .= '<div class="single-slider fl-wrap">';
		$img .= '<div class="swiper-container">';
		$img .= '<div class="swiper-wrapper lightgallery">';
		$img .= '<div class="swiper-slide"><img src="'.$v->img.'" alt=""></div>';
		$img .= '</div>';
		$img .= '</div>';
		$img .= '</div>';
		$img .= '</div>';
	} else {
		$img = null;
	}
?>
<div class="post-item post-item_single">
    <div class="post-media">
        <div class="post-header">
            <a href="#"><?=Common::transformDate($v->date_create, 'FULL', 'MEDIUM')?></a> 
            <div class="post-opt">
                <span><i class="fal fa-eye"></i> <?=$v->view;?></span> 
            </div>
        </div>
    </div>
    <div class="post-item_content border-box_item ">
        <?=$v->content?>
    </div>
    <div class="single-tagcloud">
        <span class="single-tagcloud_title"><?=$countComment;?></span>
        <a href="<?=$v->link;?>"><?=$c_comment;?></a>
    </div>
</div>
<?php
endforeach;