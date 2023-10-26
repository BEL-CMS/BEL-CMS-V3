<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7" lang="fr"> <![endif]-->
<!--[if IE 8 ]><html class="ie8" lang="fr"> <![endif]-->
<!--[if IE 9 ]><html class="ie9" xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR">
<!--<![endif]-->
<head>
	<title>Bel-CMS | Default - <?=ucfirst($var->link);?></title>
	<base href="<?=$var->host;?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Seo Meta -->
	<meta name="description" content="Default template by https://bel-cms.dev">
	<meta name="keywords" content="template, cms, bel-cms, css3, html5">
	<!-- Styles -->
	<?=$var->css;?>
	<link rel="stylesheet" type="text/css" href="templates/default/bootstrap/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="templates/default/bootstrap/css/bootstrap-responsive.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="templates/default/styles/icons/icons.css" media="screen">
	<link rel="stylesheet" type="text/css" href="templates/default/style.css" id="dark" media="screen">
	<link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Oswald'>
	<!-- Favicon -->
	<link rel="shortcut icon" href="templates/default/images/favicon.ico">
	<link rel="apple-touch-icon" href="templates/default/images/apple-touch-icon.png">
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=EmulateIE8; IE=EDGE">
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/icons/font-awesome-ie7.min.css">
	<![endif]-->
</head>
<body id="fluidGridSystem">
	<div id="layout" class="full">
		<!-- popup login -->
			<div id="popupLogin">
				<div class="def-block widget">
					<h4> Sign In </h4><span class="liner"></span>
					<div class="widget-content row-fluid">
						<form id="popup_login_form">
							<input type="text" name="login_username" id="login_username" onfocus="if (this.value=='username') this.value = '';" onblur="if (this.value=='') this.value = 'username';" value="username" placeholder="username">
							<input type="password" name="login_password" id="login_password" onfocus="if (this.value=='password') this.value = '';" onblur="if (this.value=='') this.value = 'password';" value="password" placeholder="password">
							<a href="#" class="tbutton small"><span>Sign In</span></a>
							<a href="#" class="tbutton color2 small"><span>Register</span></a>
						</form>
					</div>
				</div>
				<div id="popupLoginClose">x</div>
			</div>
			<div id="LoginBackgroundPopup"></div>

		<header id="header" class="glue">
			<div class="row clearfix">
				<div class="little-head">
					<div id="Login_PopUp_Link" class="sign-btn tbutton small"><span>Sign In</span></div>
					<?php
					/* <!-- Social menu --> -->*/
					include 'templates/default/social.php';
					?>
					<!-- non implenter : Social menu -->
					<div class="search">
						<form action="#search" id="search" method="get">
							<input id="inputhead" name="search" type="text" onfocus="if (this.value=='Start Recherche...') this.value = '';" onblur="if (this.value=='') this.value = 'Start Recherche...';" value="Start Recherche..." placeholder="Start Recherche...">
							<button type="submit"><i class="icon-search"></i></button>
						</form>
					</div>
				</div>
			</div>

			<div class="headdown">
				<div class="row clearfix">
					<div class="logo bottomtip" title="Best Template default by Bel-CMS">
						<a href="https://bel-cms.dev">
							<img src="templates/default/images/logo.png" alt="Bel-CMS.dev">
						</a>
					</div>

					<?php
					/* Menu personnalisable depuis l'administration */
					include 'templates/default/nav.php';
					?>
				</div>
			</div>
		</header>

		<div class="under_header">
			<img src="templates/default/images/assets/breadcrumbs4.png" alt="#">
		</div>

		<div class="page-content left-sidebar back_to_up">
			<?php
			include 'templates/default/breadcrumb.php';
			?>
			<div class="row row-fluid clearfix mbf">
				<?php
				if ($var->fullwide === true):
				?>
				<div class="">
					<div class="def-block">
				<?php
						echo $var->page;
				?>
					</div>
				</div>
				<?php
				else:
				?>
				<div class="span8 posts">
					<div class="def-block">
						<?php
						/* Les pages se trouvent ici Articles, downloads, etc...*/
						echo $var->page;
						?>
					</div>
				</div>
				<?php
				endif;
				if ($var->fullwide !== true):
				?>
				<div class="span4 sidebar">
					<?php
					foreach ($var->widgets['left'] as $widget):
						echo $widget;
					endforeach;
					?>
					<div class="def-block widget">
						<h4> NewsLetters </h4><span class="liner"></span>
						<div class="widget-content">
							<p>Pour suivre nos avancées en matière de CMS.</p>
							<p>Non implémenté dans cette version du C.M.S, désolé.</p>
							<form id="newsletters" method="post" action="http://feedburner.google.com/fb/a/mailverify" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=sevenpsd', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
								<input type="email" onfocus="if (this.value=='tapez votre e-mail') this.value = '';" onblur="if (this.value=='') this.value = 'tapez votre e-mail';" value="tapez votre e-mail" placeholder="tapez votre e-mail" required="required">
								<button type="submit"><i class="icon-ok"></i></button>
							</form>
						</div>
					</div>

					<div class="def-block widget">
						<h4> Tags </h4><span class="liner"></span>
						<div class="widget-content tags">
							<?php
							include 'templates/default/tags.php';
							?>
						</div>
					</div>

					<div class="def-block widget">
						<h4>PalaceWaR</h4><span class="liner"></span>
						<div class="widget-content tac">
							<a href="https://palacewar.eu" title="PalaceWaR">
								<img src="templates/default/images/palacewar.png" alt="PalaceWaR">
							</a>
						</div>
					</div>

				</div>
				<?php
				endif;
				?>
			</div>
		</div>

		<footer id="footer">
			<div class="footer-last">
				<div class="row clearfix">
					<span class="copyright">© 2023 by <a href="https://bel-cms.dev">Bel-CMS</a>. All Rights Reserved.</span>
					<div id="toTop"><i class="icon-angle-up"></i></div>
					<div class="foot-menu">
						<ul>
							<li><a href="Articles">Articles</a></li>
							<li><a href="Downloads">Téléchargements</a></li>
							<li><a href="Pages">Pages</a></li>
							<li><a href="Gallery">Photo</a></li>
							<li>
							<script type="text/javascript">
								var email = 'bel-cms.dev';
								email = ('admin' + '@' + email);
								document.write('<a href="mailto:' + email + '">' + email + '</a>');
							</script>
							</li>
						</ul>
					</div>
				</div>
			</div>

		</footer>

	</div>
	<?=$var->javaScript;?>
	<script type="text/javascript" src="templates/default/js/jquery.min.js"></script>
	<script type="text/javascript" src="templates/default/js/codevz.js"></script>
	<script type="text/javascript" src="templates/default/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="templates/default/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="templates/default/js/jquery.flexslider-min.js"></script>
	<script type="text/javascript" src="templates/default/js/jquery.nicescroll.min.js"></script>
	<script type="text/javascript" src="templates/default/js/twitter/jquery.tweet.js"></script>
	<script type="text/javascript" src="templates/default/js/custom.js"></script>
</body>
</html>