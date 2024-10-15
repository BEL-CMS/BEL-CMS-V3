<?php

use BelCMS\PDO\BDD;
use BelCMS\Requires\Common;
use BelCMS\User\User;
use BelCMS\Core\Comment;
use BelCMS\Core\Config;

date_default_timezone_set("Europe/Brussels");

function article () {
	$sql = new BDD;
	$sql->table('TABLE_ARTICLES_CONTENT');
	$sql->where(array('name' => 'id', 'value' => '12'));
	$sql->queryOne();
	return $sql->data;
}
function randImg () {
	$sql = new BDD;
	$sql->table('TABLE_GALLERY');
	$sql->orderby('ORDER BY rand() LIMIT 1', true);
	$sql->queryOne();
	return $sql->data->image;
}
$img = randImg();
function GUESTBOOK () {
	$sql = new BDD;
	$sql->table('TABLE_GUESTBOOK');
	$sql->limit(6);
	$sql->orderby('ORDER BY `'.TABLE_GUESTBOOK.'`.`id` DESC', true);
	$sql->queryAll();
	foreach ($sql->data as $value):
		$hash_key = User::getHashKey($value->author);
		$user     = User::getInfosUserAll($hash_key->hash_key);
	?>
	<div class="col-md-6 col-lg-4">
		<div class="testi-item">
			<p class="testi-item_text"><?=$value->message;?></p>
			<div class="testi-item_wrapp">
				<div class="testi-item_profile">
					<img style="width: 70px;height:70px" src="<?=$user->profils->avatar;?>" alt="testimonial">
				</div>
				<div class="media-body">
					<h3 class="box-title"><?=$value->author;?></h3>
					<span class="testi-item_desig"><?=$value->date_msg;?></span>
				</div>
			</div>
			<div class="testi-quote">
				<img src="templates/aseh/assets/img/icon/quote_3.svg" alt="">
			</div>
		</div>
	</div>
	<?php
	endforeach;
}
function news () {
	$sql = new BDD;
	$sql->table('TABLE_PAGES_NEWS');
	$sql->limit(3);
	$sql->orderby('ORDER BY `'.TABLE_PAGES_NEWS.'`.`id` DESC', true);
	$sql->queryAll();
	foreach ($sql->data as $value):

		$user = User::getInfosUserAll($value->author);
		if ($user == false) {
			$user = constant('MEMBER_DELETE');
		} else {
			$user = $user->user->username;
		}
		$countComment = Comment::countComments('news', $value->id);
		$filename = $value->img;
		if (!empty($filename) and is_file($filename)) {
			$img = $filename;
		} else {
			$img = 'templates/aseh/assets/img/bg_news.jpg';
		}
		$link = 'News/Readmore/'.$value->rewrite_name.'/'.$value->id;
	?>
	<div class="col-md-6 col-xl-4" style="height: 420px !important;display: flex;">
		<div class="blog-grid wow fadeInLeft">
			<div class="blog-img global-img">
				<img style="width: 387px;height: 184px" src="<?=$img;?>" alt="News_image_<?=$value->id;?>">
				<div class="blog-wrapper">
					<span class="blog-grid_date"><?=Common::TransformDate($value->date_create, 'MEDIUM', 'NONE');?></span>
				</div>
			</div>
			<div class="blog-grid_content">
				<div class="blog-meta">
					<a href="Members/profil/<?=$user;?>"><i class="fa-regular fa-user"></i>&emsp;<?=$user;?></a>
					<a href="blog.html"><i class="fa-regular fa-comments"></i>&emsp;<?=$countComment;?> Commentaire(s)</a>
				</div>
				<h3 class="box-title"><?=$value->name;?></h3>
				<a href="<?=$link;?>" class="th-btn border radius-none">Lire la news</a>
			</div>
		</div>
	</div>
	<?php
	endforeach;
}
function user () {
	$sql = new BDD;
	$sql->table('TABLE_USERS');
	$sql->limit(3);
	$sql->queryAll();
	foreach ($sql->data as $value):
		$user = User::getInfosUserAll($value->hash_key);
		$group = Config::getGroupsForID($user->groups->user_group);
		$groupName = defined($group->name) ? constant($group->name) : $group->name;
		?>
		<div class="col-sm-6 col-lg-4 col-xxl-3">
			<div class="th-team team-item wow fadeInUp">
				<div class="team-img">
					<img src="<?=$user->profils->avatar;?>" alt="Team">
				</div>
				<div class="team-item_content">
					<h3 class="box-title"><a href="team-details.html"><?=$user->user->username;?></a></h3>
					<span class="team-desig"><?=$groupName;?></span>
					<div class="team-social">
						<a href="<?=$user->social->facebook;?>"><i class="fab fa-facebook-f"></i></a>
						<a href="<?=$user->social->x_twitter;?>"><i class="fab fa-twitter"></i></a>
						<a href="<?=$user->social->linkedIn;?>"><i class="fab fa-linkedin-in"></i></a>
						<a href="<?=$user->social->whatsapp;?>"><i class="fa-brands fa-whatsapp"></i></a>
						<a href="<?=$user->social->discord;?>"><i class="fa-brands fa-discord"></i></a>
					</div>
				</div>
			</div>
		</div>
		<?php
	endforeach;
}
$link = defined(strtoupper($var->link)) ? constant(strtoupper($var->link)) : ucfirst($var->link);
?>
<!doctype html>
<html class="no-js" lang="fr">
<head>
	<base href="<?=$var->host;?>">
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>ASEH - <?=$var->link;?></title>
	<meta name="author" content="Determe Stive">
	<meta name="description" content="ASEH - Sauvetage pour tous">
	<meta name="keywords" content="ASEH, piscine, brevet, Sauvetage">
	<meta name="robots" content="INDEX,FOLLOW">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="180x180" href="templates/aseh/assets/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="templates/aseh/assets/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="templates/aseh/assets/img/favicons/favicon-16x16.png">
	<link rel="manifest" href="templates/aseh/assets/img/favicons/site.webmanifest">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800;9..40,900&family=Outfit:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
	<?=$var->css;?>
	<link rel="stylesheet" href="templates/aseh/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="templates/aseh/assets/css/fontawesome.min.css">
	<link rel="stylesheet" href="templates/aseh/assets/css/magnific-popup.min.css">
	<link rel="stylesheet" href="templates/aseh/assets/css/slick.min.css">
	<link rel="stylesheet" href="templates/aseh/assets/css/style.css">

