<?php
$link = strtolower($this->configTPL->link);
?>
<!DOCTYPE HTML>
<html lang="fr">
    <head>
        <base href="<?=$var->host;?>">
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bel-CMS - <?=$this->configTPL->link;?></title>
        <?=$var->css;?>
        <link type="text/css" rel="stylesheet" href="templates/belcms_v.3.1.0/css/plugins.css">
        <link type="text/css" rel="stylesheet" href="templates/belcms_v.3.1.0/css/style.css">
        <link type="text/css" rel="stylesheet" href="templates/belcms_v.3.1.0/css/dark-style.css">			
        <link rel="shortcut icon" href="templates/belcms_v.3.1.0/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="76x76" href="templates/belcms_v.3.1.0/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="templates/belcms_v.3.1.0/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="templates/belcms_v.3.1.0/favicon/favicon-16x16.png">
        <link rel="manifest" href="templates/belcms_v.3.1.0/favicon/site.webmanifest">
        <link rel="mask-icon" href="templates/belcms_v.3.1.0/favicon/safari-pinned-tab.svg" color="#5bbad5">
    </head>
    <body>
        <!--loader-->
        <div class="loader-wrap">
            <div class="loader-inner">
                <svg>
                    <defs>
                        <filter id="goo">
                            <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                            <fecolormatrix in="blur"   values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" />
                            <fecomposite in="SourceGraphic" in2="gooey" operator="atop"/>
                        </filter>
                    </defs>
                </svg>
            </div>
        </div>
        <!--loader end-->
        <!--  main   -->
        <div id="main">
            <!--header-->
            <header class="main-header">
                <div class="container">
                    <div class="header-inner">
                        <a href="index.php" class="logo-holder"><img src="templates/belcms_v.3.1.0/images/logo.png" alt=""></a>
                        <div class="nav-holder main-menu">
                            <?php include 'menu.php'; ?>
                        </div>
                        <div class="nav-button-wrap">
                            <div class="nav-button">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                        <a href="https://github.com/BEL-CMS/BEL-CMS-V3" class="header-btn"><span>Télécharger Github</span></a>
                        <div class="show-reg-form modal-open"><i class="fa-thin fa-user"></i><span>Sign In</span></div>
                    </div>
                </div>
            </header>
            <div class="body-overlay fs-wrapper search-form-overlay close-search-form"></div>
            <div class="wrapper">
                <!--content-->
                <div class="content">
                    <!--section-->
                    <div class="section hero-section hero-section_sin">
                        <div class="hero-section-wrap">
                            <div class="hero-section-wrap-item">
                                <div class="container">
                                    <div class="hero-section-container">
                                        <div class="hero-section-title">
                                            <h2>Bel-CMS</h2>
                                            <h5>Vous souhaite la bienvenue sur le site web.</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="hs-scroll-down-wrap">
                                    <div class="scroll-down-item">
                                        <div class="mousey">
                                            <div class="scroller"></div>
                                        </div>
                                        <span>Scroll</span>
                                    </div>
                                    <div class="svg-corner svg-corner_white"  style="bottom:0;right: -39px; transform: rotate( 90deg)" ></div>
                                    <div class="svg-corner svg-corner_white"  style="bottom:0;left:  -39px;"></div>
                                </div>
                                <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
                                    <div class="bg" data-bg="templates/belcms_v.3.1.0/images/bg/1.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--section-end-->				
                    <!--container-->
                    <div class="container">
                        <!--breadcrumbs-list-->
                        <div class="breadcrumbs-list bl_flat">
                            <a href="index.php">Home</a><span><?=$this->configTPL->link;?></span>
                            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
                        </div>
                        <!--breadcrumbs-list end-->					
                        <!--main-content-->
                        <div class="main-content">
                            <!--boxed-container-->
                            <div class="boxed-container">
                                <?php
                                    if ($link == 'news'):
                                    ?>
                                    <div class="scroll-content-wrap">
                                        <div class="share-holder init-fix-column">
                                            <span class="share-title">  Share   </span>
                                            <div class="share-container  isShare"></div>
                                        </div>
                                    <?php
                                    else:
                                    ?>
                                    <div class="scroll-content-wrap full">
                                    <?php
                                    endif;
                                    ?>
                                    <div class="row">
                                        <?php
                                        if ($var->fullwide == true):
                                        ?>
                                        <div class="boxed-container">
                                            <div class="boxed-content ">
                                                <div class="about-wrap boxed-content-item">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php echo $var->page; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        else:
                                        ?>
                                        <div class="col-lg-8">
                                            <?php echo $var->page; ?>
                                        </div>
                                        <div class="col-lg-4">
                                            <!--boxed-container-->
                                            <div class="sb-container fixed-bar">
                                                <!-- main-sidebar-widget-->   
                                                <div class="boxed-content">
                                                    <div class="boxed-content-title">
                                                        <h3>Facebook (Meta)</h3>
                                                    </div>
                                                    <div class="boxed-content-item">
                                                        <div class="fb-page" data-href="https://www.facebook.com/Bel.CMS" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
                                                            <blockquote cite="https://www.facebook.com/Bel.CMS" class="fb-xfbml-parse-ignore">
                                                                <a href="https://www.facebook.com/Bel.CMS">Bel-c.m.s</a>
                                                            </blockquote>
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
                                    </div>
                                </div>
                                <div class="limit-box"></div>
                            </div>
                            <?php
							endif;
							?>
                            <!--boxed-container end-->
                        </div>
                        <!--main-content end-->
                        <div class="to_top-btn-wrap">
                            <div class="to-top to-top_btn"><span>Back to top</span> <i class="fa-solid fa-arrow-up"></i></div>
                            <div class="svg-corner svg-corner_white"  style="top:0;left:  -40px; transform: rotate(-90deg)"></div>
                            <div class="svg-corner svg-corner_white"  style="top:0;right: -40px; transform: rotate(-180deg)"></div>
                        </div>
                    </div>
                    <!-- container end-->
                </div>
                <!--content  end-->
                <!--main-footer-->
                <div class="height-emulator"></div>
                <footer class="main-footer">
                    <div class="container">
                        <div class="footer-inner">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="footer-widget">
                                        <div class="footer-widget-title">À propos</div>
                                        <div class="footer-widget-content">
                                            <p style="text-align: justify;">Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p>
                                            <p style="text-align: justify;">Dans un langage plus simple, un système de gestion de contenu est un outil qui vous aide à construire un site Web sans avoir besoin d’écrire tout le code à partir de zéro (ou même de savoir comment coder du tout).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="footer-widget">
                                        <div class="footer-widget-title">Liens important</div>
                                        <div class="footer-widget-content">
                                            <div class="footer-list footer-box  ">
                                                <ul>
                                                    <li><a title="Contact" href="Contact">Contacts</a></li>
                                                    <li><a title="Cookies" href="Cookies">Cookies</a></li>
                                                    <li><a title="Privacy Policy" href="#">Privacy Policy</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="footer-widget">
                                        <div class="footer-widget-title">Les contacts</div>
                                        <div class="footer-widget-content">
                                            <div class="footer-list footer-box  ">
                                                <ul  class="footer-contacts  ">
                                                    <li><span>E-Mail :</span><a title="Me contacté" href="mailto:contact@bel-cms.dev?subject=Contact depuis le site Bel-CMS&body=Bonjour, " target="_blank">contact@bel-cms.dev</a></li>
                                                    <li> <span>Adresse :</span><a title="adresse" href="#" target="_blank">Belgique / Farciennes</a></li>
                                                    <li><span>Téléphone :</span><a title="téléphone" href="tel:0032455143124">+32(0)455.14.31.24</a></li>
                                                </ul>
                                                <a href="Contact" title="contact" class="footer-widget-content-link"><span>Contactez-nous ici</span><i class="fa-solid fa-caret-right"></i></a>	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="footer-widget">
                                        <div class="footer-widget-title">S'abonner</div>
                                        <div class="footer-widget-content">
                                            <p>Vous souhaitez être informé lorsque nous lançons une nouvelle version de mise à jour. Inscrivez-vous et nous vous enverrons une notification par e-mail.</p>
                                            <form id="subscribe" class="subscribe-item" action="Newsletter/send">
                                                <input required class="enteremail" name="email" id="subscribe-email" placeholder="Votre E-mail" spellcheck="false" type="mail">
                                                <button type="submit" id="subscribe-button" class="subscribe-button"><span>Souscrire</span> </button>
                                                <label for="subscribe-email" class="subscribe-message"></label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer-bottom">
                            <div class="copyright"> <span><i class="fa-regular fa-copyright"></i> Bel-CMS <?=date('Y');?> v3.1.0</span> . All rights reserved. </div>
                            <div class="footer-social">
                                <span class="footer-social-title">Page généré en <span class="belcms_genered"></span></span>
                                <div class="footer-social-wrap">

                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!--main-footer end-->
            </div>
            <!--warpper end-->
            <!--wish-list-wrap end-->
            <div class="mob-nav-overlay fs-wrapper"></div>
            <div class="body-overlay fs-wrapper wishlist-wrap-overlay clwl_btn"></div>
			<div class="main-register-container">
				<div class="main-register_box">
					<div class="main-register-holder">
						<div class="main-register-wrap ">
							<div class="main-register_bg">
								<div class="mr_title">
									<h4>Bienvenue sur Bel-CMS</h4>
									<h5>Connectez-vous pour partager vos sites et création</h5>
								</div>
								<div class="main-register_contacts-wrap">
									<h4>Vous avez des questions ?</h4>
									<a href="contact">  Contacte-nous</a>
									<div class="svg-corner svg-corner_white"  style="bottom:0;left:  -39px;"></div>
									<div class="svg-corner svg-corner_white"  style="bottom:0;right:  -39px;transform: rotate(90deg)"></div>
								</div>
								<div class="main-register_bg-dec"></div>
							</div>
							<div class="main-register tabs-act fl-wrap">
								<ul class="tabs-menu">
									<li class="current"><a href="#tab-1"><i class="fa-solid fa-user-check"></i> Login</a></li>
								</ul>
								<div class="close-modal close-reg-form"><i class="fa-solid fa-circle-xmark"></i></div>
								<div id="tabs-container">
									<div class="tab">
										<div id="tab-1" class="tab-content first-tab">
											<div class="custom-form">
												<form method="post" name="registerform" action="User/login&echo">
													<div class="cs-intputwrap">
														<i class="fa-light fa-user"></i>
														<input type="text" name="username" placeholder="Nom d'utilisateur ou e-mail" required>
													</div>
													<div class="cs-intputwrap pass-input-wrap">
														<i class="fa-light fa-lock"></i>
														<input type="password" name="password" class="pass-input" placeholder="Mot de passe" required>
														<div class="view-pass"></div>
													</div>
													<div class="clearfix"></div>
													<button type="submit" class="commentssubmit"> Log-In </button>
												</form>
											</div>
										</div>
									</div>
									<div class="log-separator fl-wrap"><span>Ou</span></div>
									<div class="soc-log  fl-wrap">
										<p>Pour une connexion ou une inscription plus rapide, utilisez votre compte social.</p>
										<a href="#" class="google_log"><i class="fa-brands fa-google"></i> Se connecter avec Google</a>
										<a href="#" class="fb_log"><i class="fa-brands fa-facebook-f"></i> Se connecter avec Facebook</a>
										<p>* Non disponible actuellement.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="body-overlay fs-wrapper reg-overlay close-reg-form"></div>
			</div>
            <!--register form end -->			
            <!-- progress-bar  -->
            <div class="progress-bar-wrap">
                <div class="progress-bar color-bg"></div>
            </div>
            <!-- progress-bar end -->			
        </div>
        <!-- Main end -->
        <?=$var->javaScript;?>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
        <script  src="templates/belcms_v.3.1.0/js/jquery.min.js"></script>
        <script  src="templates/belcms_v.3.1.0/js/plugins.js"></script>
        <script  src="templates/belcms_v.3.1.0/js/scripts.js"></script>
        <div id="endloading"><?php $time = (microtime(true) - $_SESSION['SESSION_START']); echo round($time, 3);?> secondes</div>
        <script>
            $(window).on('load', function() {
                var endloading = $('#endloading').text();
                $('.belcms_genered').append(endloading);
            });
        </script>
    </body>
</html>