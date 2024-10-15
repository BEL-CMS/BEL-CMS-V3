<?php
use BelCMS\User\User;
$link = defined(strtoupper($var->link)) ? constant(strtoupper($var->link)) : ucfirst($var->link);
?>
<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<base href="<?=$var->host;?>">
		<meta charset="UTF-8">
		<title>Web-Help - <?=$link;?></title>
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="astuce, web, php, html, jquery">
		<meta name="description" content="Astuce Web">
		<?=$var->css;?>
		<link type="text/css" rel="stylesheet" href="templates/gmag/css/plugins.css">
		<link type="text/css" rel="stylesheet" href="templates/gmag/css/style.css">
		<link type="text/css" rel="stylesheet" href="templates/gmag/css/color.css">
		<link rel="apple-touch-icon" sizes="152x152" href="templates/gmag/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="templates/gmag/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="templates/gmag/favicon/favicon-16x16.png">
		<link rel="manifest" href="templates/gmag/favicon/site.webmanifest">
		<link rel="mask-icon" href="templates/gmag/favicon/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="theme-color" content="#ffffff">
	</head>
	<body>
		<!-- main start  -->
		<div id="main">
			<div class="progress-bar-wrap">
				<div class="progress-bar color-bg"></div>
			</div>
			<header class="main-header">
				<div class="top-bar fl-wrap">
					<div class="container">
						<div class="date-holder">
							<span class="date_num"></span>
							<span class="date_mounth"></span>
							<span class="date_year"></span>
						</div>
						<div class="header_news-ticker-wrap">
							<div class="hnt_title">Hot News :</div>
							<div class="header_news-ticker fl-wrap">
								<ul>
									<li><a href="#">Bienvenue sur Web-Help.</a></li>
								</ul>
							</div>
							<div class="n_contr-wrap">
								<div class="n_contr p_btn"><i class="fas fa-caret-left"></i></div>
								<div class="n_contr n_btn"><i class="fas fa-caret-right"></i></div>
							</div>
						</div>
						<ul class="topbar-social">
							<li><a href="https://www.facebook.com/web.help.dev" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="?admin"><i class="fa-solid fa-gears"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="header-inner fl-wrap">
					<div class="container">
						<a href="index.php" class="logo-holder"><img src="templates/gmag/images/logo.png" alt=""></a>
						<div class="srf_btn htact show-reg-form"><a href="User" title="Centre utilisateur"><i class="fal fa-user"></i> </div>
						<div class="nav-button-wrap">
							<div class="nav-button">
								<span></span><span></span><span></span>
							</div>
						</div>
						<?php include 'menu.php';?>
					</div>
				</div>
			</header>
			<div id="wrapper">
				<div class="content">
					<div class="breadcrumbs-header fl-wrap">
						<div class="container">
							<div class="breadcrumbs-header_url">
								<a href="index.php">Home</a><span><?=$link;?></span>
							</div>
							<div class="scroll-down-wrap">
								<div class="mousey">
									<div class="scroller"></div>
								</div>
								<span>Faites défiler vers le bas</span>
							</div>
						</div>
						<div class="pwh_bg"></div>
					</div>
					<section>
						<div class="container">
							<div class="row">
								<?php
								if ($var->fullwide == true):
								?>
								<div class="col-md-12">
									<?=$var->page;?>
								</div>
								<?php
								else:
								?>
								<div class="col-md-8">
									<?=$var->page;?>
								</div>
								<div class="col-md-4">
									<div class="sidebar-content fl-wrap fixed-bar">
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
							<div class="limit-box fl-wrap"></div>
						</div>
					</section>
					<div class="gray-bg ad-wrap fl-wrap">
						<div class="content-banner-wrap">
						<iframe src="https://www.netvisiteurs.com/promotion-31343.php" style="height:60px;width:468px;border:none" scrolling="no" frameborder="0" referrerpolicy="unsafe-url" width="468" height="60"></iframe>
						</div>
					</div>
				</div>
				<footer class="fl-wrap main-footer">
					<div class="container">
						<div class="footer-widget-wrap fl-wrap">
							<div class="row">
								<div class="col-md-4">
									<div class="footer-widget">
									<div class="fb-page" data-href="https://www.facebook.com/web.help.dev" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/web.help.dev" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/web.help.dev">Web-Help</a></blockquote></div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="footer-widget">
										<div class="footer-widget-title">Categories </div>
										<div class="footer-widget-content">
											<div class="footer-list footer-box fl-wrap">
												<ul>
													<li> <a href="#">Terms & Conditions</a></li>
													<li> <a href="#">Privacy Policy</a></li>
													<li> <a href="#">Coockies</a></li>
													<li> <a href="Contact">Contact</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="footer-widget">
										<div class="footer-widget-title">Links</div>
										<div class="footer-widget-content">
											<div class="footer-list footer-box fl-wrap">
												<ul>
													<li> <a href="Forum" title="forum">Forum</a></li>
													<li> <a href="Downloads" title="Téléchargements">Téléchargements</a></li>
													<li> <a href="Donations" title="Dons">Donations</a></li>
													<li> <a href="Gallery">Galerie d'images</a></li>
													<li> <a href="guestbook" title="Livre d'Or">Guestbook</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="footer-widget">
										<div class="footer-widget-title">Subscribe</div>
										<div class="footer-widget-content">
											<div class="subcribe-form fl-wrap">
												<p>Vous souhaitez être informé lorsque nous lançons une nouvelle thématique. Inscrivez-vous et nous vous enverrons une notification par e-mail.</p>
												<form id="subscribe" class="fl-wrap">
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
					<div class="footer-bottom fl-wrap">
						<div class="container">
							<div class="copyright"><span>&#169; Web-help <?=date('Y');?></span> . All rights reserved. </div>
							<div class="to-top"> <i class="fas fa-caret-up"></i></div>
							<div class="subfooter-nav">
								<ul>
									<li><span style="color:red">Page généré en <span class="belcms_genered"></span></span></li>
								</ul>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
		<?=$var->javaScript;?>
		<div id="fb-root"></div>
		<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v20.0&appId=775024024656688" nonce="YCZynOCJ"></script>
		<script src="templates/gmag/js/plugins.js"></script>
		<script src="templates/gmag/js/scripts.js"></script>
		<div id="endloading"><?php $time = (microtime(true) - $_SESSION['SESSION_START']); echo round($time, 3);?> secondes</div>
		<script>
			$(window).on('load', function() {
				var endloading = $('#endloading').text();
				$('.belcms_genered').append(endloading);
			});
		</script>
	</body>
</html>