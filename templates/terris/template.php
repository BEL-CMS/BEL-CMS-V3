<?php
$link = defined(strtoupper($var->link)) ? constant(strtoupper($var->link)) : ucfirst($var->link);
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <base href="<?=$var->host;?>">
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="google-adsense-account" content="ca-pub-5176882397524933">
        <title>Bel-CMS - <?=$var->link;?></title>
		<link rel="shortcut icon" href="templates/belcms_v3.0.6_v4/templates/belcms_v3.0.8/images/favicon.ico">
		<link rel="apple-touch-icon" sizes="76x76" href="templates/belcms_v3.0.8/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="templates/belcms_v3.0.8/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="templates/belcms_v3.0.8/favicon/favicon-16x16.png">
		<link rel="manifest" href="templates/belcms_v3.0.8/favicon/site.webmanifest">
		<link rel="mask-icon" href="templates/belcms_v3.0.8/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/terris/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/terris/css/style.css">
        <link rel="shortcut icon" href="templates/terris/mages/favicon.ico">
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
                                <li><a href="https://www.facebook.com/Bel.CMS/" title="FaceBook Bel-CMS" target="_blank">Meta</a></li>
                                <li><a href="https://discord.gg/mV7ZPZgR4z" title="Discord Bel-CMS" target="_blank">discord</a></li>
                                <li><a href="https://twitter.com/BelCMS_V3" title="Twitter (x) Bel-CMS" target="_blank">Twitter</a></li>
                            </ul>
                        </div>
                        <a href="index.html" class="logo-holder">
                        <img src="templates/terris/images/logo.png" alt="">
                        </a>
                        <div class="header-contacts">
                            <ul>
                                <li><span>WhatsApp: </span> <a href="tel:+32(0)143124" class="shuffleLetter">+32(455)143124</a></li>
                                <li><span>e-Mail: </span> <a href="mailto:contact@bel-cms.dev" class="shuffleLetter">contact@bel-cms.dev</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-holder-wrap border-box_item grid-column-container grid-sb-column srcl_init">
                        <div   class="nav_logo-holder to-top">
                            <img src="templates/terris/images/small_logo.png" alt="">
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
                                        <!-- nav -->
                                            <?php include 'menu.php'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- mobile nav -->
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
                <section class="content-section   dark-section">
                    <div class="container">
                        <div class="content-item border-box_item2 hero_section hs2  hero_section_dec">
                            <div class="hero_section_content">
                                <div class="hhw_header">Bienvenue sur mon site Bel-CMS</div>
                                <h2>Site Officel Bel-C.M.S.</h2>
                            </div>
                            <div class="hero-con-aside">
                                <div class="hero-con-aside_dec"></div>
                                <a href="#sec2" class="strt_btn custom-scroll-link">
                                    <span>Start Explore</span>
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
                        <video class="bg" autoplay playsinline loop muted  class="bgvid">
                            <source src="templates/terris/video/1.mp4" type="video/mp4">
                        </video>
                    </div>
                </section>
                <section class="content-section cs_dec cs_dec3" id="sec2">
                    <div class="container">
                        <div class="content-item border-box_item">
                            <div class="grid-column-container grid-sb-column">
                                <div class="grid-column-content">
                                    <div class="post-wrap post-wrap_init">
                                        <?php echo $var->page; ?>
                                    </div>
                                </div>
                                <div class="grid-column-sb grid-column-sb_dec">
                                    <div class="blog-search-wrap">
                                        <input name="se" id="se" type="text" class="search" placeholder="Recherche..." value="">
                                        <button><i class="fal fa-search"></i></button>
                                    </div>
                                    <div class="fixed-bar-container_wrapper fixed-bar">
                                        <div class="fixed-bar-container">
                                            <div class="boxed-content">
                                            <div class="box-widget-item">
                                                <div class="box-widget_title">Facebook (Meta)</div>
                                                <div class="box-widget_content">
                                                <div class="boxed-content-item">
                                                    <div class="fb-page" data-href="https://www.facebook.com/Bel.CMS" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                                                        <blockquote cite="https://www.facebook.com/Bel.CMS" class="fb-xfbml-parse-ignore">
                                                            <a href="https://www.facebook.com/Bel.CMS">Bel-c.m.s</a>
                                                        </blockquote>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
											</div>
                                            <?php
                                            if (isset($var->widgets['right'])):
                                                foreach ($var->widgets['right'] as $title => $content):
                                                    echo $content['view'];
                                                endforeach;
                                            endif
                                            ?>
                                        </div>
                                    </div>
                                    <!--fixed-bar-container_wrapper end-->
                                </div>
                                <!--sidebar end-->
                            </div>
                            <div class="limit-box"></div>
                        </div>
                    </div>
                </section>
                <!-- section end -->			
            </div>
            <!-- content end -->
            <!-- main-footer -->
            <div class="height-emulator"></div>
            <footer class="main-footer">
                <div class="container">
                    <div class="footer-inner border-box_item2">
                        <div class="grid-column-container grid-3-column">
                            <div class="footer-inner_item">
                                <div class="footer-box">
                                    <div class="footer-content-header">À propos</div>
                                    <div class="footer-about">
                                        <p style="text-align: justify;">Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p>
                                    </div>
                                </div>
                                <div class="arrow_dec_wrap ardw_white">
                                    <div class="arrow_dec"></div>
                                </div>
                            </div>
                            <div class="footer-inner_item">
                                <div class="footer-box">
                                    <div class="footer-content-header">Terris Contacts</div>
                                    <!-- footer-contacts-->
                                    <div class="footer-contacts">
                                        <ul>
                                            <li><span>WhatsApp:</span><a href="tel:0455143124">+32 (455.14.31.24)</a></li>
                                            <li><span>e-Mail  :</span><a href="#">contact@bel-cms.dev</a></li>
                                            <li><span>Localisation : </span><a href="#">Belgique</a></li>
                                        </ul>
                                    </div>
                                    <!-- footer contacts end -->
                                </div>
                                <div class="footer-social">
                                    <ul>
                                        <li><a href="#" target="_blank">Fb</a></li>
                                        <li><a href="#" target="_blank">In</a></li>
                                        <li><a href="#" target="_blank">Tw</a></li>
                                        <li><a href="#" target="_blank">Be</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="footer-inner_item">
                                <div class="subcribe-form">
                                    <div class="subcribe_title">Abonnez-vous à notre newsletter</div>
                                    <form id="subscribe">
                                        <label for="subscribe-email" class="subscribe-message"></label>
                                        <input class="enteremail" name="email" id="subscribe-email" placeholder="email" spellcheck="false" type="text">
                                        <button type="submit" id="subscribe-button" class="subscribe-button">Submit <i class="fal fa-long-arrow-right"></i></button>
                                    </form>
                                </div>
                                <div class="footer-dec"></div>
                            </div>
                        </div>
                        <div class="sub-footer">
                            <div class="policy-box">
                                <span>&#169; Bel-CMS v.3.1.0   -   <?=date('Y');?>   -  All rights reserved. </span>
                            </div>
                            <div class="to-top to-top_btn"><i class="far fa-chevron-up"></i></div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- footer end -->
        </div>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
        <script  src="templates/terris/js/jquery.min.js"></script>
        <script  src="templates/terris/js/plugins.js"></script>
        <script  src="templates/terris/js/scripts.js"></script>
    </body>
</html>