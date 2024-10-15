<div class="main-container fl-wrap fix-container-init">
	<div class="list-post-wrap list-post-wrap_column list-post-wrap_column_fw">
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

		$img = '	<div class="list-post-media">
						<a href="'.$v->link.'">
							<div class="bg-wrap">
								<div class="bg" data-bg="'.$v->img.'"></div>
							</div>
						</a>
						<span class="post-media_title">&copy; Image Copyrights</span>
					</div>';
	} else {
		$img = null;
	}
?>
		<div class="list-post fl-wrap">
			<div class="list-post-content">
				<h3><a href="<?=$v->link;?>"><?=$v->name;?></a></h3>
				<span class="post-date"><i class="far fa-clock"></i> <?=Common::transformDate($v->date_create, 'FULL', 'MEDIUM')?></span>
				<?=$v->content?>
				<ul class="post-opt">
					<li><i class="far fa-comments-alt"></i> <?=$countComment;?> </li>
					<li><i class="fal fa-eye"></i>  <?=$c_comment;?> </li>
				</ul>
				<div class="author-link"><a href="Members/<?=$username;?>"><img src="<?=$avatar;?>" alt="">  <span>By <?=$username;?></span></a></div>
			</div>
		</div>
<?php
endforeach;
?>
	</div>
	<div class="clearfix"></div>
</div>