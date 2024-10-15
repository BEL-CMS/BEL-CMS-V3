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
		<link type="text/css" rel="stylesheet" href="templates/belcms_v3.0.8/css/plugins.css">
		<link type="text/css" rel="stylesheet" href="templates/belcms_v3.0.8/css/style.css">
		<link rel="shortcut icon" href="templates/belcms_v3.0.6_v4/templates/belcms_v3.0.8/images/favicon.ico">
		<link rel="apple-touch-icon" sizes="76x76" href="templates/belcms_v3.0.8/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="templates/belcms_v3.0.8/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="templates/belcms_v3.0.8/favicon/favicon-16x16.png">
		<link rel="manifest" href="templates/belcms_v3.0.8/favicon/site.webmanifest">
		<link rel="mask-icon" href="templates/belcms_v3.0.8/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
		<meta name="google-adsense-account" content="ca-pub-5176882397524933">
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
		<?php
		echo $RGPD;
		?>
		<!--  main   -->
		<div id="main">
			<!--header-->
			<header class="main-header">
				<div class="container">
					<div class="header-inner">
						<a href="index.php" title="Index" class="logo-holder">
							<img src="templates/belcms_v3.0.8/images/logo.png" alt="Logo Bel-CMS">
						</a>
						  <?php include 'menu.php'; ?>
						<div class="nav-button-wrap">
							<div class="nav-button">
								<span></span><span></span><span></span>
							</div>
						</div>
						<a href="#" title="Bel-CMS" id="bookmark-this" class="header-btn"><span>Ajoutez à vos favoris</span></a>
						<?php
						if (User::isLogged() != true):
						?>
						<div class="show-reg-form modal-open"><i class="fa-thin fa-user"></i><span>Loguer</span></div>
						<?php
						endif
						?>		
					</div>
				</div>
			</header>
			<div class="wrapper">
				<div class="content">
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
										<span>Scroll Down</span>
									</div>
									<div class="svg-corner svg-corner_white"  style="bottom:0;right: -39px; transform: rotate( 90deg)" ></div>
									<div class="svg-corner svg-corner_white"  style="bottom:0;left:  -39px;"></div>
								</div>
								<div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper" data-scrollax-parent="true">
									<div class="bg" data-bg="templates/belcms_v3.0.8/images/bg/1.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="breadcrumbs-list bl_flat">
							<a href="index.php" title="Accueil">Accueil</a><a title="/<?=$link;?>" href="/<?=$link;?>"><?=$link;?></a>
							<?php if (isset($var->view) and !empty($var->view)) {
								echo '<span>'.$var->view.'</span>';
							}
							?>
							<div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
						</div>
						<div class="main-content">
							<?php
							$linkM = strtolower($var->link);
							if ($linkM == 'news' and $var->fullwide == true):
							?>
								<?php echo $var->page; ?>
							<?php
							?>
							<?php
							elseif ($var->fullwide == true):
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
							<div class="boxed-container">
								<div class="scroll-content-wrap">
									<div class="row">
										<div class="col-lg-8">
											<?php echo $var->page; ?>
										</div>
										<div class="col-lg-4">
											<!--boxed-container-->
											<div class="sb-container fixed-bar">
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
							include 'partners.php';
							endif;
							?>
							<div class="api-wrap">
								<div class="api-container">
									<div class="api-img">
										<img src="templates/belcms_v3.0.8/images/bg/bg_join.png" alt="" class="respimg">
									</div>
									<div class="api-text">
										<h3>Prêt à rejoindre mon projet ?</h3>
										<p>Vous désirez rejoindre mon projet, rien de plus simple, rendez-vous sur le forum, posé votre candidature ou par Discord / email.</p>
										<div class="api-text-links">
											<a href="https://discord.gg/mV7ZPZgR4z" title="Discord"><span> Doscrd</span>  <i class="fa-brands fa-discord"></i></a>
											<a href="https://www.facebook.com/Bel.CMS/" title="Facebook"><span> Facebook</span>  <i class="fa-brands fa-facebook-f"></i></a>
										</div>
									</div>
									<div class="api-wrap-bg" data-run="2">
										<div class="api-wrap-bg-container">
											<span class="api-bg-pin api-bg-pin-vis"></span><span class="api-bg-pin"></span>
											<div class="abs_bg"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="to_top-btn-wrap">
							<div class="to-top to-top_btn"><span>Retour en haut</span> <i class="fa-solid fa-arrow-up"></i></div>
							<div class="svg-corner svg-corner_white"  style="top:0;left:  -40px; transform: rotate(-90deg)"></div>
							<div class="svg-corner svg-corner_white"  style="top:0;right: -40px; transform: rotate(-180deg)"></div>
						</div>
					</div>
				</div>
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
							<div class="copyright"> <span><i class="fa-regular fa-copyright"></i> Bel-CMS <?=date('Y');?> v3.0.8</span> . All rights reserved. </div>
							<div class="footer-social">
								<span class="footer-social-title">Page généré en <span class="belcms_genered"></span></span>
								<div class="footer-social-wrap">

								</div>
							</div>
						</div>
					</div>
				</footer>
			</div>
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
			<div class="progress-bar-wrap">
				<div class="progress-bar color-bg"></div>
			</div>
		</div>
		<?=$var->javaScript;?>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
		<script  src="templates/belcms_v3.0.8/js/plugins.js"></script>
		<script  src="templates/belcms_v3.0.8/js/scripts.js"></script>
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