</head>

<body onload="Launch();">

	<div class="preloader">
		<button class="th-btn preloaderCls">Annulé le Preloader </button>
		<div class="preloader-inner">
			<span class="loader"></span>
		</div>
	</div>

	<div class="th-menu-wrapper">
		<div class="th-menu-area">
			<div class="mobile-logo">
				<a href="index.php"><img src="templates/aseh/assets/img/logo/logo.png" alt="aseh_logo"></a>
				<div class="close-menu">
					<button class="th-menu-toggle"><i class="fal fa-times"></i></button>
				</div>
			</div>
			<div class="th-mobile-menu">
			<ul>
	<li><a href="index.php">Accueil</a></li>
	<li class="menu-item-has-children">
		<a href="#">Organisation<br>générale</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/23/ORGANISATION_objectifs">Nos objectifs</a></li>
			<li><a href="Articles/read/19/ORGANISATION_tarif">Tarifs</a></li>
			<li><a href="Articles/read/22/ORGANISATION_horaire">Horaires</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Règlements</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/13/R_O_I_">R.O.I.</a>
			<li><a href="#">Divers</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Sport</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/15/SPORT_initiation">Initiation</a></li>
			<li><a href="Articles/read/16/SPORT_perfectionnement">Perfectionnement</a></li>
			<li><a href="Articles/read/17/SPORT_Competition">Compétition</a></li>
			<li><a href="Articles/read/18/SPORT_Allure_Libre">Allure libre</a></li>
			<li><a href="Articles/read/21/SPORT_dopage">Dopage</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Sécuritaire</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/24/SECURITAIRE_sensibiliser_aux_gestes_qui_sauvent">Sensibiliation aux gestes qui sauvent</a></li>
			<li><a href="Articles/read/25/SECURITAIRE_entrainement_au_test_d_admission">Entrainement au test d'admission (BBSA/BSSA) + Validation</a></li>
			<li><a href="Articles/read/26/SECURITAIRE_preparation_a_l_examen_pratique">Préparation à l'examen pratique (BBSA/BSSA)</a></li>
			<li><a href="Articles/read/27/SECURITAIRE_entrainement_personnel">Entrainement personnel</a></li>
		</ul>
	</li>
	<li>
		<a href="Gallery">Galerie<br>photos</a>
	</li>
	<li>
		<a href="calendar">Agenda</a>
	</li>
