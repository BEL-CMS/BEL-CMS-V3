<?php
use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\Comment;

$sql = new BDD;
$sql->table('TABLE_PAGES_NEWS');
$sql->limit(1);
$sql->orderby(array(array('name' => 'id', 'type' => 'DESC')));
$sql->queryOne();
$returnNews = $sql->data;

$user = User::getInfosUserAll($returnNews->author);
if (!$user){
    $username = constant('MEMBER_DELETE');
    $avatar   = constant('DEFAULT_AVATAR');
} else {
    $username = $user->user->username;
    $avatar   = !empty($user->profils->avatar) ? $user->profils->avatar : constant('DEFAULT_AVATAR');
}
if (!empty($returnNews->img)) {
    $img  = '<div class="blog-media fl-wrap">';
    $img .= '<div class="single-slider-wrap">';
    $img .= '<div class="single-slider fl-wrap">';
    $img .= '<div class="swiper-container">';
    $img .= '<div class="swiper-wrapper lightgallery">';
    $img .= '<div class="swiper-slide hov_zoom"><img src="'.$returnNews->img.'" alt=""><a href="'.$returnNews->img.'" class="box-media-zoom popup-image"><i class="fal fa-search"></i></a></div>';
    $img .= '</div>';
    $img .= '</div>';
    $img .= '</div>';
    $img .= '</div>';
    $img .= '</div>';  
} else {
    $img = '';
}
    $countComment = Comment::countComments('news', $returnNews->id);
    if ($countComment == 0) {
        $comment                = constant('NO_COMMENT');
        $c_comment              = constant('NO_COMMENT');
    } else if($countComment == 1) {
        $comment                = constant('COMMENT');
        $c_comment              = constant('COMMENT');
    } else {
        $comment                = constant('COMMENTS');
        $c_comment              = constant('COMMENTS');
    }
?>
<div id="wrapper">
    <div class="content-holder">
        <div class="fixed-column-image-wrap">
            <div class="fixed-column-image fs-wrapper">
                <div class="bg hor_scroll"  data-bg="templates/cyberbook/images/bg/2.jpg"></div>
                <div class="overlay"></div>
                <div class="overlay-dec"></div>
            </div>
            <footer class="column-footer">
                <div class="column-footer_arrow-dec_wrap color-bg">
                    <div class="arrow_dec_wrap">
                        <div class="arrow_dec"></div>
                    </div>
                </div>
                <div class="column-footer_head">Scroll  Down</div>
                <div class="column-footer_content fl-wrap">
                    <div class="column-footer_title"><span><?=$var->link;?></span></div>
                </div>
                <div class="dir-arrow"></div>
            </footer>
            <div class="fci_progress-bar-wrap fci_progress-bar-wrap2 dark-bg">
                <div class="mousey-wrap">
                    <div class="mousey">
                        <div class="scroller"></div>
                    </div>
                </div>
                <div class="ver_progress-bar_wrap">
                    <div class="ver_progress-bar color-bg"></div>
                </div>
                <div class="pbw_animicon">
                    <i class="fas fa-caret-down"></i>
                </div>
            </div>
            <div class="hero-arrows_dec"></div>
        </div>
        <div class="column-wrap">
            <div class="content fl-wrap full-height">
                <section id="sec1">
                    <div class="container">
                        <div class="pr_details shop-item_det fl-wrap">
                            <div class="pr_details_item">
                                <?=$img;?>										
                                <div class="accordion mar-top">
                                    <a class="toggle act-accordion" href="#"><?=$returnNews->name;?> <span></span></a>
                                    <div class="accordion-inner visible">
                                    <?=$returnNews->content;?>
                                    </div>
                                </div>
                            </div>
                            <div class="pr_details_item">
                                <div class="init-fix-column fl-wrap">
                                    <div class="project-details">
                                        <ul>
                                            <li><span>01. <?=$comment;?> : </span> <?=$countComment;?> </li>
                                            <li><span>02. Date : </span> <?=Common::transformDate($returnNews->date_create, 'FULL', 'MEDIUM')?></li>
                                            <li><span>03. Vu : </span><?=$returnNews->view;?></li>
                                            <li><span>04. Auteur : </span>  <a href="Members/detail/<?=$username;?>"><?=$username;?> </a></li>
                                        </ul>
                                    </div>
                                    <a href="index.php" class="btn color-bg fl-btn det-anim"><span>Retour vers l'index</span></a>	
                                </div>
                            </div>
                        </div>
                        <div class="limit-box fl-wrap"></div>							
                    </div>
                    <div class="section-number"><?=$returnNews->id;?>.</div>
                    <div class="dec_cirlce" style="left: -120px; bottom: 350px"><span></span></div>
                    <div class="dec_cirlce" style="right: -120px; top: 350px"><span></span></div>
                    <div class="sec-lines"></div>
                </section>
            </div>
        </div>
    </div>
</div>