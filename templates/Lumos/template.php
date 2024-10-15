<?php
$var->link = strtolower($var->link);
$link = ucfirst($var->link);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<base href="<?=$var->host;?>">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_DESCRIPTION'];?>">
<meta name="author" content="Bel-CMS">
<link rel="shortcut icon" href="style/images/favicon.png">
<title><?=$_SESSION['CONFIG_CMS']['CMS_WEBSITE_NAME'];?> - <?=$var->link;?></title>
<?=$var->css;?>
<link href="templates/Lumos/style/css/bootstrap.min.css" rel="stylesheet">
<link href="templates/Lumos/style/css/plugins.css" rel="stylesheet">
<link href="templates/Lumos/style/css/prettify.css" rel="stylesheet">
<link href="templates/Lumos/style.css" rel="stylesheet">
<link href="templates/Lumos/style/css/color/green.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Raleway:400,800,700,600,500,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Libre+Baskerville:400,400italic' rel='stylesheet' type='text/css'>
<link href="templates/Lumos/style/type/fontello.css" rel="stylesheet">
<link href="templates/Lumos/style/type/budicons.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="style/js/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body class="full-layout">
<div id="preloader"><div id="status"><div class="spinner"></div></div></div>
<div class="body-wrapper">
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header"> <a class="btn responsive-menu" data-toggle="collapse" data-target=".navbar-collapse"><i></i></a>
			<div class="navbar-brand text-center"> <a href="index.php"><img src="templates/Lumos/style/images/logo.png" alt="" data-src="templates/Lumos/style/images/logo.png" data-ret="templates/Lumos/style/images/logo@2x.png" class="retina" /></a> </div>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="current"><a href="News" class="hint--right" data-hint="News"><i class="budicon-home-1"></i><span>News</span></a></li>
				<li><a href="Forum" class="hint--right" data-hint="Forum"><i class="budicon-image"></i><span>Forum</span></a></li>
				<li><a href="User" class="hint--right" data-hint="Utilisateur"><i class="budicon-author"></i><span>Utilisateur</span></a></li>
				<li><a href="Contact" class="hint--right" data-hint="Contact"><i class="budicon-profile"></i><span>Contact</span></a></li>
				<li><a href="#Socials" class="hint--right fancybox-inline" data-hint="Socials" data-fancybox-width="325" data-fancybox-height="220"><i class="icon-heart-empty-1"></i><span>Socials</span></a></li>
				<li><a href="?admin" class="hint--right" data-hint="administration"><i class="budicon-setting"></i><span>Administration</span></a></li>

			</ul>
		</div>
		<div id="Socials" style="display:none;">
			<h1>Socials</h1>
			<div class="divide20"></div>
			<ul class="social">
				<li><a href="#"><i class="icon-s-twitter"></i></a></li>
				<li><a href="#"><i class="icon-s-facebook"></i></a></li>
				<li><a href="#"><i class="icon-s-instagram"></i></a></li>
				<li><a href="#"><i class="icon-s-flickr"></i></a></li>
				<li><a href="#"><i class="icon-s-pinterest"></i></a></li>
				<li><a href="#"><i class="icon-s-linkedin"></i></a></li>
			</ul>
		</div>
	</nav>

	<div class="container inner">
		<div class="blog list-view row">
			<?php
			if ($var->fullwide === true):
			?>
				<div class="box">
					<?php echo $var->page; ?>
				</div>
			<?php
			else:
			?>
				<div class="col-md-8 col-sm-12 content">
					<?php
					if ($var->link == 'news'):
					echo $var->page;
					else:
					?>
					<div class="box">
						<?php echo $var->page; ?>
					</div>
					<?php
					endif;
					?>
				</div>
				<aside class="col-md-4 col-sm-12 sidebar">
				<?php
				if (isset($var->widgets['right'])):
					foreach ($var->widgets['right'] as $title => $content):
						echo $content['view'];
					endforeach;
				endif;
				?>
				</aside>
			<?php
			endif;
			?>
		</div>
	</div>
</div>
<?=$var->javaScript;?>
<script src="templates/Lumos/style/js/jquery.min.js"></script>
<script src="templates/Lumos/style/js/bootstrap.min.js"></script>
<script src="templates/Lumos/style/js/jquery.themepunch.tools.min.js"></script>
<script src="templates/Lumos/style/js/classie.js"></script>
<script src="templates/Lumos/style/js/plugins.js"></script>
<script src="templates/Lumos/style/js/scripts.js"></script>
<script>
	$.backstretch(["templates/Lumos/style/images/art/bg1.jpg"]);
</script>
</body>
</html>