</ul>
			</div>
		</div>
	</div>
	<div id="scrool">
		<div class="zone-annonce">
			<span class="annonce_content content1">
				<?=$_SESSION['CONFIG_CMS']['ALERT'];?>
			</span>
		</div>
	</div>
	<div class="sidemenu-wrapper d-none d-lg-block ">
		<div class="sidemenu-content bg-black2">
			<button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
			<div class="widget footer-widget">
				<div class="th-widget-about">
					<div class="about-logo">
						<a href="index.php"><img src="templates/aseh/assets/img/logo/logo.png" alt="aseh_logo"></a>
					</div>
					<p class="about-text">
						Le ASEH entraîne au sauvetage sportif et sensibilise aux gestes qui sauvent.<br>
						Nous collaborons également aux formations de la LFBS.
					</p>

					<div class="th-social  footer-social">
						<a class="belcms_tooltip_bottom" data="Facebook" href="https://www.facebook.com/0ASEH"><i class="fab fa-facebook-f"></i></a>
						<a class="belcms_tooltip_bottom" data="E-mail" href="https://webmail.determe.be"><i class="fa-solid fa-envelopes-bulk"></i></a>
						<a class="belcms_tooltip_bottom" data="Administration" href="?admin"><i class="fa-solid fa-gears"></i></a>
					</div>
				</div>
			</div>
			<p>Bientôt une newsletter pour vous tenir informés sur la vie du club.
		</div>
	</div>

	<?php if (strtolower($var->link) == 'news' and $var->fullwide == 0): ?>
	<header class="th-header header-layout9">
		<div class="sticky-wrapper">
			<div class="menu-area">
				<div class="container th-container">
					<div class="row justify-content-between align-items-center">
						<div class="col-auto">
							<div class="header-logo">
								<a href="index.php"><img src="templates/aseh/assets/img/logo/logo.png" alt="Logo"></a>
							</div>
						</div>
						<div class="col-auto">
							<nav class="main-menu d-none d-lg-inline-block">
							<ul>
	<li><a href="index.php">Accueil</a></li>
	<li class="menu-item-has-children">
		<a href="#">Organisation<br>générale</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/23/ORGANISATION_objectifs">Nos objectifs</a></li>
			<li><a href="Articles/read/19/ORGANISATION_tarif">Tarifs</a></li>
			<li><a href="Articles/read/22/ORGANISATION_horaire">Horaires</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Règlements</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/13/R_O_I_">R.O.I.</a>
			<li><a href="#">Divers</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Sport</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/15/SPORT_initiation">Initiation</a></li>
			<li><a href="Articles/read/16/SPORT_perfectionnement">Perfectionnement</a></li>
			<li><a href="Articles/read/17/SPORT_Competition">Compétition</a></li>
			<li><a href="Articles/read/18/SPORT_Allure_Libre">Allure libre</a></li>
			<li><a href="Articles/read/21/SPORT_dopage">Dopage</a></li>
		</ul>
	</li>
	<li class="menu-item-has-children">
		<a href="#">Sécuritaire</a>
		<ul class="sub-menu">
			<li><a href="Articles/read/24/SECURITAIRE_sensibiliser_aux_gestes_qui_sauvent">Sensibiliation aux gestes qui sauvent</a></li>
			<li><a href="Articles/read/25/SECURITAIRE_entrainement_au_test_d_admission">Entrainement au test d'admission (BBSA/BSSA) + Validation</a></li>
			<li><a href="Articles/read/26/SECURITAIRE_preparation_a_l_examen_pratique">Préparation à l'examen pratique (BBSA/BSSA)</a></li>
			<li><a href="Articles/read/27/SECURITAIRE_entrainement_personnel">Entrainement personnel</a></li>
		</ul>
	</li>
	<li>
		<a href="Gallery">Galerie<br>photos</a>
	</li>
	<li>
		<a href="calendar">Agenda</a>
	</li>
