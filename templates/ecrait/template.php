<?php
use BelCMS\User\User;
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
        <link type="text/css" rel="stylesheet" href="templates/ecrait/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/ecrait/css/style.css">
		<link rel="shortcut icon" href="templates/ecrait/favicon/favicon.ico">
		<link rel="apple-touch-icon" sizes="76x76" href="templates/ecrait/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="templates/ecrait/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="templates/ecrait/favicon/favicon-16x16.png">
		<link rel="manifest" href="templates/ecrait/favicon/site.webmanifest">
		<link rel="mask-icon" href="templates/ecrait/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<meta name="google-adsense-account" content="ca-pub-5176882397524933">
    </head>
    <body>
        <div class="loader">
            <div class="spinner">
                <div class="double-bounce2"></div>
            </div>
        </div>
        <div id="main">
            <header class="main-header">
                <a href="index.html" class="logo-holder ajax">
                <img src="templates/ecrait/images/logo.png" alt="">
                </a>
                <div class="nav-holder main-menu">
                    <?php include 'menu.php'; ?>
                </div>
                <div class="header-contacts">
                    <ul>
                        <li><span> Discord: </span> <a href="https://discord.gg/mV7ZPZgR4z">https://discord.gg/mV7ZPZgR4z</a></li>
                        <li><span> Mail: </span> <a href="Contact">webmaster@bel-cms.dev</a></li>
                    </ul>
                </div>
                <div class="nav-button_container">
                    <div class="nav-button but-hol">
                        <span  class="ncs"></span>
                        <span class="nos"></span>
                        <span class="nbs"></span>
                    </div>
                </div>
            </header>
            <div class="share-button-wrap showshare">
                <div class="share-button_title">Share</div>
                <div class="share-button"><span></span></div>
            </div>
            <div class="aside-column">
                <div class="progress-bar-wrap">
                    <div class="progress-bar-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>
                <div class="aside-social">
                    <ul>
                        <li><a href="#" target="_blank">Fb</a></li>
                        <li><a href="#" target="_blank">In</a></li>
                        <li><a href="#" target="_blank">Tw</a></li>
                        <li><a href="#" target="_blank">Be</a></li>
                    </ul>
                </div>
            </div>
            <div id="wrapper">
                <div class="content-holder" data-pagetitle="Blog post title">
                    <div class="content" data-pagetitle="Our Contacts">
                        <section class="content-section   dark-section">
                            <div class="container">
                                <div class="content-item border-box_item2 hero_section hs2  hero_section_dec">
                                    <div class="hero_section_content">
                                        <div class="hhw_header"></div>
                                        <h2>Bel-CMS</h2>
                                        <h4>Content Management System (CMS)</h4>
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
                            <div class="fs-wrapper parallax-section_bg">
                                <div class="overlay"></div>
                                <div class="bg" data-bg="templates/ecrait/images/bg/1.jpg"></div>
                            </div>
                        </section>
                        <section class="content-section cs_dec cs_dec3" id="sec2">
                            <div class="container">
                                <div class="content-item border-box_item">
                                    <div class="grid-column-container grid-sb-column">
                                        <div class="grid-column-content">
                                            <div class="post-wrap post-wrap_init fix-container-init">
                                                <!-- post-item-->
                                                 <?php echo $var->page; ?>
                                            </div>
                                        </div>
                                        <div class="grid-column-sb grid-column-sb_dec">
                                            <div class="blog-search-wrap">
                                                <input name="se" id="se" type="text" class="search" placeholder="Search.." value="">
                                                <button><i class="fal fa-search"></i></button>
                                            </div>
                                            <div class="fixed-bar-container_wrapper fixed-bar">
                                            <div class="box-widget-item">
                                            <div class="box-widget_title"> FaceBook (Meta)</div>
                                            <div class="box-widget_content">
                                                <div class="fb-page" data-href="https://www.facebook.com/Bel.CMS" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                                                    <blockquote cite="https://www.facebook.com/Bel.CMS" class="fb-xfbml-parse-ignore">
                                                        <a href="https://www.facebook.com/Bel.CMS">Bel-c.m.s</a>
                                                    </blockquote>
                                                </div> 
                                            </div>
                                        </div>
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
                                            <p style="text-align: justify;">Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p>
                                            <p style="text-align: justify;">Dans un langage plus simple, un système de gestion de contenu est un outil qui vous aide à construire un site Web sans avoir besoin d’écrire tout le code à partir de zéro (ou même de savoir comment coder du tout).</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-inner_item">
                                        <div class="footer-box">
                                            <div class="footer-content-header">Les contacts</div>
                                            <div class="footer-contacts">
                                                <ul>
                                                    <li><span>Tel:</span><a href="tel:0032455143124">+32455143124</a></li>
                                                    <li><span>Mqil  :</span><a href="#">webmaster@bel-cms.dev</a></li>
                                                    <li><span>Trouvez-nous : </span><a href="#">Belgique / Hainaut</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="footer-social">
                                            <ul>
                                                <li style="color: #FFF;">page generer en  <span style="color: red;" class="belcms_genered"></span>  secondes</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="footer-inner_item">
                                        <div class="subcribe-form">
                                            <div class="subcribe_title">Abonnez-vous à notre newsletter</div>
                                            <form id="subscribe" action="Newsletter/send">
                                                <label for="subscribe-email" class="subscribe-message"></label>
                                                <input class="enteremail" name="email" id="subscribe-email" placeholder="Your e-mail" spellcheck="false" type="text">
                                                <button type="submit" id="subscribe-button" class="subscribe-button"><span>Envoyer</span> <i class="fal fa-long-arrow-right"></i></button>
                                            </form>
                                        </div>
                                        <div class="footer-dec"></div>
                                    </div>
                                </div>
                                <div class="sub-footer">
                                    <div class="policy-box">
                                        <span>&#169; Bel-CMS <?=date('Y');?>   -  All rights reserved. </span>
                                    </div>
                                    <div class="to-top to-top_btn"><i class="far fa-chevron-up"></i></div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <div class="share-wrapper  isShare">
                        <div class="share-container fl-wrap  isShare"></div>
                    </div>
                </div>
            </div>
            <div class="element">
                <div class="element-item"></div>
            </div>
        </div>
        <?=$var->javaScript;?>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
        <script  src="templates/ecrait/js/jquery.min.js"></script>
        <script  src="templates/ecrait/js/plugins.js"></script>
        <script  src="templates/ecrait/js/scripts.js"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZTZHBN5Q4D"></script> 
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-ZTZHBN5Q4D');
        </script>
        <div id="endloading"><?php $time = (microtime(true) - $_SESSION['SESSION_START']); echo round($time, 3);?></div>
        <script>
            $(window).on('load', function() {
                var endloading = $('#endloading').text();
                $('.belcms_genered').append(endloading);
            });
        </script>
    </body>
</html>