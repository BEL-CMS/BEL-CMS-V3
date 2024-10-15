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
        $returnImg = '<div class="blog-media">
                        <div class="single-slider-wrap">
                                <div class="single-slider">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper lightgallery">
                                            <div class="swiper-slide hov_zoom">
                                                <img src="'.$v->img.'" alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
    } else {
        $returnImg = '';
    }
    if (!empty($v->tags)) {
        $returnTags = '<div class="tagcloud tc_single">';
        $returnTags .= '<span class="tc_single_title">Tags:</span>';
        foreach ($v->tags as $key => $value) {
            $returnTags .= '<a href="#">'.$value.'</a>';
        }
        $returnTags .= '</div>';
    } else {
        $returnTags = '';
    }
?>
<?=$returnImg;?>
<div class="text-block post-single_tb">
    <div class="text-block-container">
        <div class="tbc_subtitle"><?=$v->name;?></div>
        <div class="room-card-details" style="margin-bottom: 20px">
            <ul>
                <li><i class="fa-light fa-calendar-days"></i><span><?=Common::transformDate($v->date_create, 'MEDIUM', 'MEDIUM')?></span></li>
                <li><i class="fa-light fa-comment"></i><span><?=$comment;?></span></li>
            </ul>
        </div>
        <?=$v->content?>
    </div>
    <div class="tbc-separator"></div>
    <?=$returnTags;?>
</div> 
<?php
endforeach;
?>