</ul>
							</nav>
						</div>
						<div class="col-auto ml-20">
							<div class="header-button">
								<button class="belcms_tooltip_bottom icon-btn d-inline-block" data="Se loguer / S'inscrire" onclick="window.location.href='User'"><i class="fa-solid fa-user"></i></button>
								<a href="Contact" class="th-btn">Nous contacter</a>
								<a href="#" class="icon-btn sideMenuToggler d-none d-lg-block"><img src="templates/aseh/assets/img/update_4/icon/bars.svg" alt=""></a>
								<button class="icon-btn th-menu-toggle d-inline-block d-lg-none"><i class="far fa-bars"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<?php else: ?>
    <div class="th-menu-wrapper">
        <div class="th-menu-area">
            <div class="mobile-logo">
                <a href="index.php"><img src="templates/aseh/assets/img/logo/logo.png" alt="ASEH_LOGO"></a>
                <div class="close-menu">
                    <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
                </div>
            </div>
            <div class="th-mobile-menu">
			<ul>
        <li><a href="index.php">Accueil</a></li>
        <li class="menu-item-has-children">
            <a href="#">Organisation<br>générale</a>
            <ul class="sub-menu">
                <li><a href="#">Nos objectifs</a></li>
                <li><a href="service.html">Tarifs</a></li>
                <li><a href="#">Horaires</a></li>
            </ul>
        </li>
        <li class="menu-item-has-children">
            <a href="#">Règlements</a>
			<ul class="sub-menu">
				<li><a href="Articles/read/9/ROI">R.O.I.</a>
				<li><a href="#">Divers</a></li>
			</ul>
        </li>
		<li class="menu-item-has-children">
            <a href="#">Sport</a>
			<ul class="sub-menu">
				<li><a href="#">Initiation</a></li>
				<li><a href="#">Perfectionnement</a></li>
				<li><a href="">Compétition</a></li>
				<li><a href="">Allure libre</a></li>
				<li><a href="#">Dopage</a></li>
            </ul>
        </li>
		<li class="menu-item-has-children">
            <a href="#">Sécuritaire</a>
            <ul class="sub-menu">
			<li><a href="Articles/read/24/SECURITAIRE_sensibiliser_aux_gestes_qui_sauvent">Sensibiliation aux gestes qui sauvent</a></li>
			<li><a href="Articles/read/25/SECURITAIRE_entrainement_au_test_d_admission">Entrainement au test d'admission (BBSA/BSSA) + Validation</a></li>
			<li><a href="Articles/read/26/SECURITAIRE_preparation_a_l_examen_pratique">Préparation à l'examen pratique (BBSA/BSSA)</a></li>
			<li><a href="Articles/read/27/SECURITAIRE_entrainement_personnel">Entrainement personnel</a></li>
            </ul>
        </li>
		<li>
			<a href="Gallery">Galerie<br>photos</a>
		</li>
		<li>
			<a href="calendar">Agenda</a>
		</li>
    </ul>
            </div>
        </div>
    </div>
    <div class="popup-search-box d-none d-lg-block">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <header class="th-header  header-layout6">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-xl-between align-items-center gy-2">
                    <div class="col-auto">
                        <p class="header-notice">Bienvenue sur le site de ASEH <i style="font-size: 8;">A.S.B.L</i></p>
                    </div>
                    <div class="col-auto">
                        <div class="header-links style2">
                            <ul>
                                <li><i class="fa-solid fa-envelope-open-text"></i>&ensp;<a href="mailto:contact@aseh.be">contact@aseh.be</a></li>
                                <li><i class="fa-light fa-clock"></i>&ensp;<div id="localtime"></div></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-lg-inline-block">
                                    <div class="langauge">
                                        <select class="form-select nice-select">
                                            <option selected="">Français</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="header-social">
                                        <span class="social-title">Suivez-nous sur:</span>
                                        <a href="https://www.facebook.com/0ASEH"><i class="fab fa-facebook-f"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sticky-wrapper">
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="index.php"><img src="templates/aseh/assets/img/logo/logo.png" alt="logo_aseh"></a>
                            </div>
                        </div>
                        <div class="col-auto">
							<?php include_once 'main_menu.php'; ?>
                        </div>
                        <div class="col-auto ml-20">
                            <div class="header-button">
                                <div class="info-card">
                                    <div class="info-card_icon">
                                        <i class="fal fa-phone"></i>
                                    </div>
                                    <div class="info-card_content">
                                        <p class="info-card_text">Numéro de téléphone:</p>
                                        <a href="tel:+32 493 630265" class="info-card_link">0493 630265</a>
                                    </div>
                                </div>
                                <button class="icon-btn th-menu-toggle d-inline-block d-lg-none"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
	<?php endif; ?>

	<?php if (strtolower($var->link) == 'news' and $var->fullwide == 0): ?>
	<div class="th-hero-wrapper hero-11">
		<div class="th-hero-bg" data-bg-src="templates/aseh/assets/img/update_4/hero/hero_bg_3.jpg"></div>
		<div class="hero-shape11"></div>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-lg-10">
					<div class="hero-style11">
						<div class="hero-subtitle">Rejoignez l'ASEH <i style="font-size: 8px;">A.S.B.L.</i></div>
						<h1 class="hero-title">Sauvetage pour tous !</h1>
						<p class="hero-text"><h6 style="color:#FFF;">Association des Sauveteurs du Est Hainaut <i style="font-size: 12px;">A.S.B.L.</i></h6></p>
						<div class="hero11-shape"></div>
					</div>
				</div>
				<div class="col-lg-2 text-center">
					<a id="screen_rand" class="glightbox" href="<?=$img;?>">
						<img src="<?=$img;?>" alt="aleatoire image">
					</a>
				</div>
			</div>
		</div>
		<div class="social-links-wrap">
			<div class="top-line"><img src="templates/aseh/assets/img/update_4/shape/star-line.png" alt=""></div>
			<div class="social-links">
				<a href="https://www.facebook.com/0ASEH"><img src="templates/aseh/assets/img/update_4/icon/facebook.svg" alt=""></a>
			</div>
		</div>
	</div>
	<div class="title-area text-center" style="margin: 20px auto;">
		<span class="sub-title">Accueil</span>
		<?php 
		$data = article(); 
		echo $data->content;
		?>
		
	</div>
	</section>
	<section class="blog-sec space overflow-hidden" id="blog-sec" data-bg-src="templates/aseh/assets/img/bg/blog_bg_1.jpg">
		<div class="container">
			<div class="title-area text-center">
				<h2 class="sec-title">Nos dernières nouvelles et mises à jour</h2>
			</div>
			<div class="row slider-shadow th-carousel" id="blogSlide3" data-slide-show="3" data-lg-slide-show="2" data-md-slide-show="1" data-sm-slide-show="1" data-arrows="true">
				<?php news(); ?>
			</div>
		</div>
	</section>
	<div class="about-sec overflow-hidden space" id="about-sec">
		<div class="container align-item-center">
			<div class="row">
				<div class="col-xl-6">
					<div class="img-box3">
						<div class="img3 wow fadeInUp">
							<img src="templates/aseh/assets/img/normal/about_3_1.jpg" alt="About">
						</div>
						<div class="img4 wow fadeInRight">
							<img src="templates/aseh/assets/img/normal/about_3_2.jpg" alt="About">
						</div>
						<div class="th-experience style2">
							<p class="experience-text">Plusieurs années d'expérience dans le service de sauvetage.</p>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="ps-xl-5 ms-xl-4 wow fadeInUp">
						<div class="title-area mb-40">
							<span class="sub-title style1">ASEH</span>
							<h2 class="sec-title">À LA DÉCOUVERTE DE ASEH</h2>
							<p>Le ASEH entraîne au sauvetage sportif et sensibilise aux gestes qui sauvent.<br>
							Nous collaborons également aux formations de la LFBS.</p>
							<p>Bassin Sportif de 25 mètres : Que tu sois un nageur chevronné ou un débutant, notre bassin de 25 mètres avec ses 5 couloirs sera parfait pour t'entraîner et perfectionner ta technique.</p>
						</div>
						<div class="achive-about-wrap">
							<div class="achive-about">
								<div class="achive-about_icon">
									<img src="templates/aseh/assets/img/icon/about_1_1.svg" alt="icon">
								</div>
								<div class="media-body">
									<h3 class="box-title">Sport</h3>
									<p class="achive-about_text">Perfectionnement<br>Compétition</p>
								</div>
							</div>
							<div class="achive-about">
								<div class="achive-about_icon">
									<img src="templates/aseh/assets/img/icon/about_1_2.svg" alt="icon">
								</div>
								<div class="media-body">
									<h3 class="box-title">Sécuritaire</h3>
									<p class="achive-about_text">Préparation à la formation BBSA/BBSA</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<section class="overflow-hidden space">
		<div class="container">
			<div class="title-area text-center">
				<span class="sub-title">Témoignages</span>
				<h2 class="sec-title">Témoignages de nos membres</h2>
			</div>
			<div class="row testi-slide2 slider-shadow th-carousel" id="testiSlide1" data-slide-show="3" data-lg-slide-show="2" data-sm-slide-show="1" data-xs-slide-show="1">
				<?php GUESTBOOK() ?>
			</div>
		</div>
	</section>

    <div class="brand-area3 overflow-hidden space-top space-bottom">
        <div class="container">
            <div class="title-area text-center">
                <span class="brand-title">
                    <span class="counter-card_number"><span class="counter-title">Nos partenaires</span></span>
                </span>
            </div>
            <div class="row brand-slide3 th-carousel" data-slide-show="5" data-lg-slide-show="4" data-md-slide-show="3" data-sm-slide-show="2" data-xs-slide-show="2">
                <div class="col-auto brand-card wow fadeInLeft">
					<a href="https://bel-cms.dev" title="Bel-CMS" target="_blank">
                    	<img src="templates/aseh/assets/img/brand/brand_1_1.png" alt="Bel-CMS Logo">
					</a>
                </div>
                <div class="col-auto brand-card  wow fadeInLeft">
					<a href="https://aisf.be" target="_blank" title="aisf">
                    	<img src="templates/aseh/assets/img/brand/brand_1_2.png" alt="aisf">
					</a>
                </div>
                <div class="col-auto brand-card  wow fadeInLeft">
					<a href="https://www.teambelgium.be/fr target="_blank" title="teambelgium">
                    	<img src="templates/aseh/assets/img/brand/brand_1_3.png" alt="teambelgium">
					</a>
                </div>
                <div class="col-auto brand-card  wow fadeInLeft">
					<a href="https://europe.ilsf.org/" target="_blank">
                    	<img src="templates/aseh/assets/img/brand/brand_1_4.png" alt="europe.ilsf">
					</a>
                </div>
                <div class="col-auto brand-card  wow fadeInLeft">
					<a href="https://lfbs.org/" target="_blank">
                   	 	<img src="templates/aseh/assets/img/brand/brand_1_5.png" alt="L.F.B.S. Logo">
					</a>
                </div>
            </div>
        </div>
    </div>

	<div class="contact-info-area" data-pos-for=".footer-layout3" data-sec-pos="bottom-half" style="margin-bottom: -77px;">
		<div class="container">
			<div class="row gx-0 align-items-center">
				<div class="col-xl-3">
					<div class="contact-media style1">
						<div class="contact-logo">
							<img src="templates/aseh/assets/img/logo/logo.png" alt="icon">
						</div>
					</div>
				</div>
				<div class="col-xl-9">
					<div class="contact-media-wrapp">
						<div class="contact-media bg-theme">
							<div class="contact-media_icon">
								<img src="templates/aseh/assets/img/icon/contact_1_1.svg" alt="icon">
							</div>
							<div class="contact-media_content">
								<span class="contact-media_subtitle">Téléphone du responsable.</span>
								<h3 class="contact-media_title"><a href="tel:0493630265">0493/63.02.65</a></h3>
							</div>
						</div>
						<div class="contact-media">
							<div class="contact-media_icon">
								<img src="templates/aseh/assets/img/icon/contact_1_2.svg" alt="icon">
							</div>
							<div class="contact-media_content">
								<p class="contact-media_subtitle">Email pour toute information.</p>
								<a href="mailto:contact@aseh.be" class="contact-media_title">contact@aseh.be</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php else: ?>
		<div class="breadcumb-wrapper " data-bg-src="templates/aseh/assets/img/breadcumb/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h2 class="breadcumb-title"><?=$link;?></h2>
                <div class="breadcumb-menu-wrapper">
                    <ul class="breadcumb-menu">
                        <li><a href="index.php">Home</a></li>
                        <li><?=$var->link;?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="animation-bubble">
            <div class="bubble-1"></div>
            <div class="bubble-2"></div>
            <div class="bubble-3"></div>
            <div class="bubble-4"></div>
            <div class="bubble-5"></div>
            <div class="bubble-6"></div>
            <div class="bubble-7"></div>
            <div class="bubble-8"></div>
            <div class="bubble-9"></div>
            <div class="bubble-10"></div>
        </div>
    </div> 
	<section class="space-top space-extra2-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="course-single">
                        <div class="course-single-top">
							<?php
							echo $var->page;
							?>
                    	</div>
                	</div>
            	</div>
			</div>
        </div>
    </section>
	<?php endif; ?>
	<footer class="footer-wrapper footer-layout3" data-bg-src="templates/aseh/assets/img/update_3/bg/footer_bg_1.jpg">
		<div class="widget-area">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-md-6 col-xl-2">
						<div class="widget footer-widget">
							<h3 class="widget_title">Sport</h3>
							<div class="th-widget-about">
								<p class="about-text">
									.&ensp;Initiation<br>
									.&ensp;Perfectionnement<br>
									.&ensp;Compétition<br>
									.&ensp;Nage en "allure libre"
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-4">
						<div class="widget footer-widget">
							<h3 class="widget_title">Sécuritaire</h3>
							<div class="th-widget-about">
								<p class="about-text">
									.&ensp;Initiation au geste qui sauvent<br>
									.&ensp;Préparation à la formation BBSA / BSSA<br>
									.&ensp;Entrainement personnel<br>
									.&ensp;Passage et validation du test d'admission
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-auto">
						<div class="widget footer-widget footer-widget">
						<?php
						if (isset($var->widgets['bottom'])):
							foreach ($var->widgets['bottom'] as $title => $content):
								echo $content['view'];
							endforeach;
						endif
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright-wrap">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12">
						<p class="copyright-text text-white">2024 <a class="text-white" href="http://www.aseh.be/">ASEH</a>. All Rights Reserved. - Via <a class="text-white" href="https://bel-cms.dev" title="Bel-CMS">© Bel-CMS V3</a>
						<i style="float: right;">Page générée en <span class="belcms_genered"></span> secondes.</i>
						</p>
					</div>
				</div>
			</div>
		</div>

		<div class="scroll-top">
			<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
				</path>
			</svg>
		</div>
		<div class="animation-bubble style4">
			<div class="bubble-1"></div>
			<div class="bubble-2"></div>
			<div class="bubble-3"></div>
			<div class="bubble-4"></div>
			<div class="bubble-5"></div>
			<div class="bubble-6"></div>
			<div class="bubble-7"></div>
			<div class="bubble-8"></div>
			<div class="bubble-9"></div>
			<div class="bubble-10"></div>
		</div>
	</footer>
	<?=$var->javaScript;?>
	<script src="templates/aseh/assets/js/vendor/jquery-3.6.0.min.js"></script>
	<script src="templates/aseh/assets/js/slick.min.js"></script>
	<script src="templates/aseh/assets/js/bootstrap.min.js"></script>
	<script src="templates/aseh/assets/js/isotope.pkgd.min.js"></script>
	<script src="templates/aseh/assets/js/jquery.magnific-popup.min.js"></script>
	<script src="templates/aseh/assets/js/jquery-ui.min.js"></script>
	<script src="templates/aseh/assets/js/imagesloaded.pkgd.min.js"></script>
	<script src="templates/aseh/assets/js/odometer.js"></script>
	<script src="templates/aseh/assets/js/nice-select.min.js"></script>
	<script src="templates/aseh/assets/js/circle-progress.js"></script>
	<script src="templates/aseh/assets/js/jquery.ripples.js"></script>
	<script src="templates/aseh/assets/js/main.js"></script>
	<script type='text/javascript'>
		var TabMois=new Array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre') 
		var ComputerDate;
		function perpetualDate(){
		ComputerDate=new Date();
		var Annee=ComputerDate.getUTCFullYear();
		var Jour=ComputerDate.getUTCDate();
		var Mois=ComputerDate.getUTCMonth();
		var Heure=ComputerDate.getUTCHours();
		var Minutes=ComputerDate.getUTCMinutes();
		Heure = Heure +2;
		Minutes = Minutes > 9 ? Minutes : '0' + Minutes;
		var Secondes=ComputerDate.getUTCSeconds();
			document.getElementById('localtime').innerHTML=Jour+' '+TabMois[Mois]+' '+Annee+',  '+Heure+'h '+Minutes+' et '+Secondes+' s';
		}
		function Launch(){
			setInterval(function(){perpetualDate()},1000);
		}
	</script>
	<div id="endloading">
	<?php
	$time = (microtime(true) - $_SESSION['SESSION_START']);
	echo round($time, 3);?>
	</div>
	<script type='text/javascript'>
		$(window).on("load", function () {
			var endloading = $('#endloading').text();
			$('.belcms_genered').append(endloading);
		});
	</script>
</head> 
</body>
</html>