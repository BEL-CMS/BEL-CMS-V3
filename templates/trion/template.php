<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<base href="<?=$this->base;?>">
		<meta charset="UTF-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title><?=$this->title;?> - <?=$this->page;?></title>
		<meta name="robots" content="index, follow">
		<meta name="keywords" content="cms, fr, bel-cms, palacewar, demo, github">
		<meta name="description" content="Content Management System">
		<?=$this->css;?>
		<link type="text/css" rel="stylesheet" href="templates/trion/css/plugins.css">
		<link type="text/css" rel="stylesheet" href="templates/trion/css/style.css">
		<link type="text/css" rel="stylesheet" href="templates/trion/css/color.css">
		<link rel="shortcut icon" href="templates/trion/images/favicon.ico">
	</head>
	<body>
		<!--loader-->
		<div class="main-loader-wrap">
			<div class="loader-spin"><span></span></div>
			<div class="loader-dec"></div>
		</div>
		<div id="main">
			<div class="progress-bar-wrap">
				<div class="progress-bar"></div>
			</div>
			<header class="main-header">
				<div class="logo-holder">
					<a href="https://bel-cms.dev">
						<img src="templates/trion/images/logo.png" alt="bel-cms-logo">
					</a>
				</div>
				<div class="nav-button-wrap vis-menbut">
					<div class="nav-button">
						<span></span><span></span><span></span>
					</div>
				</div>	
				<div class="share-button show-share">
					<i class="fa fa-bullhorn"></i><span>Share</span>
				</div>
			</header>
			<?php require_once 'menu.php'; ?>
			<div id="wrapper">
				<div class="content-holder" data-pagetitle="Project Single">
					<div class="content">
						<div class="column-content">
							<section>
								<?php
								if (strtolower($this->page) == 'articles'):
								?>
								<div class="wrap-inner fl-wrap sm-mar-w">
									<div class="container">
										<?=$this->tpl;?>
									</div>
									<div class="pattern-bg right-pos"></div>
									<div class="sec-dec"></div>
								</div>
								<?php
								else:
								?>
								<div class="wrap-inner fl-wrap">
									<div class="container">
										<?=$this->tpl;?>
									</div>
								</div>
								<?php
								endif;
								?>
							</section>
						</div>
					</div>
					<?php
					if (strtolower($this->page) == 'articles'):
					?>
					<footer class="main-footer fl-wrap">
						<div class="footer-wrap fl-wrap">
							<div class="footer-inner">
								<div class="row">
									<div class="col-md-7">
									</div>
								</div>
								<div class="policy-box fl-wrap">
									<span>2015 - &#169;Bel-CMS 2023  /  All rights reserved. </span>
								</div>
								<a class="to-top"><span>Back to Top</span><i class="fas fa-caret-up"></i></a>
							</div>
							<div class="footer-decor">
							</div>
						</div>
					</footer>
					<div class="share-wrapper">
						<div class="share-container isShare"></div>
					</div>
					<?php
					endif;
					?>
				</div>
			</div>
			<div class="circle-bg">
				<div class="middle-circle"></div>
				<div class="big-circle"></div>
				<div class="small-circle"></div>
			</div>
			<div class="element">
				<div class="element-item"></div>
			</div>
		</div>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-88923585-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-88923585-1');
		</script>  
		<?=$this->js;?>
		<script  src="templates/trion/js/jquery.min.js"></script>
		<script  src="templates/trion/js/plugins.js"></script>
		<script  src="templates/trion/js/scripts.js"></script>
	</body>
</html>