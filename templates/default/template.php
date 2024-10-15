<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<base href="<?=$var->host;?>">
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Bel-CMS - <?=$var->link;?></title>
		<?=$var->css;?>
		<link type="text/css" rel="stylesheet" href="templates/default/css/plugins.css">
		<link type="text/css" rel="stylesheet" href="templates/default/css/style.css">
		<link rel="shortcut icon" href="templates/default/images/favicon.ico">
	</head>
	<body>
		<div class="loader-wrap">
			<div class="loader-item">
				<div class="cd-loader-layer" data-frame="25">
					<div class="loader-layer"></div>
				</div>
				<span class="loader"><i class="fa-solid fa-bars-progress fa-spin"></i></span>
			</div>
		</div>
		<div id="main">
			<header class="main-header">
				<div class="container">
					<div class="header-top  fl-wrap">
						<div class="header-top_contacts"><a href="https://discord.gg/mV7ZPZgR4z"><span>Discord:</span> discord.gg/mV7ZPZgR4z</a></div>
						<div class="header-social">
							<ul>
								<li><a href="https://www.facebook.com/Bel.CMS/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
								<li><a href="https://x.com/BelCMS_V3" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
							</ul>
						</div>
						<div class="lang-wrap"><a href="#" class="act-lang">En</a><span>/</span><a href="#">Fr</a></div>
					</div>
					<div class="nav-holder-wrap init-fix-header  fl-wrap">
						<a href="index.html" class="logo-holder"><img src="templates/default/images/logo2.png" alt=""></a>
						<div class="nav-holder main-menu">
							<?php include 'menu.php'; ?>
						</div>
						<div class="serach-header-btn_wrap">							
							<a href="search" class="serach-header-btn"><i class="fa-light fa-magnifying-glass"></i> <span>Recherche</span></a>
						</div>
						<div class="show-share-btn showshare htact"><i class="fa-light fa-share-nodes"></i><span class="header-tooltip">Social</span></div>
						<div class="nav-button-wrap">
							<div class="nav-button">
								<span></span><span></span><span></span>
							</div>
						</div>
						<div class="share-wrapper isShare">
							<div class="share-container fl-wrap"></div>
						</div>
					</div>
				</div>
			</header>
			<div class="header-overlay close_cart-init"></div>
			<div class="content-section parallax-section hero-section hidden-section" data-scrollax-parent="true">
				<div class="bg par-elem " data-bg="templates/default/images/bg/1.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
				<div class="overlay"></div>
				<div class="container">
					<div class="section-title">
						<h4>Bienvenue sur le site de</h4>
						<h2>Bel-CMS</h2>
						<div class="section-separator"><span><i class="fa-regular fa-object-ungroup"></i></span></div>
					</div>
				</div>
				<div class="hero-section-scroll">
					<div class="mousey">
						<div class="scroller"></div>
					</div>
				</div>
				<div class="dec-corner dc_lb"></div>
				<div class="dec-corner dc_rb"></div>
				<div class="dec-corner dc_rt"></div>
				<div class="dec-corner dc_lt"></div>
			</div>
			<!-- section end  -->
			<!--content-->
			<div class="content">
				<!-- breadcrumbs-wrap  -->
				<div class="breadcrumbs-wrap">
					<div class="container">
						<a href="index.php" title="Home">Accueil</a><span><?=ucfirst($var->link);?></span> 
					</div>
				</div>
				<!--breadcrumbs-wrap end  -->
				<!-- section   -->
				<div class="content-section">
					<div class="section-dec"></div>
					<div class="content-dec2 fs-wrapper"></div>
					<div class="container">
						<div class="row">
						<?php
						if ($var->fullwide == true):
						?>
							<div class="col-lg-12">
								<div class="post-container">
									<div class="dec-container">
										<div class="text-block">
											<?=$var->page;?>
										</div>
									</div>
								</div>
							</div>
						<?php
						else:
						?>
							<div class="col-lg-8">
								<div class="post-container">
									<div class="dec-container">
										<div class="text-block">
											<?=$var->page;?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="main-sidebar fixed-bar">
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
						<?php
						endif;
						?>
					</div>
					<div class="limit-box"></div>
				</div>
				<!-- section end  -->
				<div class="content-dec"><span></span></div>
			</div>
			<div class="height-emulator"></div>
			<footer class="main-footer">
				<div class="footer-inner">
					<div class="container">
						<div class="footer-widget-wrap">
							<div class="footer-separator-wrap">
								<div class="footer-separator"><span></span></div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="footer-widget">
										<div class="footer-widget-title">À propos</div>
										<div class="footer-widget-content">
											<p>Un système de gestion de contenu, souvent abrégé en CMS (Content Management System), est un logiciel qui aide les utilisateurs à créer, gérer et modifier du contenu sur un site Web sans avoir besoin de connaissances techniques spécialisées.</p><p>Dans un langage plus simple, un système de gestion de contenu est un outil qui vous aide à construire un site Web sans avoir besoin d’écrire tout le code à partir de zéro (ou même de savoir comment coder du tout).</p>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="footer-widget">
										<div class="footer-widget-title">Contact info  </div>
										<div class="footer-widget-content">
											<div class="footer-contacts footer-box">
												<ul>
													<li><span>e-mail :</span><a title="Mail Bel-CMS" href="mailto:contact@bel-cms.dev">contact@bel-cms.dev</a></li>
													<li><span>Discord  :</span><a title="Discord Bel-CMS" href="https://discord.gg/mV7ZPZgR4z">discord.gg/mV7ZPZgR4z</a></li>
													<li><span>Whatsapp : </span><a href="https://wa.me/0455143124">+32(0)455.14.31.24</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="footer-widget">
										<div class="footer-widget-title">Helpful links</div>
										<div class="footer-widget-content">
											<div class="footer-list footer-box  ">
												<ul>
													<li><a href="#">Cookies</a></li>
													<li><a href="#">Contacts</a></li>
													<li><a href="#">Privacy Policy</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="footer-widget">
										<div class="footer-widget-title">S'abonner</div>
										<div class="footer-widget-content">
											<div class="subcribe-form">
												<p>Vous souhaitez être informé lorsque nous lançons une nouvelle version de mise à jour. Inscrivez-vous et nous vous enverrons une notification par e-mail.</p>
												<form id="subscribe">
													<input class="enteremail" name="email" id="subscribe-email" placeholder="Your Email" spellcheck="false" type="text">
													<button type="submit" id="subscribe-button" class="subscribe-button color-bg">Send </button>
													<label for="subscribe-email" class="subscribe-message"></label>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="footer-title-dec">Bel-CMS</div>
				</div>
				<div class="footer-social">
					<div class="container">
						<ul>
							<li><a href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="footer-bottom">
					<div class="container">
						<a href="index.php" class="footer-logo"><img src="templates/default/images/logo.png" alt=""></a>
						<div class="copyright">&#169; Bel-CMS 2015 - <?=date('Y');?>. All rights reserved. </div>
						<div class="to-top"><span>Back To Top </span><i class="fal fa-angle-double-up"></i></div>
					</div>
				</div>
			</footer>
		</div>
		<script  src="templates/default/js/jquery.min.js"></script>
		<script  src="templates/default/js/plugins.js"></script>
		<script  src="templates/default/js/scripts.js"></script>
		<?=$var->javaScript;?>
	</body>
</html>