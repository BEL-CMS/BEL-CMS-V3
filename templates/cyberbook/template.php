<?php
use BelCMS\PDO\BDD;
$var->link = strtolower($var->link);
$link = ucfirst($var->link);

function nbNews () {
	$sql = new BDD;
	$sql->table('TABLE_PAGES_NEWS');
	$sql->count();
    return $sql->data;
}
function nbDl () {
    $count = (int) 0;
	$sql = new BDD;
	$sql->table('TABLE_DOWNLOADS');
	$sql->queryAll();
    foreach ($sql->data as $view) {
        $count += $view->dls;
     }
    return $count;
}
function getNbPageView() {
    $count = (int) 0;
    $sql = New BDD();
    $sql->table('TABLE_PAGE_STATS');
    $sql->fields('nb_view');
    $sql->queryAll();

    foreach ($sql->data as $view) {
       $count += $view->nb_view;
    }
    return $count;
}
function getNbArticles () {
    $sql = New BDD();
    $sql->table('TABLE_ARTICLES');
    $sql->count();
    return $sql->data;
}
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <base href="<?=$var->host;?>">
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bel-CMS - <?=$link;?></title>
        <meta name="robots" content="index, follow">
        <meta name="keywords" content="C.M.S, système de gestion de contenu, content management system">
        <meta name="description" content="content management system">
        <?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/cyberbook/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/cyberbook/css/style.css">
        <link type="text/css" rel="stylesheet" href="templates/cyberbook/css/color.css">
		<link rel="apple-touch-icon" sizes="76x76" href="templates/cyberbook/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="templates/cyberbook/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="templates/cyberbook/favicon/favicon-16x16.png">
		<link rel="manifest" href="templates/cyberbook/favicon/site.webmanifest">
		<link rel="mask-icon" href="templates/cyberbook/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<link type="text/plain" rel="author" href="templates/cyberbook/humans.txt">
    </head>
    <body>
        <div class="main-loader-wrap" style="background: #FFF !important;">
            <div id="belcms_loading"><img src="templates/cyberbook/images/loading.gif" alt=""></div>
        </div>
        <div id="main">
            <header class="main-header">
                <a href="index.html" class="logo-holder color-bg"><img src="templates/cyberbook/images/logo.png" alt=""></a>
                <div class="social-container">
                    <span class="social-container_title">Social: </span>
                    <a href="https://www.facebook.com/Bel.CMS/" target="_blank"><i class="fa-brands fa-square-facebook"></i></a> 
                    <a href="https://discord.com/invite/BTGfQ6WRmp" target="_blank"><i class="fa-brands fa-discord"></i></a> 
                    <a href="https://twitter.com/BelCMS" target="_blank"><i class="fa-brands fa-x-twitter"></i></a> 
                </div>
                <div class="share_btn show_share"><strong>Share</strong> <span class="share_btn-icon"></span></div>
                <div class="nav-button-wrap">
                    <div class="menu-button-text">Menu</div>
                    <div class="nav-button but-hol">
                        <span  class="ncs"></span>
                        <span class="nos"></span>
                        <span class="nbs"></span>
                    </div>
                </div>
                <a href="#" class="pr_btn"><span class="pr_btn_dots"></span><strong>Projets</strong> <i class="fal fa-angle-right"></i></a>	
            </header>
            <div class="nav-holder isvis_menu">
                <div class="nav-overlay fs-wrapper"></div>
                <div class="nav-container">
                    <div class="nav-title hid_vismen"> me<br>nu <span>.</span>  </div>
                    <div class="hsd_dec2 hdec_d hid_vismen"></div>
                    <div class="nav-wrap hid_vismen">
                        <?php include 'menu.php'; ?>
                    </div>
                    <div class="nav_arrow hid_vismen"><span></span></div>
                </div>
            </div>
            <?php
            if ($var->link == 'news' and empty($var->fullwide) === true) {
                include 'home.php';
            } else if ($var->link == 'news' and !empty($var->fullwide) === true) {
                include 'readmore.php';
            } else {
                include 'page.php';
            }
            ?>
                <div class="height-emulator fl-wrap"></div>
                <footer class="main-footer">
                    <div class="footer-inner fl-wrap">
                        <div class="policy-box">
                            <span>&#169; Bel-CMS 2015 @ <?=date ('Y');?> . All rights reserved. </span>
                        </div>
                        <div class="footer-social">
                            <a style="color:#FFF;">Page générer en <span class="belcms_genered"></span></a>
                        </div>
                        <div class="to-top-btn color-bg to-top"><i class="fal fa-long-arrow-up"></i></div>
                        <div class="footer-dec color-bg"></div>
                    </div>
                </footer> 

            <div class="share-wrapper fs-wrapper isShare">
                <div class="share-overlay cl_sh fs-wrapper"></div>
                <div class="share-container fl-wrap  isShare">
                    <div class="share-text">
                        <svg viewBox="0 0 100 100" width="100" height="100">
                            <defs>
                                <path id="circle"
                                    d="
                                    M 50, 50
                                    m -37, 0
                                    a 37,37 0 1,1 74,0
                                    a 37,37 0 1,1 -74,0"/>
                            </defs>
                            <text font-size="17">
                                <textpath xlink:href="#circle">
                                    Share This Page  
                                </textpath>
                            </text>
                        </svg>
                    </div>
                    <div class="close-share-btn cl_sh"><i class="fal fa-times"></i></div>
                </div>
            </div>
            <div class="element">
                <div class="element-item"></div>
            </div>
        </div>
        <?=$var->javaScript;?>  
        <script  src="templates/cyberbook/js/plugins.js"></script>
        <script  src="templates/cyberbook/js/scripts.js"></script>
        <div id="endloading"><?php $time = (microtime(true) - $_SESSION['SESSION_START']); echo round($time, 3);?> secondes</div>
        <script src="templates/cyberbook/js/endloading.js"></script>
    </body>
</html>