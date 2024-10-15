<?php
use BelCMS\Core\Comment;
use BelCMS\Requires\Common;
use BelCMS\User\User;
$countComment = Comment::countComments('news', $news->id);
$author = User::ifUserExist($news->author) ? User::getInfosUserAll($news->author)->user->username : constant('MEMBER_DELETE');
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
if (!empty($news->img)) {

    $img = ' <div class="blog-media">
        <div class="single-slider-wrap">
            <div class="single-slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper lightgallery">
                        <div class="swiper-slide hov_zoom"><img src="'.$news->img.'" alt=""><a href="'.$news->img.'" class="box-media-zoom   popup-image"><i class="fal fa-search"></i></a></div>
                    </div>
                </div>
            </div>
            <div class="fw-carousel-button-prev slider-button"><i class="fa-solid fa-caret-left"></i></div>
            <div class="fw-carousel-button-next slider-button"><i class="fa-solid fa-caret-right"></i></div>
            <div class="fwc-controls_wrap">
                <div class="solid-pagination_btns ss-slider-pagination"></div>
            </div>
        </div>
    </div>';
} else {
    $img = null;
}
?>
<div class="post-container">
	<div class="boxed-content">
		<div class="boxed-content-title">
			<h3><a href="<?=$news->link;?>"><?=$news->name;?></a></h3>
		</div>
		<div class="boxed-content-item">
			<?=$img;?>
			<div class="text-block post-single_tb">
				<div class="post-card-details" style="margin-bottom: 20px;">
					<ul>
						<li><i class="fa-light fa-calendar-days"></i><span><?=Common::transformDate($news->date_create, 'FULL', 'MEDIUM')?></span></li>
						<li><i class="fa-light fa-comment"></i><span><?=$c_comment;?></span></li>
					</ul>
					<div class="pv-item_wrap pv-item_wrap_single"><i class="fa-light fa-glasses"></i><span> <?=$news->view;?> <strong>Vu</strong></span></div>
				</div>
				<div class="text-block-container">
                <?=$news->content?>
                <br><br>
				<?=$news->additionalcontent?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$comments = new Comment;
$comments->html();