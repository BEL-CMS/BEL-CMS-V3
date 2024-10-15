<?php
use BelCMS\User\User;
$link = defined(strtoupper($var->link)) ? constant(strtoupper($var->link)) : ucfirst($var->link);
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
        <title>Bel-CMS - <?=$link;?></title>
        <base href="<?=$var->host;?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="google-adsense-account" content="ca-pub-5176882397524933">
        <link type="text/css" rel="stylesheet" href="templates/grafon/css/reset.css">
        <?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/grafon/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/grafon/css/style.css">
        <link type="text/css" rel="stylesheet" href="templates/grafon/css/color.css">
        <link type="text/css" rel="stylesheet" href="templates/grafon/css/yourstyle.css">
        <link rel="shortcut icon" href="templates/grafon/images/favicon.ico">
    </head>
    <body>
        <div class="loader-holder">
            <div class="loader-inner loader-vis">
                <div class="loader"></div>
            </div>
        </div>
        <div id="main">
            <div class="wrapper-inner">
                <!-- top bar -->
                <div class="top-bar">
                    <div class="top-bar-header">
                        <div class="dynamic-title">
                            <span>Page : <h2><a class="ajax" href="#"><?=$link;?></a></h2></span> 
                        </div>
                        <ul class="topbar-social">
                            <li><a href="https://www.facebook.com/Bel.CMS/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="https://x.com/BelCMS_V3" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <div class="top-bar-header-contact">
                        <ul>
                            <li><i class="fa-brands fa-discord"></i><span>Discord</span><a href="https://discord.gg/mV7ZPZgR4z" title="Discord">https://discord.gg/mV7ZPZgR4z</a></li>
                            <li><i class="fa-brands fa-facebook"></i><span>Facebook</span><a href="https://www.facebook.com/Bel.CMS/" title="Facebook"> "https://www.facebook.com/Bel.CMS/</a></li>
                            <li><i class="fa fa-envelope-o"></i><span>Email</span><a href="Contact"> webmaster@bel-cms.dev</a></li>
                        </ul>
                    </div>
                    <a  href="contacts.html#contact-form" class="con-link ajax">Write us</a>
                </div>
                <header class="main-header">
                    <div class="logo-holder">
                        <a href="index.html" class="ajax"><img src="templates/grafon/images/logo.png" alt=""></a>
                    </div>
                    <div class="nav-button"><span></span><span></span><span></span></div>
                    <div class="panel-button"><i class="fa fa-level-up"></i></div>
                    <div class="nav-holder">
                        <?php
                        include 'menu.php';
                        ?>
                    </div>
                    <div class="brochure-box">
                        <a href="downloads/detail/6/Bel_CMS_V3"><i class="fa fa-file-pdf-o pdf-ic "></i><span>Download C.M.S</span><i class="fa fa-caret-down lay-ic"></i></a>
                    </div>
                </header>
                <div class="wrap-bg">
                    <div id="wrapper">
                        <div class="content-holder  scale-bg2 home-content" data-bgs="templates/grafon/images/bg/long/1.jpg" data-dyntitle="Home Youtube Video">
                            <div class="content">
                                <section class="no-padding">
                                    <div class="hero-wrap">
                                        <div class="media-container">
                                            <div class="video-holder">
                                                <div class="video-mask"></div>
                                                <div class="bg mob-bg"  data-bg="images/bg/1.jpg"></div>
                                                <div  class="background-youtube" data-vid="templates/grafon/video/1.mp4" data-mv="1"> 
                                                    <video src="templates/grafon/video/1.mp4" type="video/mp4" autoplay ></video>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- video end-->
                                        <div class="overlay"></div>
                                        <div class="container">
                                            <h2>Bel-CMS</h2>
                                            <h3>Content Management System (CMS)</h3>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                            if ($var->fullwide == true):
                                            ?>
                                            <div class="col-md-12">
                                                <?php
                                                 echo $var->page;
                                                ?>
                                            </div>
                                            <?php
                                            else:
                                            ?>
                                            <div class="col-md-8">
                                                <?php
                                                echo $var->page;
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="widget-sidebar">
                                                <?php
                                                if (isset($var->widgets['right'])):
                                                    foreach ($var->widgets['right'] as $title => $content):
                                                        echo $content['view'];
                                                    endforeach;
                                                endif
                                                ?>
                                                </div>
                                            </div>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </section>
                                <section class="no-padding">
                                    <div class="announcement color-bg">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h3>Entrer en contact</h3>
                                                    <p>Prêt à participe au projet ? Écrivez-nous...</p>
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="Contacts"  class="btn ajax dark-bg hide-icon"><i class="fa fa-angle-right"></i><span>Contacts</span></a>	
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <footer>
                                <div class="footer-header">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="footer-info">
                                                    <h4>About</h4>
                                                    <p>Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="footer-info">
                                                    <h4>Contact info</h4>
                                                    <ul class="footer-contacts">
                                                        <li><a href="tel:+320455143124"> <i class="fa fa-phone"></i> +(0032)455143124</a></li>
                                                        <li><a href="#"><i class="fa fa-motorcycle"></i> Belgium</a></li>
                                                        <li><a href="#"><i class="fa fa-envelope-o"></i> webmaster@web-help.dev</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="footer-info">
                                                    <h4>Our Services</h4>
                                                    <div class="footer-serv-holder">
                                                        <ul>
                                                            <li><a href="#">Design and Build</a></li>
                                                            <li><a href="#">Household Repairs</a></li>
                                                            <li><a href="#">Tiling and Painting</a></li>
                                                        </ul>
                                                        <ul>
                                                            <li><a href="#">Design and Build</a></li>
                                                            <li><a href="#">Household Repairs</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-footer">
                                    <div class="container">
                                        <div class="copy-right">Copyright © 2015 - <?=date('Y');?> <a href="https://bel-cms.dev" class="ajax">Bel-CMS V3.0.9</a>  All Rights Reserved</div>
                                        <div class="footer-time">
                                            Page généré en <span style="color: #f1c311;" class="belcms_genered"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer-dec" data-top-bottom="transform: translateY(150px);" data-bottom-top="transform: translateY(-150px);"></div>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
            <div class="to-top">
                <i class="fa fa-long-arrow-up"></i>
            </div>
            <div class="body-bg">
                <div class="body-bg-wrap"></div>
            </div>
            <div class="fixed-column">
                <div class="fix-bg-wrap">
                    <div id="bgd"></div>
                </div>
                <div class="overlay"></div>
            </div>
        </div>
        <script type="text/javascript" src="templates/grafon/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/grafon/js/plugins.js"></script>
        <script type="text/javascript" src="templates/grafon/js/core.js"></script>
        <script type="text/javascript" src="templates/grafon/js/scripts.js"></script>
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