<?php
$link = defined(strtoupper($var->link)) ? constant(strtoupper($var->link)) : ucfirst($var->link);
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <base href="<?=$var->host;?>">
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bel-CMS - <?=$link;?></title>
        <?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/belcms_v3.0.6_v4/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/belcms_v3.0.6_v4/css/style.css">
        <link rel="shortcut icon" href="templates/belcms_v3.0.6_v4/images/favicon.ico">
        <link rel="apple-touch-icon" sizes="76x76" href="templates/belcms_v3.0.6_v4/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="templates/belcms_v3.0.6_v4/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="templates/belcms_v3.0.6_v4/favicon/favicon-16x16.png">
        <link rel="manifest" href="templates/belcms_v3.0.6_v4/favicon/site.webmanifest">
        <link rel="mask-icon" href="templates/belcms_v3.0.6_v4/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <meta name="google-adsense-account" content="ca-pub-5176882397524933">
    </head>
    <body>
        <div class="loader-wrap">
            <div class="loading-spinner">
                <div  class="movingBallG"></div>
            </div>
        </div>
        <div id="main">
            <header class="main-header">
                <div  class="container">
                    <div class="header-inner border-box_item">
                        <div class="header-social">
                            <ul>
                                <li><a href="https://www.facebook.com/Bel.CMS/" target="_blank">Meta</a></li>
                                <li><a href="https://discord.com/invite/BTGfQ6WRmp" target="_blank">Discord</a></li>
                                <li><a href="https://x.com/BelCMS_V3" target="_blank">X (Twitter)</a></li>
                            </ul>
                        </div>
                        <a href="index.php" class="logo-holder">
                        <img src="templates/belcms_v3.0.6_v4/images/logo.png" alt="">
                        </a>
                        <div class="header-contacts">
                            <ul>
                                <li><span>Tel : </span> <a href="tel:+32(0)143124" class="shuffleLetter">+32(0)143124</a></li>
                                <li><span>Mail : </span> <a href="mailto:admin@bel-cms.dev" class="shuffleLetter">admin@bel-cms.dev</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-holder-wrap border-box_item grid-column-container grid-sb-column srcl_init">
                        <div   class="nav_logo-holder to-top">
                            <img src="templates/belcms_v3.0.6_v4/images/small_logo.png" alt="">
                        </div>
                        <div class="nav-holder main-menu">
                            <div class="nav-button-container">
                                <div class="nav-button-wrap">
                                    <div class="menu-button-text">Menu</div>
                                    <div class="nav-button but-hol">
                                        <svg viewBox="0 0 64 48">
                                            <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                                            <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                                            <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="header-page_title"><span></span></div>
                            <div class="nav-wrapper isvis_menu">
                                <div class="nav-container">
                                    <div class="nav-decor" id="menu_anim"> </div>
                                    <div class="nav-wrap hid_vismen">
                                         <?php require_once 'menu.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress-indicator">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="-1 -1 34 34">
                                <circle cx="16" cy="16" r="15.9155"
                                    class="progress-bar__background" />
                                <circle cx="16" cy="16" r="15.9155"
                                    class="progress-bar__progress 
                                    js-progress-bar" />
                            </svg>
                        </div>
                        <div class="share-button-wrap showshare">
                            <div class="share-button_title">Share</div>
                            <div class="share-button"><span></span></div>
                        </div>
                        <div class="share-wrapper  isShare">
                            <div class="share-container fl-wrap  isShare"></div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="nav-ovelay fs-wrapper"></div>
            <div class="content" data-pagetitle="<?=$link;?>">
                <section class="content-section dark-section">
                    <div class="container">
                        <div class="content-item border-box_item2 hero_section hs2  hero_section_dec">
                            <div class="hero_section_content">
                                <h2>Bel-CMS</h2>
                                <h4>Vous souhaite la bienvenue sur le site web.</h4>
                            </div>
                            <div class="hero-con-aside">
                                <div class="hero-con-aside_dec"></div>
                                <a href="#sec2" class="strt_btn custom-scroll-link">
                                    <span>Commencer à explorer</span>
                                    <div class="scroll-down-wrap">
                                        <div class="mousey">
                                            <div class="scroller"></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="hero-con-aside_dec2"></div>
                            <div class="hero-con_dec"></div>
                        </div>
                    </div>
                    <div class="fs-wrapper parallax-section_bg" data-scrollax-parent="true">
                        <div class="overlay"></div>
                        <div class="bg" data-bg="templates/belcms_v3.0.6_v4/images/bg/1.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
                    </div>
                </section>
                <section class="content-section cs_dec cs_dec3" id="sec2">
                    <div class="container">
                        <div class="content-item border-box_item">
                            <div class="grid-column-container grid-sb-column">
                                <div class="grid-column-content">
                                    <div class="post-wrap post-wrap_init">
                                        <?php
                                        if ($var->link == strtolower('news')):
                                            echo $var->page;
                                        else:
                                        ?>
                                            <div class="content_box_item">
                                            <?php
                                            echo $var->page;
                                            ?>
                                            </div>
                                            <?php
                                            if (isset($var->widgets['bottom'])):
                                                foreach ($var->widgets['bottom'] as $title => $content):
                                                    echo $content['view'];
                                                endforeach;
                                            endif
                                            ?>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="grid-column-sb grid-column-sb_dec">
                                    <div class="box-widget-item">
                                        <div class="box-widget_title">FaceBook</div>
                                        <div class="box-widget_content">
                                        <div class="fb-page" data-href="https://www.facebook.com/Bel.CMS" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                                                <blockquote cite="https://www.facebook.com/Bel.CMS" class="fb-xfbml-parse-ignore">
                                                    <a href="https://www.facebook.com/Bel.CMS">Bel-c.m.s</a>
                                                </blockquote>
                                            </div>	
                                        </div>
                                    </div> 
                                    <div class="fixed-bar-container_wrapper fixed-bar">
                                        <div class="fixed-bar-container">
                                            <?php
                                            if (isset($var->widgets['right'])):
                                                foreach ($var->widgets['right'] as $title => $content):
                                                    echo $content['view'];
                                                endforeach;
                                            endif
                                            ?>								
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="limit-box"></div>
                        </div>
                    </div>
                </section>
                <?php include 'partners.php'; ?>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5176882397524933"
     crossorigin="anonymous"></script>
            </div>
            <div class="height-emulator"></div>
            <footer class="main-footer">
                <div class="container">
                    <div class="footer-inner border-box_item2">
                        <div class="grid-column-container grid-3-column">
                            <div class="footer-inner_item">
                                <div class="footer-box">
                                    <div class="footer-content-header">À propos</div>
                                    <div class="footer-about">
                                        <p style="text-align: justify;">Avec Bel-CMS, tu peux créer ton site rapidement, sans avoir besoin de connaissance en programmation, grâce à l'administration complète.
                                        Bel-CMS est la solution clés en main pour les débutants, il est très facile de créer des pages grâce à l'éditeur wysiwyg.</p>
                                    </div>
                                </div>
                                <div class="arrow_dec_wrap ardw_white">
                                    <div class="arrow_dec"></div>
                                </div>
                            </div>
                            <div class="footer-inner_item">
                                <div class="footer-box">
                                    <div class="footer-content-header">Contacts</div>
                                    <div class="footer-contacts">
                                        <ul>
                                            <li><span>Appel :</span><a href="tel">+32(0) 455 14 31 24</a></li>
                                            <li><span>Conatct  :</span><a href="Contact">admin@bel-cms.dev</a></li>
                                            <li><span>Trouve-nous : </span><a href="#">Belgium, Farciennes</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="footer-social">
                                    <ul>
                                        <li><a href="https://www.facebook.com/Bel.CMS/" target="_blank">Meta</a></li>
                                        <li><a href="https://discord.com/invite/BTGfQ6WRmp" target="_blank">Discord</a></li>
                                        <li><a href="https://x.com/BelCMS_V3" target="_blank">X</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="footer-inner_item">
                                <div class="subcribe-form">
                                    <div class="subcribe_title">Abonnez-vous à notre newsletter</div>
                                    <form id="subscribe">
                                        <label for="subscribe-email" class="subscribe-message"></label>
                                        <input class="enteremail" name="email" id="subscribe-email" placeholder="email" spellcheck="true" type="text">
                                        <button type="submit" id="subscribe-button" class="subscribe-button">Submit <i class="fal fa-long-arrow-right"></i></button>
                                    </form>
                                </div>
                                <div class="footer-dec"></div>
                            </div>
                        </div>
                        <div class="sub-footer">
                            <div class="policy-box">
                                <span>&#169; Bel-CMS <?=date ('Y');?> v3.0.6  -  All rights reserved. </span>
                            </div>
                            <div class="to-top to-top_btn belcms_genered"></div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <?=$var->javaScript;?>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
        <script  src="templates/belcms_v3.0.6_v4/js/plugins.js"></script>
        <script  src="templates/belcms_v3.0.6_v4/js/scripts.js"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZTZHBN5Q4D"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-ZTZHBN5Q4D');
        </script>
        <div id="endloading"><?php $time = (microtime(true) - $_SESSION['SESSION_START']); echo round($time, 3);?> secondes</div>
        <script>
            $(window).on('load', function() {
                var endloading = $('#endloading').text();
                $('.belcms_genered').append(endloading);
            });
        </script>
    </body>
</html>