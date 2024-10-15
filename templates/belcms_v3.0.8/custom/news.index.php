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
	if (!empty($v->tags)) {
		$tags = '<div class="tagcloud_single">
					<span class="tc_single_title"><i class="fa-solid fa-tags"></i> Post Tags:</span>
					<div class="tags-widget">';
		foreach ($v->tags as $key => $value) {
			$tags .= '<a href="#">'.$value.'</a>';
		}
		$tags .= '</div></div>';
	} else {
		$tags = '';
	}
	if (!empty($v->img)) {

		$img = ' <div class="blog-media">
			<div class="single-slider-wrap">
				<div class="single-slider">
					<div class="swiper-container">
						<div class="swiper-wrapper lightgallery">
							<div class="swiper-slide hov_zoom"><img src="'.$v->img.'" alt=""><a href="'.$v->img.'" class="box-media-zoom   popup-image"><i class="fal fa-search"></i></a></div>
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
			<h3><a href="<?=$v->link;?>"><?=$v->name;?></a></h3>
		</div>
		<div class="boxed-content-item">
			<?=$img;?>
			<div class="text-block post-single_tb">
				<div class="post-card-details" style="margin-bottom: 20px;">
					<ul>
						<li><i class="fa-light fa-calendar-days"></i><span><?=Common::transformDate($v->date_create, 'FULL', 'MEDIUM')?></span></li>
						<li><i class="fa-light fa-comment"></i><span><?=$c_comment;?></span></li>
					</ul>
					<div class="pv-item_wrap pv-item_wrap_single"><i class="fa-light fa-glasses"></i><span> <?=$v->view;?> <strong>Vu</strong></span></div>
				</div>
				<div class="text-block-container">
					<?=$v->content?>
					<a href="<?=$v->link;?>" class="post-card_link">Voir la suite<i class="fa-solid fa-caret-right"></i></a>
				</div>
				<?=$tags;?>
			</div>
		</div>
	</div>
</div>
<?php
endforeach;