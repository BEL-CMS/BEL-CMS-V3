<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bannissement(s)</title>
        <link type="text/css" rel="stylesheet" href="/ban/tpl/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="/ban/tpl/css/style.css">
        <link rel="shortcut icon" href="/ban/tpl/images/favicon.ico">
        <link type="text/plain" rel="author" href="/ban/tpl/humans.txt">
    </head>
    <body>
        <div id="main">
            <div class="cs-wrap">
                <div class="hero-wrap soon-wrap">
                    <div class="impulse-wrap">
                        <div class="mm-parallax">
                            <div class="half-hero-wrap section-entry">
                                <h1><?=constant('GOOD_MORNING');?><br><?=constant('YOU_ARE_BANNED');?></h1>
                                <div class="counter-widget fl-wrap" data-countDate="<?=$this->countDate;?>" data-fuseau="<?=$this->fuseau;?>">
                                    <div class="countdown fl-wrap">
                                        <div class="countdown-item">
                                            <span class="years rot">0</span>
                                            <p><?=constant('YEAR');?></p>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="days rot">0</span>
                                            <p><?=constant('DAYS');?></p>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="hours rot">0</span>
                                            <p><?=constant('HOURS');?></p>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="minutes rot2">0</span>
                                            <p><?=constant('MINUTES');?></p>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="seconds rot2">0</span>
                                            <p><?=constant('SECONDS');?></p>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($this->reason)):
                                    ?>
                                        <h4 style="display: block;width: 100%;"><?=$this->reason;?></h4>
                                    <?php
                                    endif;
                                    ?>
                                    <?php
                                    if (isset($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE']) AND !empty($_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'])) {
                                        $mail = $_SESSION['CONFIG_CMS']['CMS_MAIL_WEBSITE'];
                                    } else {
                                        $mail = $_SERVER['SERVER_ADMIN'];
                                    }
                                    ?>
                                    <span>
                                        <p>Si vous pensez que c'est une erreur, contactée l'administrateur du site. <a href="mailto:<?=$mail;?>?subject=Bannissement&body=Bonjour%2C%0Aje%20pense%20que%20j'ai%20%C3%A9t%C3%A9%20banni%20par%20erreur.">E-mail administrateur</a></p>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-dec"><span class="bd-item bd-item_t"></span><span class="bd-item bd-item_b"></span></div>
                <div class="body-grid-holder">
                    <div class="body-grid"></div>
                </div>
            </div>
        </div>
        <script src="/ban/tpl/js/jquery.min.js"></script>
        <script src="/ban/tpl/js/scripts.js"></script>
    </body>
</html>